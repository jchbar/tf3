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
	 if (empty($_POST['id'])){
			$errors[] = "ID vacío";
	}   
	else if (empty($_POST['status'])){ 
				$errors[] = "Status vacío";
	}
	else if ((!empty($_POST['id'])) and (!empty($_POST['status'])))
	{

		// escaping, additionally removing everything that could be (html/javascript-) code
		$id=intval($_POST['id']);
		
		$sql="UPDATE ingreso_usuario set status = '".($_POST['status']==1?2:1)."' WHERE codigousuario='".$id."'";
		// echo $sql;
		$query_delete = $con->consulta($sql);
		if ($query_delete){
			$messages[] = "Se ha cambiado el status satisfactoriamente.";
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