<?php
// http://www.eslomas.com/2011/09/proteccion-anti-csrf-con-tokens-en-php/
session_start();
date_default_timezone_set('America/Caracas'); 
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
// include_once 'dbconfig.php';
include_once('opciones.php');
// include_once('classcrud.php');
// $crud = new classcrud();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>

<?php /*
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Cargar información dinámica en ventana modal Bootstrap con PHP,  MySQL y jQuery </title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  </head> */ ?>
  <body>
	<?php  // include ('header.html'); 
	include("js_ut/modal_agregar_ut.php");
	// include("js_ut/modal_activar_usuarios.php");
	// include("js_usuarios/modal_eliminar_usuarios.php");
	include("js_ut/modal_modificar_ut.php");
	?>
    <div class="container-fluid">
	 
		<div class='col-xs-6'>	
			<h3>Montos para Unidad Tributaria</h3>
		</div>
		<div class='col-xs-6'>
			<h3 class='text-right'>		
			<?php
				include_once('classbasededatos.php');
				$con = new classbasededatos();
				$con->conectar();
				
				$comando="select DATE_FORMAT(now(),'%m/%d/%Y') as hoy, DATE_FORMAT(date_add(now(),interval 30 day),'%m/%d/%Y') as maximo, DATE_FORMAT(date_sub(now(),interval 2 day),'%m/%d/%Y') as minimo";
				$resultado = $con->consulta($comando);
				$row = $con->fetch_assoc($resultado);
				?>
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataRegister" data-hoy="<?php echo $row['hoy']?>" data-maximo="<?php echo $row['maximo']?>" data-minimo="<?php echo $row['minimo']?>" ><i class='glyphicon glyphicon-plus'></i> Agregar</button>
			</h3>
		</div>
		
	  <div class="row">
		
		
		
		<div class="col-xs-12">
		<div id="loader" class="text-center"> <img src="loader.gif"></div>
		<div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
		<div class="outer_div"></div><!-- Datos ajax Final -->
		</div>
	  </div>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	-->
	
	<script src="js_ut/app.js"></script>
	<script>
		$(document).ready(function(){
			load(1);
		});
	</script>
 </body>
</html>

