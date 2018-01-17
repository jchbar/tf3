<?php
/*
code_result:
-1: no hay soporte a curl
0: no hay conexion a internet
1: existe rif consultado
otherwise:
450:formato de rif invalido
452:rif no existe
seniat:
    nombre:[CADENA CON EL NOMBRE]
    agenteretensioniva:[SI|NO]
    contribuyenteiva:[SI|NO]
    tasa:[VACIO|ENTERO MONTO TASA]

session_start();
extract($_GET);
extract($_POST);
extract($_SESSION);

header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
	echo utf8_encode("<code_result>1</code_result>");
	echo utf8_encode("<message>ok</message>");
	echo utf8_encode("<nombreseniat>ssssssssss</nombreseniat>");
	echo "</resultados>";
// echo "<script type='text/javascript'>alert('Saludos.... se presume que halla fallado la electricidad anoche por lo que el sistema estará un poco lento por la revisión/sincronización de los discos duros');</script>";


*/
session_start();
$response_json=array('code_result'=>'', 'seniat'=>array());
if(function_exists('curl_init')){ // Comprobamos si hay soporte para cURL
       // $url="http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$_POST['pref_rif'].$_POST['rif_prove'];
	   $url="http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$_GET['rif'];
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_TIMEOUT, 10);
       curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
       $resultado = curl_exec ($ch);

       if($resultado){
               try{
                       if(substr($resultado,0,1)!='<')
                                throw new Exception($resultado);
                       $xml = simplexml_load_string($resultado);
                       if(!is_bool($xml)){
                               $elements=$xml->children('rif');
                               $seniat=array();
                               $response_json['code_result']=1;
                               foreach($elements as $indice => $node){
                                       $index=strtolower($node->getName());
                                       $seniat[$index]=(string)$node;
                               }
                               $response_json['seniat']=$seniat;
                       }
               }catch(Exception $e){
                       $result=explode(' ', $resultado, 2);
                       $response_json['code_result']=(int) $result[0];
		   }
       }else
	   {
               $response_json['code_result']=0;//No hay conexion a internet
	   }
}else
       $response_json['code_result']=-1;//No hay soporte a curl_php
header('Content-type: text/xml');
// header ('Cache-Control: no-store' , false);	
echo '<?xml version="1.0" encoding="utf-8"?>';
echo "<resultados_seniat>";
echo utf8_encode("<code_result>".$response_json['code_result']."</code_result>");
//	echo utf8_encode("<message>".mensaje($response_json['code_result']) . ' ' . $datos[1]."</message>");
echo utf8_encode("<message>".mensaje($response_json['code_result'])."</message>");
echo utf8_encode("<nombreseniat>".($seniat['nombre']==''?'NO SE PUDO ENCONTRAR RESULTADO':$seniat['nombre'])."</nombreseniat>");
//	if ($response_json['code_result'] == 1)
//		echo utf8_encode("<nombre>".$seniat['nombre']."</nombre>");
//	else echo utf8_encode("<nombre>".mensaje($response_json['code_result'])."</nombre>");
echo utf8_encode("<agenteretensioniva>".$seniat['agenteretencioniva']."</agenteretensioniva>");
echo utf8_encode("<contribuyenteiva>".$seniat['contribuyenteiva']."</contribuyenteiva>");
echo utf8_encode("<tasa>".$seniat['tasa']."</tasa>");
$_SESSION['rif']=$_GET['rif'];
if ($response_json['code_result']==1)
{
	include_once('../ClassCrud.php');
	$crud = new ClassCrud();
	$con = new ClassBasedeDatos();
	$con->conectar();
	$query="select count(riftimbre) as cuantos from timbresfiscales where riftimbre = '".$_GET['rif']."' group by riftimbre";
	$result=$con->consulta($query);
	$res=$con->fetch_assoc($result);
	if ($con->num_rows($result)>0)
		echo utf8_encode("<nrotramites>".$res['cuantos']."</nrotramites>");
	else echo utf8_encode("<nrotramites>0</nrotramites>");
	$con->desconectar();
}
//	echo utf8_encode("<obtencion_local>0</obtencion_local>");
echo "</resultados_seniat>";

// echo json_encode($response_json);
					   ////////////

	
function mensaje($valor)
{
	if ($valor == -1)
		return 'no hay soporte a CURL';
	if ($valor == 0)
		return 'No hay conexion a internet';
	if ($valor == 1)
		return 'OK';
	if ($valor == 452)
		return 'RIF no existe';
	if ($valor == 450)
		return 'Formato de RIF invalido';
}


?>
