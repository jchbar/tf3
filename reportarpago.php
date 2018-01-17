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
    $con=@mysqli_connect('localhost', 'jhernandez', 'nene14', 'modal');
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
		$sql="UPDATE timbresfiscales SET nroplanilla='".$planilla."', fechapago='".$fechapago."', plaza='".$plaza."', statustimbre=1 WHERE idregistro='".$id."'";
		// echo $sql;
		$query_update = $con->consulta($sql); //   mysqli_query($con,$sql);
		// echo $query_update;
			if ($query_update){
				$messages[] = "Los datos han sido actualizados satisfactoriamente.";
				enviar_mail_pago($con, $id, $planilla, $fechapago, $plaza);
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

	function enviar_mail_pago($conexion, $tramite, $planilla, $fechapago, $plaza)
	{
		$buscar = "select * from usuarios where rif_usuario = '".$_SESSION['rif']."'";
		$resb=$conexion->consulta($buscar);
		$enviara = $conexion->fetch_assoc($resb);
		$enviara = $enviara['email'];

		$buscar = "select * from timbresfiscales, campos, plazas where (timbresfiscales.idregistro = '".$tramite."') and (codigoente = campos.idregistro) and (plaza = plazas.codigo)";
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
		$cuento.= '<td>El presente email es para confirmar que se ha registrado el pago del siguiente tributo </td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Tramite Nro. = '.$tramite;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Tributo = '.$eltrib;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Planilla = '.$planilla;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Fecha de Pago = '.$fechapago;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Plaza = '.$eltri['nombre'];
		$cuento.= '</td>';
		$cuento.= '</tr>';


		$cuento.= '<tr>';
		$cuento.= '<td>Gracias por su atenci&oacuten</td>';
		$cuento.= '</tr>';
		$cuento.= '</table>';
// echo $cuento;
		return (enviar_email('Informacion sobre pago de Timbre Fiscal', $cuento, true, '', $enviadopor, $respondera , $enviara ) >0);
	}
	
	
?>	