<?php

/*
Author: Pradeep Khodke
URL: http://www.codingcage.com/
*/
session_start();
/*
if(isset($_SESSION['user_session'])!="")
{
	header("Location: home.php");
}
*/
include_once('classcrud.php');
$crud = new classcrud();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="validation.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" media="screen">
<script type="text/javascript" src="script.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="../bootstrap/js/jquery3.js"></script>
<script type="text/javascript" src="../validation.min.js"></script>
<link href="../bootstrapstyle.css" rel="stylesheet" type="text/css" media="screen">
<script type="text/javascript" src="script.js"></script>
-->

<?php include('head.html'); ?>
<script type="text/javascript" src="validation.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>

<body>
	<?php include ('header.html'); ?>

   
<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Ingreso al Sistema</h2><hr />
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group col-xs-12 col-sm-8 col-md-6">
        <input type="email" class="form-control" placeholder="Su direccion de email" name="nombre_usuario" id="nombre_usuario" aria-describedby="help-nombre" autocomplete="off"/>
        <span id="check-t"></span>
        </div>
        
        <div class="form-group col-xs-12 col-sm-8 col-md-6">
        <input type="password" class="form-control" placeholder="Password/Clave" name="password" id="password" />
        </div>
       
     	<hr />
        
        <div class="form-group col-xs-12 col-sm-8 col-md-9">
            <button type="submit" class="btn btn-success" name="btn-login" id="btn-login">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Validar
			</button> 
      </form>
			<div class="form-group col-xs-12 col-sm-8 col-md-9">
				<form class="form-signin form-inline" method="post" id="regresr" action="recuperar.php">
					<div class="col-md-3">
					<button class="btn btn-info" value="Regresar" name="Regresar">Recuperar Clave</button>
					</div>
				</form>
			</div>
        </div>  
      

    </div>
    
</div>

</body>
</html>