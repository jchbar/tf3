<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>
<body>
<?php 
include_once('classcrud.php');
$crud = new classcrud();
include ('header.html'); 
include_once('classtributos.php');
$tributo = new classtributos();
$id=$_GET['id'];

$conexion = new ClassBasedeDatos();
$conexion->conectar();

$id2=$tributo->hexToStr($id);

		require 'aes/aes.class.php';     // AES PHP implementation
		require 'aes/aesctr.class.php';  // AES Counter Mode implementation
		$comando = "select * from configuracion where nombreparametro = 'PasoIdUnico'";
		$resuni = $conexion->consulta($comando);
		if ($conexion->num_rows($resuni) < 1)
		{
			echo '<div class="alert alert-danger" role="alert">';
				echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				echo '<strong>Error!</strong> No se ha definido el parametro de Tiempo';
				echo '</div>';
			die('');
		}
		$pw=$conexion->fetch_assoc($resuni);
		$pw=$pw['valorparametro'];
		$cipher=$id2;
		$decr = AesCtr::decrypt($cipher, $pw, 128);

//		echo 'desencr '.$decr;
///////////

$consulta="select * from ingreso_usuario where codigousuario = '$decr'";
$resultado=$conexion->consulta($consulta);
if ($conexion->num_rows($resultado) < 1)
{
	$resultado=$conexion->fetch_assoc($resultado);
	alertar('Error!','No se ha podido consultar la informacion','Error');
}
else 
{
	$resultado=$conexion->fetch_assoc($resultado);
	if ($resultado['confirmado'] == 0)
	{
		$consulta="update ingreso_usuario set confirmado = 1 where codigousuario = '$decr'";
		$resultadou=$conexion->consulta($consulta);
		if ($resultadou > 0)
		{
			alertar('Informacion','La informacion ha sido validada correctamente para '.$resultado['nombre_usuario'],'Aviso');
		}
		else
		{
			alertar('Error!','No se ha podido validar la informacion','Error');
		}
	}
	else
	{
		alertar('Error!','El registro fue validado previamente','Error');
	}
}

// die('id 2='.$id2);

function alertar($aviso, $mensaje,$tipo)
{
	if ($tipo == 'Aviso')
		echo '<div class="alert alert-success" role="alert">';
	else echo '<div class="alert alert-danger" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	echo '<strong>'.$aviso.'</strong> ';
	echo $mensaje;
	echo '</div>';
}


?>



<!--

https://1000hz.github.io/bootstrap-validator/

-->





