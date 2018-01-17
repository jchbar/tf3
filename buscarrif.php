<?php
session_start();
extract($_GET);
extract($_POST);
extract($_SESSION);

$obtenido_local=0;
// include("conex.php");
/*
require("final.php");
$link = @mysql_connect($Servidor,$Usuario, $Password,'',65536) or die ("<p /><br /><p /><div style='text-align:center'>En estos momentos no hay conexi&#243;n con el servidor, int&#233;ntalo m&#225;s tarde.</div>");
// echo 'link '.$link;
mysql_select_db($BasedeDatos, $link);

$cliente=$_GET["rif"];
$sql="SELECT * FROM ".$_GET['idempresa']."_fact2_clientes where rif='$cliente' and tipo='Cliente'"; 
$resultado=mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($resultado) > 0)
{
	$fila2=mysql_fetch_assoc($resultado);
	$tipocliente=$fila2['categoria'];
	if ($tipocliente=='')
		$tipocliente='C';
	$obtenido_local=1;
	$nombre=$fila2['nombre'];
	$direccion1=($fila2['direccion1']!=''?$fila2['direccion1']:'NO ESPECIFICA');
	$direccion2=($fila2['direccion2']!=''?$fila2['direccion2']:'NO ESPECIFICA');
	$telefono=($fila2['telefono']!=''?$fila2['telefono']:'NO ESPECIFICA');
	$email=($fila2['email']!=''?$fila2['email']:'NO ESPECIFICA');
	$agentederetencion=($fila2['agentederetencion']!=''?$fila2['agentederetencion']:'NO ESPECIFICA');
	$contribuyenteiva=($fila2['contribuyenteiva']!=''?$fila2['contribuyenteiva']:'NO ESPECIFICA');
	$tasa=($fila2['tasa']!=''?$fila2['tasa']:'NO ESPECIFICA');
	$institucion=($fila2['codigo']!=''?$fila2['codigo']:'NO ESPECIFICA');
}
else 
*/
{
	$nombre=' ';
	$direccion1='';
	$agentederetencion='';
	$contribuyenteiva='';
	$tasa='';
	$tipocliente="C";
	$institucion="XXXX";
	$rif=$_GET["rif"];

	include_once('classbasededatos.php');
	$con = new classbasededatos();
	$con->conectar();
	$buscar = "select * from usuarios where rif_usuario = '".$rif."'";
	// echo $buscar;
	$resb = $con->consulta($buscar);
	$obtenido_local=0;
	if ($con->num_rows($resb) < 1)
	{
		require_once 'seniat/Rif.php';
		// Crear la instancia y pasar como parámetro el RIF a verificar
		$rif = new Rif($rif);
		// Obtener los datos fiscales
		$datosFiscales = json_decode($rif->getInfo());
		switch ($datosFiscales->code_result) {
		case 1:
			    $texto  = "Razón social: {$datosFiscales->seniat->nombre}<br />"
	       	    . "Agente Retención: {$datosFiscales->seniat->agenteretencioniva}<br />"
	           	. "Contribuyente IVA: {$datosFiscales->seniat->contribuyenteiva}<br />"
		        . "Tasa: {$datosFiscales->seniat->tasa}<br />";
	//				echo $texto;
					// ------------------
					$nombre=$datosFiscales->seniat->nombre;
					$direccion1=$direccion2=$telefono=$email="NO ESPECIFICA";
					$agentederetencion=$datosFiscales->seniat->agenteretencioniva;
					$contribuyenteiva=$datosFiscales->seniat->contribuyenteiva;
					$tasa=$datosFiscales->seniat->tasa;
					$tipocliente="C";
					$institucion="XXXX";
					break;
		default: 
					$nombre=' ';
					$direccion1='';
					$agentederetencion='';
					$contribuyenteiva='';
					$tasa='';
					$tipocliente="C";
					$institucion="XXXX";
					break;
		}
 	}
 	else 
 	{
 		$obtenido_local=1;
 		$reg=$con->fetch_assoc($resb);
		$nombre=$reg['nombre_usuario'];
		$email=$reg['email'];
 	}
 	$con->desconectar();

header("Content-Type: text/xml");
echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>';
echo "<resultados>";
echo utf8_encode("<tipocliente>".$tipocliente."</tipocliente>");		// 
echo utf8_encode("<nombre>".$nombre."</nombre>");
echo utf8_encode("<direccion1>".$direccion1."</direccion1>");
echo utf8_encode("<direccion2>".$direccion2."</direccion2>");
echo utf8_encode("<telefono>".$telefono."</telefono>");
echo utf8_encode("<email>".$email."</email>");
echo utf8_encode("<agentederetencion>".$agentederetencion."</agentederetencion>");
echo utf8_encode("<contribuyenteiva>".$contribuyenteiva."</contribuyenteiva>");
echo utf8_encode("<tasa>".$tasa."</tasa>");
echo utf8_encode("<institucion>".$institucion."</institucion>");
echo "<obtenidolocal>".$obtenido_local."</obtenidolocal>";
echo "</resultados>";
}	
?>