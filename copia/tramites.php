<?php
session_start();
date_default_timezone_set('America/Caracas'); 
if(!isset($_SESSION['rif']))
{
	header("Location: index.php");
}
// include_once 'dbconfig.php';
include_once('ClassCrud.php');
$crud = new ClassCrud();
include_once('ClassTributos.php');
$tributo = new ClassTributos();
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
	<?php  // include ('header.html');  ?>
  <?php //include("modal_agregar.php");?>
  <?php include("modal_modificar.php");?>
  <?php include("modal_eliminar.php");?>
  <?php include("modal_imprimir.php");?>
    <div class="container-fluid">
	 
		<div class='col-xs-6'>	
			<h3> Tr&aacute;mites </h3>
		</div>
		<!-- <div class='col-xs-6'>
			<h3 class='text-right'>		
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataRegister"><i class='glyphicon glyphicon-plus'></i> Agregar</button>
			</h3>
		</div>	-->
		
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
	
	<script src="js/app.js"></script>
	<script>
		$(document).ready(function(){
			load(1);
		});
	</script>
 </body>
</html>

