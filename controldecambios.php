<?php
session_start();
date_default_timezone_set('America/Caracas'); 
include_once('classcrud.php');
$crud = new classcrud();
include_once('classtributos.php');
$tributo = new classtributos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.html'); ?>
</head>

<body>
	<?php include ('header.html'); 

include_once('classbasededatos.php');
$con = new classbasededatos();
$con->conectar();
$sql="select fecha, count(fecha) as cuantos from controlcambios group by fecha order by fecha desc";
$resultado = $con->consulta($sql);
$contador=0;
while ($fila = $con->fetch_assoc($resultado)) {
	$contador++;
echo '<div class="container-fluid">';
	echo '<div class="row">';
		echo '<div class="col-md-8">';
			echo '<div class="panel-group"  id="accordion" role="tablist"> ';
				echo '<div class="panel panel-default">';
					echo '<div class="panel-heading" role="tab" id="heading'.$contador.'">';
						echo '<h4 class="panel-title">';
							echo '<a href="#collaps'.$contador.'" data-toggle="collapse" data-parent="#accordion" >';
							$fecha=$fila['fecha'];
							// echo '<ul class="list-group list-group-item-success"><strong><span class="badge">'.$fila['cuantos'].'</span> Cambios al <span class="badge">'.($fila['fecha']).'</span></strong>';
							echo '<strong><span class="badge">'.$fila['cuantos'].'</span> Cambios al <span class="badge">'.($fila['fecha']).'</span></strong>';
							echo '</a>';
						echo '</h4>';
					echo '</div>';
					if ($contador == 1)
						echo '<div id="collaps'.$contador.'" class="panel-collapse collapse in">';
					else 
						echo '<div id="collaps'.$contador.'" class="panel-collapse collapse">';
						echo '<div class="panel-body">';
							$sql2="select * from controlcambios where fecha = '$fecha'";
							$resulta2 = $con->consulta($sql2);
							while ($fila2 = $con->fetch_assoc($resulta2)) {
								echo '<li class="list-group list-group-item-'.$fila2['mensaje'].'">'.$fila2['cuento'].'</li>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
				// echo '</ul>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';
}
$con->desconectar();
?>
<!--



<div class="container-fluid">
<div class="row">
<div class="col-md-8">
	<div class="panel-group"  id="accordion" role="tablist"> 
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading1">
				<h4 class="panel-title">
					<a href="#collapse1" data-toggle="collapse" data-parent="#accordion" >
						<ul class="list-group list-group-item-success"><strong>Cambios al <span class="badge">10-12-2016</span></strong>
					</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse in">
				<div class="panel-body">
					<li class="list-group list-group-item-default">Cambio de presentacion en registro de usuario</li>
					<li class="list-group list-group-item-warning">Debido a actualizaciones de seguridad del manejador de base de datos fue necesario cambiar algunos comandos que proximamente seran obsoletos</li>
					<li class="list-group list-group-item-warning">Correccion del enlace de activacion que estaba dirigido a otra carpeta, ya fue corregido en la configuracion</li>
					<li class="list-group list-group-item-success">Fueron modificadas seccion de ingreso del usuario y del administrativo donde ya se puede recuperar la clave</li>
					<li class="list-group list-group-item-danger">Se adiciono el control donde usuario administrativo y usuario normal no pueden registrarse con el mismo email</li>
					<li class="list-group list-group-item-success">Se coloco la modificcion de clave en el area administrativa, pronto en el usuario normal</li>
					<li class="list-group list-group-item-success">Corregido el error de la ventaja de mensajes cuando el usuario normal se registrar</li>
					<li class="list-group list-group-item-warning">El usuario registrado val..gs@gmail.com se elimino para que pueda hacer las pruebas correctamente con los nuevos cambios</li>
				</div>
			</div>

			<div class="panel-heading" role="tab" id="heading2">
				<h4 class="panel-title">
					<a href="#collapse2" data-toggle="collapse" data-parent="#accordion" >
						<ul class="list-group list-group-item-success"><strong>Cambios xxx al <span class="badge">10-12-2016</span></strong>
					</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div class="panel-body">
					<li class="list-group list-group-item-default">Cambio de presentacion en registro de usuario</li>
					<li class="list-group list-group-item-warning">Debido a actualizaciones de seguridad del manejador de base de datos fue necesario cambiar algunos comandos que proximamente seran obsoletos</li>
					<li class="list-group list-group-item-warning">Correccion del enlace de activacion que estaba dirigido a otra carpeta, ya fue corregido en la configuracion</li>
					<li class="list-group list-group-item-success">Fueron modificadas seccion de ingreso del usuario y del administrativo donde ya se puede recuperar la clave</li>
					<li class="list-group list-group-item-danger">Se adiciono el control donde usuario administrativo y usuario normal no pueden registrarse con el mismo email</li>
					<li class="list-group list-group-item-success">Se coloco la modificcion de clave en el area administrativa, pronto en el usuario normal</li>
					<li class="list-group list-group-item-success">Corregido el error de la ventaja de mensajes cuando el usuario normal se registrar</li>
					<li class="list-group list-group-item-warning">El usuario registrado val..gs@gmail.com se elimino para que pueda hacer las pruebas correctamente con los nuevos cambios</li>
				</div>
			</div>
			
			
		</div>
	</ul>
</div>
</div>
</div>
-->
