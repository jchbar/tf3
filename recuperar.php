<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?php include('head.html'); ?>
<script src="ajx/revisarmail.js" type="text/javascript"></script>

</head>



<body>

	<?php 

include_once('classcrud.php');
$crud = new classcrud();
include ('header.html'); 
include_once('classtributos.php');
$tributo = new classtributos();
include_once('classbasededatos.php');
$con = new classbasededatos();
require_once "recaptchalib.php";
// tu clave secreta
$secret = "6LcK3goUAAAAAA1lddzclR0wTGvIRsAh0QHYHxKy"; // heros
// respuesta vacía
$response = null;
// comprueba la clave secreta
$reCaptcha = new ReCaptcha($secret);

if (!isset($_POST['numero']))
	pantalla_registro($tributo);
else
{
	// $con = new ClassBasedeDatos();
	// $con->conectar();
	// si se detecta la respuesta como enviada
	if ($_POST["g-recaptcha-response"]) {
	$response = $reCaptcha->verifyResponse(
	        $_SERVER["REMOTE_ADDR"],
	        $_POST["g-recaptcha-response"]
	    );
	}
	if ($_POST["g-recaptcha-response"])
	{
//		echo 'guardar datos '.$_POST['obtenidolocal'] ;
		if ($_POST['obtenidolocal'] == 0)
		{
			$tributo->recuperar_clave();
			alertar('Informacion','Recuperando datos...','Aviso');
		}
		else 
		{
			alertar('Error!','Datos no registrados por el error antes indicado','Error');
		}		
	}
	else alertar('Error!','Debe completar todos los campos solicitados','Error');



	echo '<form action="index.php" method="POST">';
	echo '<div class="col-md-6">';
	echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
	echo '</div>';
	echo '</form>';

}

function alertar($aviso, $mensaje,$tipo)
{
//	$con->ventana_alerta($aviso,$mensaje,($tipo == 'Aviso'?'success':'alert'));

	if ($tipo == 'Aviso')
		echo '<div class="alert alert-success" role="alert">';
	else echo '<div class="alert alert-danger" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	echo '<strong>'.$aviso.'</strong> ';
	echo $mensaje;
	echo '</div>';
}

function pantalla_registro($tributo)
{
	?>
<form class="form-inline" data-toggle="validator" role="form" id="registro" name="registro" method="POST" action="recuperar.php">
<div class="container-fluid">
    <section class="container">
		<div class="container-page">				
				<h3 class="dark-grey">Recuperaci&oacute;n de Clave</h3>
			  	<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label for "rif">RIF</label>
					<label for="Nacionalidad" class="sr-only control-label">Nacionalidad</label>
					<?php 
						$comando="select * from configuracion where nombreparametro = 'nacionalidad' order by valorparametro" ;
						$res=mysql_query($comando);
						echo '<select class="form-control" name="nacionalidad" id="nacionalidad" size="1">';
						while ($fila = mysql_fetch_assoc($res)) {
							echo '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
						}
						echo '</select>'; 
					?>
					<label  for="numero" class="sr-only control-label">N&uacute;mero</label>
					<input class="form-control" align="right" name="numero" type="text" id="numero" size="8" maxlength="8" value ="" placeholder="Numero RIF" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" required>

					<?php 
					echo '<select class="form-control" name="digito" id="digito" size="1">';
					echo '<option value="0" selected >0 </option>'; 
					for ($elfactor=1; $elfactor < 10; $elfactor++)
						echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
					echo '</select>'; 
					?>
				</div>
				<div class="clearfix"></div>

				<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label for "inputEmail" class="sr-only control-label">Email</label>
					    <div class="form-group col-sm-5">
							<input type="email" value="" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" data-error="Ups!!!...., No es una direccion valida" required autocomplete="off" size="60" maxlength="80"> <br>
							<div class="help-block with-errors"></div>
							<div id="resultado3"> </div>
						</div>
				</div>
				<div class="clearfix"></div>

		</div>

	</div>			
	<div align="center" class="g-recaptcha row col-xs-12 col-sm-12 col-md-12 col-lg-12" data-sitekey="6LcK3goUAAAAAA1lddzclR0wTGvIRsAh0QHYHxKy" ></div>
	<div align="center"  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<button type="submit" class="btn btn-primary" onclick="this.value='Por favor, espere...'">Recuperar clave &nbsp;<i class="fa fa-arrow-circle-right"></i></button>
	</div>
	<!-- </form> -->
	</div>

</form>
	<form align="center" class="form-inline" action="index.php" method="POST">
	<div align="center"  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>
	</div>
	</form>
		</div>
	</section>
</div>
	<script src='https://www.google.com/recaptcha/api.js'></script>
<?php

}

?>



<!--

https://1000hz.github.io/bootstrap-validator/

-->





