<?php
session_start();
/*-----------------------
Autor: Obed Alvarado
http://www.obedalvarado.pw
Fecha: 27-02-2016
Version de PHP: 5.6.3
----------------------------*/
	# conectare la base de datos
/*
    $con=@mysqli_connect('localhost', 'root', '', 'test_modal');
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
*/
	include_once('classbasededatos.php');
	$con = new classbasededatos();
	$con->conectar();
	/*Inicia validacion del lado del servidor*/
	 if (empty($_POST['id'])){
			$errors[] = "ID vacío";
		}   else if (
			!empty($_POST['id']) 
			
		){

		// escaping, additionally removing everything that could be (html/javascript-) code
		// $id_pais=intval($_POST['id_pais']);
		
		$id=intval($_POST['id']);
		$sql="DELETE FROM timbresfiscales WHERE idregistro ='".$id."'";
	// 	echo $sql;
	//	$query_delete = $con->consulta($sql); // mysqli_query($con,$sql);
	$query_delete=1;
			if ($query_delete){
				$messages[] = "Los datos han sido eliminados satisfactoriamente.";
				enviar_mail_eliminacion($con, $id);
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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

	function enviar_mail_eliminacion($conexion, $tramite)
	{
		$buscar = "select * from usuarios where rif_usuario = '".$_SESSION['rif']."'";
		$resb=$conexion->consulta($buscar);
		$enviara = $conexion->fetch_assoc($resb);
		$enviara = $enviara['email'];

		$buscar = "select * from timbresfiscales, campos  where (timbresfiscales.idregistro = '".$tramite."') and (codigoente = campos.idregistro)";
		// echo $buscar;
		$resb=$conexion->consulta($buscar);
		$eltri = $conexion->fetch_assoc($resb);
		$eltrib = $eltri['articulo']. ' / '.$eltri['concepto'];
		
		$buscar="select * from configuracion where nombreparametro = 'mailenviadopor'";
		$resb=$conexion->consulta($buscar);
		$enviadopor = $conexion->fetch_assoc($resb);
		$enviadopor = $enviadopor['valorparametro'];
		
		$buscar="select * from configuracion where nombreparametro = 'responderemail'";
		$resb=$conexion->consulta($buscar);
		$respondera = $conexion->fetch_assoc($resb);
		$respondera = $respondera['valorparametro'];

		$buscar="select * from configuracion where nombreparametro = 'direccionweb'";
		$resb=$conexion->consulta($buscar);
		$dirweb = $conexion->fetch_assoc($resb);
		$dirweb = $dirweb['valorparametro'];

		include_once('enviarmail.php');

		$cuento= '<table>';
		$cuento.= '<tr>';
		$cuento.= '<td><img src="'.$dirweb.'/identificacion/logo.jpg"/></td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td><strong>Estimada(o) Contribuyente:</strong></td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td><strong>'.$_SESSION['nombre_usuario'] .'</strong> ('.$_SESSION['rif'].')</td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td>El presente email es para informar que ha procedido a eliminar el siguiente tributo de su cuenta</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Tramite Nro. = '.$tramite;
		$cuento.= '</td>';
		$cuento.= '</tr>';

/*
		$cuento.= '<tr>';
		$cuento.= '<td>Tributo = '.$eltrib;
		$cuento.= '</td>';
		$cuento.= '</tr>';
*/

		$cuento.= '<tr>';
		$cuento.= '<td>Gracias por su atenci&oacuten</td>';
		$cuento.= '</tr>';
		$cuento.= '</table>';
// echo $cuento;
		return (enviar_email('Eliminacion de Timbre Fiscal', $cuento, true, '', $enviadopor, $respondera , $enviara ) >0);
	}

?>	