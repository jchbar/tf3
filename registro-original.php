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
			$tributo->guardar_registro();
			alertar('Informacion','Registrando datos...','Aviso');
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
	$con->mensaje_alerta($aviso,$mensaje,($tipo == 'Aviso'?'success':'alert'));
/*
	if ($tipo == 'Aviso')
		echo '<div class="alert alert-success" role="alert">';
	else echo '<div class="alert alert-danger" role="alert">';
	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	echo '<strong>'.$aviso.'</strong> ';
	echo $mensaje;
	echo '</div>';
*/
}

function pantalla_registro($tributo)
{
	?>
<form class="form-inline" data-toggle="validator" role="form" id="registro" name="registro" method="POST" action="registro.php" onSubmit="return validar_registro(form1)">
<div class="container-fluid">
    <section class="container">
		<div class="container-page">				
				<h3 class="dark-grey">Registro Para Pago de Tributos</h3>
				<!-- <form id="registro" name="registro" method="POST" onSubmit="return validar_registro(form1)"> -->		
			  	<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- div class="form-group col-md-6 col-lg-12"> 
					<input type="" name="" class="form-control" id="" value="">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<label>Nombre/Raz&oacute;n Social</label>
					<input type="" name="" class="form-control" id="" value="" readonly>
				</div>
				-->
					<label for "rif">RIF</label>
					<?// php $tributo->pedir_rif(); ?>
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
					<input class="form-control" align="right" name="numero" type="text" id="numero" size="9" maxlength="9" value ="" placeholder="Numero RIF" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" onblur="ajax_call_rif()" required>
					<label for "nombre" class="sr-only control-label">Nombre/Raz&oacute;n Social</label>
					<input class="form-control" align="right" name="nombre" type="text" id="nombre" placeholder="Nombre o Razon Social" size="100" maxlength="100" value ="" title="se necesita un nombre o razon social">
					<div id="resultado"> </div>
				</div>

			  	<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group">
				    <label for="inputPassword" class="sr-only control-label">Indique clave</label>
					    <div class="form-group col-sm-12">
							<input type="password" data-minlength="8" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
					        <div class="help-block">Recomendacion: al menos 8 caracteres</div>
					    </div>
					    <div class="form-group col-sm-12">
					        <input type="password" class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" placeholder="Confirme clave" data-match="#inputPassword" data-match-error="Ups!!!... las claves no son iguales" placeholder="Confirmar clave" required>
					        <div class="help-block with-errors"></div>
						</div>
					<div id="resultado2"> </div>
			    </div>
			    </div>

				<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label for "inputEmail" class="sr-only control-label">Email</label>
					    <div class="form-group col-sm-12">
							<input type="email" value="jchbar@cantv.net" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" data-error="Ups!!!...., No es una direccion valida" required autocomplete="off" size="60" maxlength="80" onblur="ajx_rev_mail()"> <br>
							<div class="help-block with-errors"></div>
					<div id="resultado3"> </div>
						</div>
						<div class="form-group col-sm-12">
							<input type="email" class="form-control" id="inputEmailConfirm" name="inputEmailConfirm" data-match="#inputEmail" data-match-error="Ups!!!... los emails no son iguales" placeholder="Confirmar email" required autocomplete="off" size="60" maxlength="80">
							<div class="help-block with-errors"></div>
						</div>			
				</div>

				<input type="hidden" class="form-control" id="emailcontrol" name="emailcontrol" data-match-error="Ups!!!... los emails no son iguales" placeholder="Confirmar email" required autocomplete="off">
<!-- conseguido localmente no activo

 --

 					<div class="form-inline row">
					    <div class="form-group col-sm-4">
							<input type="hidden" class="form-control" id="obtenidolocal" name="obtenidolocal" placeholder="Email" data-error="Ups!!!...., No es una direccion valida" value=0 required autocomplete="off">
						</div>
					
						<div class="form-group col-sm-4">
							<input type="hidden" class="form-control" id="obtenidolocalConfirm" name="obtenidolocalConfirm" data-match="#obtenidolocal" data-match-error="Ups!!!... los emails no son iguales" placeholder="Confirmar email" required autocomplete="off">
						</div>			
					</div>
	
<!--
				<div class="col-sm-6">
					<input type="checkbox" class="checkbox" />Sigh up for our newsletter
				</div>

				<div class="col-sm-6">
					<input type="checkbox" class="checkbox" />Send notifications to this email
				</div>				
-->			
			</div>

			<div class="col-md-12">
				<h3 class="dark-grey">Terminos y Condiciones</h3>
				<p>
					Haciendo click en  <strong>Registrar</strong> Ud. acepta los terminos y condiciones, Ud. recibira toda informacion que procese que se considere pertinente
				</p>
				<p>
					Puede recibir eventualmente emails informativos de nuestra cuenta 
				</p>
				<p>
				<!-- 
				faltan detalles por arreglar como la comparacion del email en lineas separadas y el click en el captcha las indicaciones estan en https://webdesign.tutsplus.com/es/tutorials/how-to-integrate-no-captcha-recaptcha-in-your-website--cms-23024
				-->
				</p>
				<p>
				</p>
	
				<div class="g-recaptcha" data-sitekey="6LcK3goUAAAAAA1lddzclR0wTGvIRsAh0QHYHxKy"></div>
				<button type="submit" class="btn btn-primary">Registrar</button>
			<!-- </form> -->
			</div>

</form>
	<form class="form-inline" action="index.php" method="POST">
		<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>
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





