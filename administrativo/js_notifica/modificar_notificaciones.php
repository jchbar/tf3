<?php
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
	/*Inicia validacion del lado del servidor*/
	 if (empty($_POST['id'])){
			$errors[] = "ID vacío";
		} else if (empty($_POST['nombre'])){
			$errors[] = "Nombre vacío";
/*
		} else if (empty($_POST['moneda'])){
			$errors[] = "Moneda vacío";
		} else if (empty($_POST['capital'])){
			$errors[] = "Capital vacío";
		} else if (empty($_POST['continente'])){
			$errors[] = "Continente vacío";
*/
		}   else if (
			!empty($_POST['id']) && 
			!empty($_POST['nombre']) 
/*
			!empty($_POST['moneda']) &&
			!empty($_POST['capital']) &&
			!empty($_POST['continente'])
*/			
		){

		// escaping, additionally removing everything that could be (html/javascript-) code
/*
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$moneda=mysqli_real_escape_string($con,(strip_tags($_POST["moneda"],ENT_QUOTES)));
		$capital=mysqli_real_escape_string($con,(strip_tags($_POST["capital"],ENT_QUOTES)));
		$continente=mysqli_real_escape_string($con,(strip_tags($_POST["continente"],ENT_QUOTES)));
*/
		$id=intval($_POST['id']);
		$nombre = $_POST['nombre'];
		//busco a ver si existe si existe los coloco en falso, sino los creo en falso
		$comando = "select * from notificacion where codigousuario = '".$id."'";
		$res = $con->consulta($comando);
		if ($con->num_rows($res) < 1) // no existe, los creo
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
			if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
			$comando="select * from configuracion where nombreparametro = 'Notificables' order by valorparametro" ;
			$res=$con->consulta($comando);
			$registros = 0;
			$ahora=$con->ahora();
			while ($fila = $con->fetch_assoc($res)) {
				$sql="insert into notificacion (codigousuario, notificacion, activo, ipcreacion, fechacreacion) VALUES 
				('".$id."', '".$fila['idregistro']."', 0, '".$ip."', '".$ahora."')";
				$query_update = $con->consulta($sql);
//		echo $sql;
			}
		}
		else 
		{
			$comando = "update notificacion set activo = 0 where codigousuario = '".$id."'"; 
			$query_update = $con->consulta($comando);
		}
		// echo 'registros '.$_POST['registros'];
		// phpinfo();
		extract($_POST);
		for ($i=0;$i<$_POST['registros'];$i++)		// no es necesarios revisar el check si aparece es porq estan seleccionados  
		{
			$variable='cancelar'.($i);
			$valor = ${$variable};
			// echo '<br><br>'.' variable '.$variable.' contenido = '.$valor;
			$sql="UPDATE notificacion SET activo=1 WHERE codigousuario='".$id."' and (notificacion = '".$$variable."')";
			// echo $sql;
			$query_update = $con->consulta($sql);
				if ($query_update){
					$messages[] = "Los datos han sido actualizados satisfactoriamente.";
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