<?php
session_start();
require_once 'Rif.php';
$codigo=$_GET['RIF'];
// Crear la instancia y pasar como parámetro el RIF a verificar
$rif = new Rif($codigo);
// Obtener los datos fiscales
$datosFiscales = json_decode($rif->getInfo());
switch ($datosFiscales->code_result) {
	case 1:
		$texto  = "Razón social: {$datosFiscales->seniat->nombre}<br />"
				. "Agente Retención: {$datosFiscales->seniat->agenteretencioniva}<br />"
				. "Contribuyente IVA: {$datosFiscales->seniat->contribuyenteiva}<br />"
				. "Tasa: {$datosFiscales->seniat->tasa}<br />";
				$_SESSION['razon']=$datosFiscales->seniat->nombre;
				//	echo $texto;
				header('Content-type: text/xml');
				header ('Cache-Control: no-store' , false);	
				echo '<?xml version="1.0" encoding="utf-8"?>';
				echo "<resultadosseniat><result>";
				echo utf8_encode("<coderesult>1</coderesult>");
				//	echo utf8_encode("<message>".mensaje($response_json['code_result']) . ' ' . $datos[1]."</message>");
				echo utf8_encode("<message>OK</message>");
				echo utf8_encode("<nombreseniat>".($datosFiscales->seniat->nombre)."</nombreseniat>");
				echo utf8_encode("<agenteretensioniva>".$datosFiscales->seniat->agenteretencioniva."</agenteretensioniva>");
				echo utf8_encode("<contribuyenteiva>".$datosFiscales->seniat->contribuyenteiva."</contribuyenteiva>");
				echo utf8_encode("<tasa>".$datosFiscales->seniat->tasa."</tasa>");

				$_SESSION['rif']=$_GET['rif'];
					include_once('../ClassCrud.php');
					$crud = new ClassCrud();
					$con = new ClassBasedeDatos();
					$con->conectar();
					$query="select count(riftimbre) as cuantos from timbresfiscales where riftimbre = '".$_GET['rif']."' group by riftimbre";
					$result=$con->consulta($query);
					$res=$con->fetch_assoc($result);
					if ($con->num_rows($result)>0)
					{
						echo utf8_encode("<nrotramites>".$res['cuantos']."</nrotramites>");
						$_SESSION['nrotramites']=$res['cuantos'];
					}
					else 
					{
						$_SESSION['nrotramites']=0;
						echo utf8_encode("<nrotramites>0</nrotramites>");
					}
					$con->desconectar();
				echo "</result></resultadosseniat>";
			// ------------------
/*
				echo "<form action='actprov.php?accion=Anadir1' name='form1' method='post' onsubmit='return formcliente(form1)'>";		
				echo '<input type="hidden" name = "codigo" value ="'.$codigo.'">';		 
//				echo "<label>Código de Cuenta</label><br /><input type = 'text' size='40' maxlength='40' name='codigo'><br />";
				echo "<label>Nombre</label><br /><input type = 'text' size='40' maxlength='70' name='nombre' value='".$datosFiscales->seniat->nombre."' readonly=true><br />";
				echo "<label>Direccion 1</label><br /><input type = 'text' size='40' maxlength='50' name='direccion1'><br />";
				echo "<label>Direccion 2</label><br /><input type = 'text' size='40' maxlength='50' name='direccion2'><br />";
				echo "<label>Telefono</label><br /><input type = 'text' size='20' maxlength='20' name='telefono'><br />";
				echo "<label>email</label><br /><input type = 'text' size='40' maxlength='200' name='email'><br />";
				echo "<label>Agente de Retencion</label><br /><input type = 'text' size='40' maxlength='10' name='agente' value='".$datosFiscales->seniat->agenteretencioniva."' readonly=true><br />";
				echo "<label>Contribuyente de IVA</label><br /><input type = 'text' size='40' maxlength='10' name='contribuyente' value='".$datosFiscales->seniat->contribuyenteiva."' readonly=true><br />";
				echo "<label>Tasa</label><br /><input type = 'text' size='40' maxlength='10' name='tasa' value='".$datosFiscales->seniat->tasa."' readonly=true><br />";
//				echo "<label>Cuenta Contable</label><br /><input type = 'text' size='40' maxlength='10' name='cuenta' value=''><br />";
				echo "<input type = 'submit' value = 'Añadir'>";
				echo "</form>\n";
*/
				// ------------------
			    break;
		default:
			$texto = $datosFiscales->message;
			header('Content-type: text/xml');
			// header ('Cache-Control: no-store' , false);	
				echo '<?xml version="1.0" encoding="utf-8"?>';
				echo "<resultadosseniat>";
				echo utf8_encode("<code_result>0</code_result>");
				//	echo utf8_encode("<message>".mensaje($response_json['code_result']) . ' ' . $datos[1]."</message>");
				echo utf8_encode("<message>".$texto."</message>");
/*
				echo utf8_encode("<nombreseniat>".($datosFiscales->seniat->nombre)."</nombreseniat>");
				echo utf8_encode("<agenteretensioniva>".$datosFiscales->seniat->agenteretencioniva."</agenteretensioniva>");
				echo utf8_encode("<contribuyenteiva>".$datosFiscales->seniat->contribuyenteiva."</contribuyenteiva>");
				echo utf8_encode("<tasa>".$datosFiscales->seniat->tasa."</tasa>");
				$_SESSION['rif']=$_GET['rif'];
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
*/
				echo "</resultadosseniat>";
/*
			echo $texto;
			echo '<h2>Estos datos no estan registrados en el SENIAT, se registra manual</h2>';
				// ------------------
				echo "<form action='actprov.php?accion=Anadir1' name='form1' method='post' onsubmit='return formcliente(form1)'>";		
				echo '<input type="hidden" name = "codigo" value ="'.$codigo.'">';		 
//				echo "<label>Código de Cuenta</label><br /><input type = 'text' size='40' maxlength='40' name='codigo'><br />";
			echo "<label>Nombre</label><br /><input type = 'text' size='40' maxlength='70' name='nombre' value='".$datosFiscales->seniat->nombre."' readonly=true><br />";
				echo "<label>Direccion 1</label><br /><input type = 'text' size='40' maxlength='50' name='direccion1'><br />";
				echo "<label>Direccion 2</label><br /><input type = 'text' size='40' maxlength='50' name='direccion2'><br />";
				echo "<label>Telefono</label><br /><input type = 'text' size='20' maxlength='20' name='telefono'><br />";
				echo "<label>email</label><br /><input type = 'text' size='40' maxlength='200' name='email'><br />";
				echo "<label>Agente de Retencion</label><br /><input type = 'text' size='40' maxlength='10' name='agente' value='".$datosFiscales->seniat->agenteretencioniva."' readonly=true><br />";
				echo "<label>Contribuyente de IVA</label><br /><input type = 'text' size='40' maxlength='10' name='contribuyente' value='".$datosFiscales->seniat->contribuyenteiva."' readonly=true><br />";
				echo "<label>Tasa</label><br /><input type = 'text' size='40' maxlength='10' name='tasa' value='".$datosFiscales->seniat->tasa."' readonly=true><br />";
//				echo "<label>Cuenta Contable</label><br /><input type = 'text' size='40' maxlength='10' name='cuenta' value=''><br />";
				echo "<input type = 'submit' value = 'Añadir'>";
				echo "</form>\n";
*/
	}
?>
