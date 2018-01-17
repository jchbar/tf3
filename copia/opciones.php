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

<body>
	<?php include ('header.html'); 

	
	
if($_POST['Adquirir'])
{
	echo "<form action='opciones.php' name='form1' id='form1' method='post'>";// onsubmit='return validar0(form1)'>"; // hidden-xs div class="col-xs-12 col-sm-8 col-md-6"> --> ;
	$tributo->pedir_rif();
	$tributo->normal();
echo '<button class="btn btn-success" value="Agregar" name="AgregarT"><i class=\'glyphicon glyphicon-plus\'></i>Agregar Tributo a la Lista</button>'; // onclick="return validar0(this);"
	echo "</form>";
	echo '<form action="opciones.php" method="POST">';
	echo '<div class="col-md-6">';
	echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
	echo '</div>';
	echo '</form>';
}
else if($_POST['VerTramites'])
{
//	include('cargartributos.php');
	include('tramites.php');
}
else if($_POST['Salir'])
{
//	session_destroy('rif');
	unset($_SESSION['rif']);
	// header("Location: index.php");
	include('index.php');
}
else if ($_POST['AgregarT'])
{
	$tributo->agregar_tf();
}
else
{
/*
$stmt = $db_con->prepare("SELECT * FROM sgcapass WHERE alias=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>

<body>
	<?php include ('header.html'); ?>
*/
?>
	<br>
	<div align="center" class="container-responsive">
    <section class="row">
    	<div class="col-xs-12 col-sm-8 col-md-9">
			<div class="signin-form">
			<div class="container">
            <div class="btn-group">
			<table>
            <form action="opciones.php" id="buscartributos" name="buscartributos" method="post" class="form-inline"> 
				<tr>
					<td>
						<div class="col-xs-12 col-sm-2 col-md-2`">
						<button class="btn btn-success" value="Adquirir" name="Adquirir">Adquirir Tributo</button>
						<div>
					</td>
				<td>
<?php
				$con = new ClassBasedeDatos();
				$con->conectar();
				$query="select count(riftimbre) as cuantos from timbresfiscales where riftimbre = '".$_SESSION['rif']."' group by riftimbre";
				// echo $query;
				$result=$con->consulta($query);
				$res=$con->fetch_assoc($result);
				if ($con->num_rows($result)>0)
				{
						echo '<div class="col-xs-12 col-sm-2 col-md-2`">';
						//echo '<button class="btn btn-primary" value="VerTramites" name="VerTramites" onclick="cargarContenidoReloj(\'cargartributos.php?\')">Ver Tr&aacute;mites Realizados ';
						echo '<button class="btn btn-primary" value="VerTramites" name="VerTramites">Ver Tr&aacute;mites Realizados ';
						echo '<span class="badge"><div id="botontramites" name="botontramites">'.$res['cuantos'].'</div></span></button>';
						//echo '<a href="tramites.php" class="btn btn-primary" value="VerTramites" name="VerTramites">Ver Tr&aacute;mites Realizados ';
						// echo '<span class="badge"><div id="botontramites" name="botontramites">'.$res['cuantos'].'</div></span></a>';
					//	 	echo '<a href="cargarContenidoReloj(\'cargartributos.php?rif=V093773884\')" class="btn btn-primary" data-toggle="collapse" data-target="#mostrartributosadq">Ver Tr&aacute;mites Realizados </a>';
						echo '<div>';
				}
				$con->desconectar();
?>
				</td>
				<td>
						<div class="col-xs-12 col-sm-2 col-md-2`">
						<button class="btn btn-warning" value="Cambiar" name="Cambiar">Cambiar Clave</button>
						<div>
				</td>
				<td>
					<div class="col-xs-12 col-sm-2 col-md-2`">
						<button class="btn btn-danger" value="Salir" name="Salir" >Salir</button>
					</div>
				</td>
			</form>
            </div>
            </div>
            </div>
        </div>
	</section>
	</div>
</body>
</html>

<?php
}
// https://api-secure.solvemedia.com/public/puzzle_more_info?lang=en;chid=2@Tw5szIz9haroDwT2alQdXZvD-dgNdDOh@XCKDLtqjdvIENU8bgrS8H39APTC4lJjoCwWXZViqU3x3FfpG-KpUmWQAweKOSR0Rmv0Te-k7tXi1ILK8c7OLUakR5ImMRdi2gA4Hg4GZfKJIxEeuMiUebWCRgU.h5AYZvhY062utCC03nKkYMZKbCJZjV05EJKiv6j9IUUrgH5eKQC9n01ZfvL4QVdgC480wQutmG7TiqpRiqRnttDo44j6x.lSNgBs2lGVtvIKjjEUIbmVm0SjKzQZn2jLWw9uL9.ZY2p45gJO9fg4jTBOGosiN3dO5aoI1JkhFXIK0uoA
?>

