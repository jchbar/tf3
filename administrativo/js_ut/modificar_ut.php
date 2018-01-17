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
		} else if (empty($_POST['monto'])){
			$errors[] = "Monto vacío";
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
			!empty($_POST['monto']) 
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
		$monto = $_POST['monto'];
//		$nombre = $_POST['nombre'];
		$sql="UPDATE unidadtributaria SET montout='".$monto."' WHERE idregistro ='".$id."'";
		echo $sql;
		$query_update = $con->consulta($sql);
			if ($query_update){
				$messages[] = "Los datos han sido actualizados satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente."; // .mysqli_error($con);
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