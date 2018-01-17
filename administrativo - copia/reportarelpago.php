<?php
/*-----------------------
Autor: Obed Alvarado
http://www.obedalvarado.pw
Fecha: 27-02-2016
Version de PHP: 5.6.3
----------------------------*/
	# conectare la base de datos
/*
    $con=@mysqli_connect('localhost', 'jhernandez', 'nene14', 'modal');
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
*/
	include_once('ClassBasedeDatos.php');
	$con = new ClassBasedeDatos();
	$con->conectar();
	// 				$comando="select * from entidades, plazas where entidades.plaza = plazas.codigo order by codigo";
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['planilla'])){
			$errors[] = "Debe indicar numero de la planilla";
		} else if (empty($_POST['fechapago'])){
			$errors[] = "Debe indicar la fecha de pago";
		} else if (empty($_POST['plaza'])){
			$errors[] = "Debe indicar la  Entidad Bancaria ";
/*
		} else if (empty($_POST['capital'])){
			$errors[] = "Capital vacío";
		} else if (empty($_POST['continente'])){
			$errors[] = "Continente vacío";
*/
		}   else if (
			!empty($_POST['id']) &&
			!empty($_POST['planilla']) && 
			!empty($_POST['fechapago']) &&
			!empty($_POST['plaza']) 
			// &&
/*			!empty($_POST['capital']) &&
			!empty($_POST['continente']
			*/)
		{

		// escaping, additionally removing everything that could be (html/javascript-) code
		/* $codigo=$con->($con,(strip_tags($_POST["planilla"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["plaza"],ENT_QUOTES)));
		$moneda=mysqli_real_escape_string($con,(strip_tags($_POST["fechapago"],ENT_QUOTES))); */
/*
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["planilla"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["plaza"],ENT_QUOTES)));
		$moneda=mysqli_real_escape_string($con,(strip_tags($_POST["fechapago"],ENT_QUOTES)));
		$capital=mysqli_real_escape_string($con,(strip_tags($_POST["capital"],ENT_QUOTES)));
		$continente=mysqli_real_escape_string($con,(strip_tags($_POST["continente"],ENT_QUOTES)));
*/
		$id=intval($_POST['id']);
//		echo $fechapago;
		$planilla=$con->limpiar($_POST['planilla']);
		$fechapago=explode('/',$_POST['fechapago']);
		$fechapago=$fechapago[2].'-'.$fechapago[0].'-'.$fechapago[1];
		$plaza=$con->limpiar($_POST['plaza']);
		$observacion=$con->limpiar($_POST['original']. ' '.$_POST['observacion']);
		$sql="UPDATE timbresfiscales SET nroplanilla='".$planilla."', fechapago='".$fechapago."', plaza='".$plaza."', statustimbre=2, observacion='".$observacion."' WHERE idregistro='".$id."'";
		// echo $sql;
		$query_update = $con->consulta($sql); //   mysqli_query($con,$sql);
		// echo $query_update;
			if ($query_update){
				$messages[] = "Los datos han sido actualizados satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente."; // .mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>	