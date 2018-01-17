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
					<!-- <input class="form-control" align="right" name="numero" type="text" id="numero" size="9" maxlength="9" value ="" placeholder="Numero RIF" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" onblur="ajax_call_rif()" required> -->
					<input class="form-control" align="right" name="numero" type="text" id="numero" size="8" maxlength="8" value ="" placeholder="Numero RIF" onchange="validarsinumero(this.value);"  title="se necesita el numero de cedula" required>

					<?php 
					echo '<select class="form-control" name="digito" id="digito" size="1">';
					echo '<option value="0" selected >0 </option>'; 
					for ($elfactor=1; $elfactor < 10; $elfactor++)
						echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
					echo '</select>'; 
					?>
				<!-- 
			  	<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12"> -->
					<label for "nombre" class="sr-only control-label">Nombre/Raz&oacute;n Social</label>
					<input class="form-control" align="right" name="nombre" type="text" id="nombre" placeholder="Nombre o Razon Social" size="100" maxlength="100" value ="" title="se necesita un nombre o razon social">
					<div id="resultado"> </div>
				<!-- 
				</div> -->

				</div>
				<div class="clearfix"></div>

			  	<!-- 
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
				-->

				<div class="form-group form-inline row col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label for "inputEmail" class="sr-only control-label">Email</label>
					    <div class="form-group col-sm-5">
							<input type="email" value="" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" data-error="Ups!!!...., No es una direccion valida" required autocomplete="off" size="60" maxlength="80" onblur="ajx_rev_mail()"> <br>
							<div class="help-block with-errors"></div>
					<div id="resultado3"> </div>
						</div>
						<div class="form-group col-sm-5">
							<input type="email" class="form-control" id="inputEmailConfirm" name="inputEmailConfirm" data-match="#inputEmail" data-match-error="Ups!!!... los emails no son iguales" placeholder="Confirmar email" required autocomplete="off" size="60" maxlength="80">
							<div class="help-block with-errors"></div>
						</div>			
				</div>
				<div class="clearfix"></div>

				<div class="tab-pane fade in" id="tabChangepw">
						<!-- form class="form-horizontal using-password-strength" method="post" action="#tabChangepw" role="form">-->

							<div id="newPassword1" class="form-group has-feedback">
								<label for="inputNewPassword1" class="sr-only col-sm-1 control-label">Su Contraseña</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" id="inputNewPassword1" name="newpw" placeholder="Password" required/>
									<span class="form-control-feedback glyphicon"></span>
									<br />
									<div class="progress" id="passwordStrengthBar">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">New Password Rating: 0%</span>
									</div>
								</div>

								<div class="alert alert-warning">
									<strong>Consejos Útiles:</strong><br />* Utilice ambos caracteres, mayúsculas y minúsculas<br />* Incluya al menos un símbolo (# $ ! % &amp; etc...)<br />* No utilice palabras del diccionario
								</div>


								<script type="text/javascript">
								jQuery("#inputNewPassword1").keyup(function() {
									var $newPassword1 = jQuery("#newPassword1");
									var pw = jQuery("#inputNewPassword1").val();
									var pwlength=(pw.length);
									if(pwlength>5)pwlength=5;
									else if(pwlength>4)pwlength=4.5;
									else if(pwlength>2)pwlength=3.5;
									else if(pwlength>0)pwlength=2.5;
									var numnumeric=pw.replace(/[0-9]/g,"");
									var numeric=(pw.length-numnumeric.length);
									if(numeric>3)numeric=3;
									var symbols=pw.replace(/\W/g,"");
									var numsymbols=(pw.length-symbols.length);
									if(numsymbols>3)numsymbols=3;
									var numupper=pw.replace(/[A-Z]/g,"");
									var upper=(pw.length-numupper.length);
									if(upper>3)upper=3;
									var pwstrength=((pwlength*10)-20)+(numeric*10)+(numsymbols*15)+(upper*10);
									if (pwstrength < 0) pwstrength = 0;
									if (pwstrength > 100) pwstrength = 100;

									$newPassword1.removeClass('has-error has-warning has-success');
									jQuery("#inputNewPassword1").next('.form-control-feedback').removeClass('glyphicon-remove glyphicon-warning-sign glyphicon-ok');
									jQuery("#passwordStrengthBar .progress-bar").removeClass("progress-bar-danger progress-bar-warning progress-bar-success").css("width", pwstrength + "%").attr('aria-valuenow', pwstrength);
									jQuery("#passwordStrengthBar .progress-bar .sr-only").html('New Password Rating: ' + pwstrength + '%');
									if (pwstrength < 30) {
										$newPassword1.addClass('has-error');
										jQuery("#inputNewPassword1").next('.form-control-feedback').addClass('glyphicon-remove');
										jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-danger");
									} else if (pwstrength < 75) {
										$newPassword1.addClass('has-warning');
										jQuery("#inputNewPassword1").next('.form-control-feedback').addClass('glyphicon-warning-sign');
										jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-warning");
									} else {
										$newPassword1.addClass('has-success');
										jQuery("#inputNewPassword1").next('.form-control-feedback').addClass('glyphicon-ok');
										jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-success");
									}
									validatePassword2();
								});

								function validatePassword2() {
									var password1 = jQuery("#inputNewPassword1").val();
									var password2 = jQuery("#inputNewPassword2").val();
									var $newPassword2 = jQuery("#newPassword2");

									if (password2 && password1 !== password2) {
										$newPassword2.removeClass('has-success')
											.addClass('has-error');
										jQuery("#inputNewPassword2").next('.form-control-feedback').removeClass('glyphicon-ok').addClass('glyphicon-remove');
										jQuery("#inputNewPassword2Msg").html('<p class="help-block">The passwords entered do not match</p>');
										jQuery('input[type="submit"]').attr('disabled', 'disabled');    } else {
										if (password2) {
											$newPassword2.removeClass('has-error')
												.addClass('has-success');
											jQuery("#inputNewPassword2").next('.form-control-feedback').removeClass('glyphicon-remove').addClass('glyphicon-ok');
											jQuery('.main-content input[type="submit"]').removeAttr('disabled');        } else {
											$newPassword2.removeClass('has-error has-success');
											jQuery("#inputNewPassword2").next('.form-control-feedback').removeClass('glyphicon-remove glyphicon-ok');
										}
										jQuery("#inputNewPassword2Msg").html('');
									}
								}

								jQuery(document).ready(function(){
									jQuery('.using-password-strength input[type="submit"]').attr('disabled', 'disabled');    jQuery("#inputNewPassword2").keyup(function() {
										validatePassword2();
									});
								});

								</script>
							</div>
							<label for="inputNewPassword2" class="sr-only col-sm-2 control-label">Confirmar Contraseña</label>
							<div class="col-sm-2">
								<input type="password" class="form-control" id="inputNewPassword2" name="confirmpw" placeholder="Confirmar  Contraseña" required />
								<span class="form-control-feedback glyphicon"></span>
								<div id="inputNewPassword2Msg">
								</div>
							</div>
							<!-- 
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<input class="btn btn-success" type="submit" value="Registrarse" />
									<input class="btn btn-warning" type="reset" value="Cancelar" />
								</div>
							</div>
							-->
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

			<div class="text-center">
				<p>
                <label class="checkbox-inline" style="font-size:14px;">
                <input type="checkbox" name="aceptartos" id="aceptartos" />
					&nbsp;
                    Declaro que he leído y estoy de acuerdo con los
					<a href="terminos.shtml" target="_blank">Términos del Servicio y Condiciones de Uso</a>
                </label>
                </p>
                    
                  <!-- <button type="submit" id="btnCompleteOrder" class="btn btn-primary btn-lg" onclick="this.value='Por favor, espere...'">
                        Completar Pedido
                        &nbsp;<i class="fa fa-arrow-circle-right"></i>
                    </button> -->
			</div>			
			<!-- 
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
				--
				</p>
				<p>
				</p>
			-->
				<div class="g-recaptcha" data-sitekey="6LcK3goUAAAAAA1lddzclR0wTGvIRsAh0QHYHxKy"></div>
				<button type="submit" class="btn btn-primary" onclick="this.value='Por favor, espere...'">Registrar &nbsp;<i class="fa fa-arrow-circle-right"></i></button>
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





