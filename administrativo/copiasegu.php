<?php
session_start();
date_default_timezone_set('America/Caracas'); 
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
// include_once 'dbconfig.php';
include_once('classcrud.php');
$crud = new classcrud();
/*
include_once('classtributos.php');
$tributo = new classtributos();
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>

<body>
	<?php include ('header.html'); 

?>
<div class="body-container">
<div class="container">
    <div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Bienvenida(o) <?php echo $_SESSION['rif']. ' '.$_SESSION['nombre_usuario']; ?></strong>.
    </div>
</div>
<div class="container">

<?php
if (!$_GET['n']) {

	echo "<a href = '?n=1'>Haga clic aqui para generar una copia de seguridad de la Base de Datos de <span class='b'></span></a>";
} else {
	include("backup.php");
}

?>
