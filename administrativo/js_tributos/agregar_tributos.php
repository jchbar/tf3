<?php
session_start();
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
	// echo 'conec...';
	/*Inicia validacion del lado del servidor*/
	 if (empty($_POST['codigo'])){
			$errors[] = "Art&iacute;culo vacío";
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
			!empty($_POST['codigo']) && 
			!empty($_POST['nombre']) 
/*
			&&
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
	// echo '1...';
		$codigo = $_POST['codigo'];
		$nombre = $_POST['nombre'];
		$unidad = $_POST['unidad'];
		$fraccion= $_POST['fraccion'];
		$valor = $_POST['valor'];
		$funcionalidad = $_POST['funcionalidad'];
		$medida = $_POST['medida'];
		$minimo= $_POST['cntminimo'];
		$maximo = $_POST['cntmaxima'];
		$porcentaje= $_POST['porcentaje'];
		// echo '2...';
		$sql="INSERT INTO campos (articulo, concepto, cantidadut, valorfijo, funcionalidad, descripcionmedida, porcentajeaplicado, utminimo, utmaximo, valorfraccion) 
			VALUES ('".$codigo."','".$nombre."','".$unidad."', '".$valor."','".$funcionalidad."', '".$medida."', '".$porcentaje."', '".$minimo."',', '".$maximo."',', '".$fraccion."')";
		//	echo $sql;
		$query_update = $con->consulta($sql);
			if ($query_update){
				$messages[] = "Los datos han sido guardados satisfactoriamente.";
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