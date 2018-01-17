<?php
session_start();
/*-----------------------
Autor: Obed Alvarado
http://www.obedalvarado.pw
Fecha: 27-02-2016
Version de PHP: 5.6.3
----------------------------*/
	# conectare la base de datos
	include_once('../classbasededatos.php');
	$con= new classbasededatos();
	$con->conectar();
	// echo 'conec...';
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre']))
	{
		$errors[] = "Nombre vacío";
	} else if (empty($_POST['mail']))
	{
			$errors[] = "Email vacío";
	}   else if (
			!empty($_POST['mail']) && 
			!empty($_POST['nombre']) 
	){
	// echo '1...';
		$nombre = $_POST['nombre'];
		$mail = $_POST['mail'];
		$nivel= $_POST['nivel'];
		// echo '2...';
		$sql="select * from ingreso_usuario where email = '$mail'";
		$query_update = $con->consulta($sql);
		if ($con->num_rows($query_update) > 0)
			$con->mensaje_alerta('Error...', 'El email indicado ya se encuentra registrado', 'danger');
		else 
		{
			$nueva = "SELECT SUBSTR(MD5('".$ahora."'),2,10) as nueva";
			$nueva =$con->consulta($nueva);
			$nueva = $con->fetch_assoc($nueva);
			$nueva = $nueva['nueva'];

			$sql="INSERT INTO ingreso_usuario (nombre, email, clave, nivel, status) 
				VALUES ('".$nombre."','".$mail."',substr(MD5('".$nueva."'),2,8), '".$nivel."','0')";
			// echo $sql;
			$query_update = $con->consulta($sql);
			if ($query_update){
				$messages[] = "Los datos han sido guardados satisfactoriamente.";
				$messages[] = "En breve recibira un email para la activacion con su contrase&nacute;a";
				
				$enviadopor=$con->obtener_enviadopor($con);
				$respondera=$con->obtener_respondera($con);
				$dirweb=$con->obtener_dirweb($con);
				include_once('../enviarmail.php');
				$query="select clave, codigousuario from ingreso_usuario where email = '$mail'";
				$query=$con->consulta($query);
				$query=$con->fetch_assoc($query);
				$clave = $query['clave'];
				
				$cuento= '<table>';
				$cuento.= '<tr>';
				$cuento.= '<td><strong>Estimada(o) Usuario:</strong></td>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td><strong>'.$nombre.'</strong> Nro ID: '.substr($query['codigousuario'],-8).'</td>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td>El presente email es para confirmar su direcci&oacute;n de correo electr&oacute;nico y al mismo tiempo, validar y dar de alta su inscripci&oacute;n en nuestros registros.</td>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td>Favor hacer clic en el siguiente enlace ';
		
///////////
				require '../aes/aes.class.php';     // AES PHP implementation
				require '../aes/aesctr.class.php';  // AES Counter Mode implementation
				$comando = "select * from configuracion where nombreparametro = 'PasoIdUnico'";
				$resuni = $con->consulta($comando);
				if ($con->num_rows($resuni) < 1)
				{
					$con->mensaje_alerta('Error!','No se ha definido el parametro de Tiempo','danger');
					die('');
				}
				$pw=$con->fetch_assoc($resuni);
				$pw=$pw['valorparametro'];
				$pt=$rif;
				$encr = AesCtr::encrypt($pt, $pw, 128);
				$encrHex = str_pad($con->strToHex($encr), 40, '0', STR_PAD_LEFT);
		///////////
				$direccion=$dirweb.'/administrativo/activar.php?id='.$encrHex;
				
				$cuento.= '<a target="_blank" href="'.$direccion.'">'.$direccion."</a>";
				$cuento.= ', en caso de no funcionar favor copiar y pegar la siguiente linea en el navegador de su preferencia</td>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td>'.$direccion."</td>";
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td>Su clave: '.$nueva.'</td>';
				$cuento.= '</tr>';
				$cuento.= '<tr>';
				$cuento.= '<td>Gracias por su atenci&oacuten</td>';
				$cuento.= '</tr>';
				$cuento.= '</table>';
				$enviara = $mail;

				if (enviar_email('Confirmacion de registro', $cuento, false, '', $enviadopor, $respondera , $enviara ) >0)
				{
					$con->mensaje_alerta('Bien!!!','Se ha enviado el email satisfactoriamente','success');
				}
				else
				{
					$comando="delete from ingreso_usuario where (email = '$mail')";
					$con->consulta($comando);
					$con->mensaje_alerta('Lo sentimos...','No se ha podido registrar la informaci&oacute;n... intente luego.. se ha descartado la informaci&oacute;n','danger');
				}

			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente."; // .mysqli_error($con);
			}
		}	
	} else {
				$errors []= "Error desconocido.";
	}
	
	if (isset($errors)){
		$elerror='';
		foreach ($errors as $error) {
			$elerror.=$error;
		}
		$con->mensaje_alerta('Error...', $elerror, 'danger');
	}
	if (isset($messages)){
		$mensajes='';
		foreach ($messages as $message) {
			$mensajes.=$message;
		}
		$con->mensaje_alerta('Bien!!!...', $mensajes, 'success');
	}
?>	