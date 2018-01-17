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
		$sql="UPDATE campos SET articulo='".$codigo."', concepto='".$nombre."',
		cantidadut='".$unidad."', valorfraccion='".$fraccion."', funcionalidad='".$funcionalidad."'	, descripcionmedida='".$medida.
		"', utminimo='".$minimo."', utmaximo='".$maximo."', porcentajeaplicado='".$porcentaje."' WHERE idregistro='".$id."'";
		// echo $sql;
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