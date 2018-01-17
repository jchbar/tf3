<?php
session_start();
date_default_timezone_set('America/Caracas'); 

/*
if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
}
*/
// include_once 'dbconfig.php';
include_once('ClassCrud.php');
$crud = new ClassCrud();

/*
$stmt = $db_con->prepare("SELECT * FROM sgcapass WHERE alias=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>

<body>
	<?php include ('header.html'); ?>

	<div align="center" class="container-responsive">
    <section class="row">
    	<div class="col-xs-12 col-sm-8 col-md-9">
<!--
	        <a href="#" class="btn btn-primary">Consultar Tributo</a>
            <a href="#" class="btn btn-success">Adquirir Tributo</a>
            <a href="#" class="btn btn-warning">Quieres ser Aliado?</a>
            --> 
<!--            botones asi <br /> -->
			<div class="signin-form">
			<div class="container">
            <div class="btn-group">
			<table>
            <form action="dondevoy.php" id="buscartributos" name="buscartributos" method="post" class="form-inline"> 
				<tr>
				<td>
				<div class="col-xs-12 col-sm-2 col-md-2`">
        	    <button class="btn btn-primary" value="consulTar" name="consulTar" >Consultar Tributo</button>
				<div>
				</td>
				<td>
				<div class="col-xs-12 col-sm-2 col-md-2`">
        	    <button class="btn btn-warning" value="RegisTrarse" name="RegisTrarse" >Registrarse</button>
				</div>
				</td>
				<td>
				<div class="col-xs-12 col-sm-2 col-md-2`">
        	    <button class="btn btn-success" value="IngreSar" name="IngreSar" >Zona de Usuarios</button>
    	        <!-- <button class="btn btn-success" value="adquiRir" name="adquiRir">Adquirir Tributo</button>	-->
				</td>
				<td>

				<?php  $crud->MostrarBotonAliado(); 
				            echo '</form>';
				echo '</td>';
				echo '<td>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

				echo '<div class="col-xs-12 col-sm-2 col-md-2`">';
				echo '<td><button class="btn btn-info" data-toggle="collapse" data-target="#dondepagar">Donde Realizar los Pagos?';
				echo '</div>';
				echo '</button></td></tr>';
				echo '</table>';



				echo '<div id="dondepagar" class="collapse">';
					$comando="select *, concat(entidades.plaza,'-',cuenta) as nrocta from entidades, plazas where entidades.plaza=plazas.codigo order by nombre";
					$con = new ClassBasedeDatos();
					$con->conectar();
					$resultp=$con->consulta($comando);
					echo '<table class="table table-striped">';
						echo '<tr>';
							echo '<th>Banco</th><th>Nro de Cuenta</th><th>A Nombre de</th>';
						echo '</tr>';
						while ($fila = $con->fetch_assoc($resultp))
						{
							echo '<tr>';
								echo '<td>'.$fila['nombre'].'</th><th>'.$fila['nrocta'].'</th><th>'.$fila['anombrede'].'</th>';
							echo '</tr>';			
						}
					echo '</table>';
				echo '</div>';

		echo '</div>';
	echo '</section>';
	echo '</div>';
?>	
</body>
</html>

https://api-secure.solvemedia.com/public/puzzle_more_info?lang=en;chid=2@Tw5szIz9haroDwT2alQdXZvD-dgNdDOh@XCKDLtqjdvIENU8bgrS8H39APTC4lJjoCwWXZViqU3x3FfpG-KpUmWQAweKOSR0Rmv0Te-k7tXi1ILK8c7OLUakR5ImMRdi2gA4Hg4GZfKJIxEeuMiUebWCRgU.h5AYZvhY062utCC03nKkYMZKbCJZjV05EJKiv6j9IUUrgH5eKQC9n01ZfvL4QVdgC480wQutmG7TiqpRiqRnttDo44j6x.lSNgBs2lGVtvIKjjEUIbmVm0SjKzQZn2jLWw9uL9.ZY2p45gJO9fg4jTBOGosiN3dO5aoI1JkhFXIK0uoA
