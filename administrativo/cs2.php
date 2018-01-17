<?
session_start();
// echo 'session'.$_SESSION['usuario_sistema'];
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
include ('head.html'); 
?>
<script src="ajx/buscarpwd.js" type="text/javascript"></script>
</head>
<body>
<?php
include_once('classcrud.php');
$crud = new classcrud();
include_once('classtributos.php');
$tributo = new classtributos();
echo '<body>';
include ('header.html'); 
if (!isset($_POST['newpw']))
{

?>


<section id="main-body" class="container">
	<div class="row">
        <div class="col-md-9 pull-md-right main-content">
			<div class="tab-content margin-bottom">
			<div class="tab-pane fade in active" id="tabOverview">
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-6">
						</div>
					</div>
				</div>
				<div class="tab-pane fade in" id="tabChangepw">
					<h3>Cambiar Contraseña</h3>
						<form class="form-horizontal using-password-strength" method="post" action="cs2.php" role="form">

							<div id="vieja" class="form-group">
								<label for="vieja" class="col-sm-5 control-label">Contraseña Actual</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" id="pwdvieja" name="pwdvieja" onblur="ajx_rev_pwd()" />
									<div id="respwd"></div>
								</div>
							</div>
							<input type="hidden" name="token" value="71e27c3319f6f6f37673dcadb0fd669afe8cb27c" />
							<input type="hidden" id = "id" name="id" value="<?php echo $_SESSION['usuario_sistema']; ?>" />
							<input type="hidden" name="modulechangepassword" value="true" />

							<div id="newPassword1" class="form-group has-feedback">
								<label for="inputNewPassword1" class="col-sm-5 control-label">Nueva Contraseña</label>
								<div class="col-sm-6">
									<input type="password" class="form-control" id="inputNewPassword1" name="newpw" />
									<span class="form-control-feedback glyphicon"></span>
									<br />
									<div class="progress" id="passwordStrengthBar">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">New Password Rating: 0%</span>
									</div>
								</div>

								<div class="alert alert-info">
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
							<label for="inputNewPassword2" class="col-sm-5 control-label">Confirmar Nueva Contraseña</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="inputNewPassword2" name="confirmpw" />
								<span class="form-control-feedback glyphicon"></span>
								<div id="inputNewPassword2Msg">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-6 col-sm-6">
									<input class="btn btn-success" type="submit" value="Guardar Cambios" />
									<input class="btn btn-warning" type="reset" value="Cancelar" />
								</div>
							</div>
						</form>
				</div>
			</div>
        </div><!-- /.main-content -->
    </div>
    <div class="clearfix"></div>
</section>
<?php
}
else
{
	include_once('classbasededatos.php');
	$con = new classbasededatos();
	include_once('classtributos.php');
	$cont = new classtributos();
	$con->conectar();
	$sql="UPDATE ingreso_usuarios set clave = MD5('".$_POST['newpw']."') where codigousuario = '".$_SESSION['usuario_sistema']."'";
//	echo $sql;
	$cont->ventana_alerta('info','Informacion','Se ha procesado correctamente');
	$con->consult($sql);
	$con->desconectar();	
			echo "<form action='opciones.php' name='form1' id='form1' method='post'>";
			echo '<div class="col-xs-12 col-sm-2 col-md-2`">';
			echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
			echo '<div>';
			echo '</form>';
}
?>



</body>
</html>
