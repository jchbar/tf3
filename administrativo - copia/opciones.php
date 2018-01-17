<?php
session_start();

if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}

// include_once 'dbconfig.php';

/*
$stmt = $db_con->prepare("SELECT * FROM sgcapass WHERE alias=:uid");
$stmt->execute(array(":uid"=>$_SESSION['user_session']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
*/
include('head.html');
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:| CAja de Ahorro y Prestamo Obreros UCLA |:.</title>
<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script> -->
<script language="Javascript" src="../javascript.js" type='text/javascript'></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="../js/jquery3.js"></script>

<!-- los enlaces para menu multinivel -->
<!-- SmartMenus jQuery Bootstrap Addon CSS -->
<link href="../css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="../js/jquery.smartmenus.js"></script>
<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="../js/jquery.smartmenus.bootstrap.js"></script>
<!-- fin de los enlaces para menu multinivel -->


<link href="style.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="ConsultarCtasAsoc.js"></script>

<!--fechas -->
<link href="bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="bootstrap/js/moment-with-locales.js"></script>
<script src="bootstrap/js/bootstrap-datetimepicker.js"></script>
 
*/
?>
<script>
   $(document).ready(function()
   {
      $("#mostrarmodal").modal("show");
   });
</script>
</head>

<body>

<!--
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com">Coding Cage</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.codingcage.com/2015/11/ajax-login-script-with-jquery-php-mysql.html">Back to Article</a></li>
            <li><a href="http://www.codingcage.com/search/label/jQuery">jQuery</a></li>
            <li><a href="http://www.codingcage.com/search/label/PHP">PHP</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $_SESSION['user_session']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li> --
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Salir</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse --
      </div>
    </nav>
	-->
	
<?php
//if (isset($_SESSION['empresa']))
{
	date_default_timezone_set('America/Caracas'); 
/*
	include("funciones.php");
	include("revisarfallas2.php");
	$comando = "SELECT * FROM sgcaf8co";
	$afila = @mysql_query($comando);
	// echo 'fila '.$afila;
	if ($afila > 0)
	{
		$registro = mysql_fetch_assoc($afila);
		$hoy="SELECT NOW() as fechasistema";
		$fechasistema=mysql_query($hoy);
		$hoy=mysql_fetch_assoc($fechasistema);
		$hoy=$hoy['fechasistema'];
		$hoy=substr($hoy,0,10);
		// echo 'dia '.ddls(). $registro['fechanominalunes'] .'---'.$hoy;
		if (algo_fallo() == 0)
			if ((ddls() == "Monday") and ($registro['fechanominalunes'] < $hoy))
				menu_lunes();
			else
			//	if (ddls() == "Tuesday") //  "Wednesday")
				if ((ddls() == "Wednesday") and ($registro['fechanominamiercoles'] < $hoy))
					menu_miercoles();
				else menu_normal();
			// echo 'registro '.$registro['fechanominalunes']. ' hoy '.$hoy. ddls();
		}
*/
menu_normal();
}
?>

	
    
    
<div class="body-container">
<div class="container">
    <div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Bienvenido <?php echo $_SESSION['user_session']; ?></strong>.
    </div>
</div>
<div class="container">

<table class="table">
<tr>
<!--
<td><iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FCodingCage&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=198210627014732" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>
-->
<!--
<div style="height: 20px;">&nbsp;</div></td>
<td><a class="twitter-follow-button"
  href="https://twitter.com/cappoucla"
  data-show-count="true"  data-size="large"  data-lang="en">
Follow @cappoucla
</a>
<!--
<a class="twitter-follow-button"
  href="https://twitter.com/juanchernandezb"
  data-show-count="true"  data-size="large"  data-lang="en">
Follow @juanchernandezb
</a>
-->
</td>
<!--
<td>
<div class="g-person" data-width="299" data-href="https://plus.google.com/u/0/102500562123224112113" data-layout="landscape" data-rel="publisher"></div>
-->
</tr>
</table>
    
<!--
<script type="text/javascript">
window.twttr = (function (d, s, id) {
  var t, js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src= "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
  return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
}(document, "script", "twitter-wjs"));
</script>

<!-- Place this tag where you want the widget to render. -->


<!-- Place this tag after the last widget tag. --
<script type="text/javascript">
    (function() {
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
    })();
</script>
-->
    </div>
</div>

</div>
</div>


</div>

</div>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php

function buscarpermiso($valor,$permisomenu) {
	for ($i=0; $i<count($permisomenu);$i++) {
		if ($permisomenu[$i] == $valor) {
			return 1;}
	}
return 0;
}

function menu_normal()
{
?>
<!-- Navbar -->
<div class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><img alt="" src="identificacion/logo.jpg" style="width:200px;height:40px;margin-left:30px;margin-top: 2px;"> </a>
  </div>
  <div class="navbar-collapse collapse">

    <!-- Left nav -->
    <ul class="nav navbar-nav"> <!-- navbar-right"> -->
		<li><a href="movimientos.php">Movimientos</a>
	  <!-- menu actualizar -->
		<li><a href="#">Actualizar<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="tributos.php">Tributos</a></li>
				<li><a href="usuarios.php">Usuarios</a></li>
				<li><a href="unidad.php">Unidad Tributaria</a></li>
				<?php
					include_once('classbasededatos.php');
					$con = new classbasededatos();
					$con->conectar();
					$comando="select * from configuracion where nombreparametro='ActivarAliados'";
					$result = $con->consulta($comando);
					$res = $con->fetch_assoc($result);
					if ($fila['valorparametro'] == 'Si')
					{
						echo '<li><a href="aliados.php">Aliados</a></li>';
					}
					$con->desconectar();
				?>
				<li><a href="notificar.php">Notificaciones</a></li>
			</ul>
	  </li>
	  <!-- fin menu socios -->

	  <!-- menu reportes -->
		<li><a href="#">Reportes<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href=".php">Tributos</a></li>
				<li><a href=".php">Usuarios</a></li>
				<li><a href=".php">Unidad Tributaria</a></li>
				<li class="divider"></li>
				<li><a href="#">Timbres Fiscales<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href=".php">Generados</a></li>
						<li><a href=".php">Pagados</a></li>
						<li><a href=".php">Usados</a></li>
					</ul>
				</li>
				<li class="divider"></li>
				<?php
					include_once('classbasededatos.php');
					$con = new classbasededatos();
					$con->conectar();
					$comando="select * from configuracion where nombreparametro='ActivarAliados'";
					$result = $con->consulta($comando);
					$res = $con->fetch_assoc($result);
					if ($fila['valorparametro'] == 'Si')
					{
						echo '<li><a href=".php">Aliados</a></li>';
//						echo '<li class="divider"></li>';
					}
					$con->desconectar();
				?>
				<li><a href="notificar.php">Notificaciones</a></li>
			</ul>
	  </li>
	  <!-- fin menu reportes -->

	  <!-- prestamos --
		<li><a href="#">Pr&eacute;stamos<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="#">Actualizar<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="solpre.php">Solicitudes</a></li>
						<li><a href="aboxnom2.php">Abonos x Nomina</a></li>
						<li><a href="recing.php">Recibos de Ingreso</a></li>
						<li><a href="tippre.php">Tipos de Prestamo</a></li>
						<li><a href="#">Pr&eacute;stamos Especiales<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="disabled"><a class="disabled" href="zapatos.php">Zapateria</a></li>
								<li class="disabled"><a class="disabled" href="zapatosm.php">Zapateria (al Mayor)</a></li>
								<li class="disabled"><a class="disabled" href="motos.php">Motos</a></li>

								<li><a href="#">Viajes<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="viajes.php">Pr&eacute;stamo</a></li>
										<li><a href="lviajes.php">Listado</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li><a href="#">Cargar Nominas Especiales<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="Funeraria.php">Funeraria (046)</a></li>
								<li><a href="Farmacia.php">Farmacia (004)</a></li>
								<li><a href="ayudasoli.php">Ayuda Solidaria (024)</a></li>
								<li><a href="medical.php">Medical Assist Semanal (071)</a></li>
								<li><a href="especial_farmacia.php">Dcto.Especial Farmacia (067)</a></li>
								<li><a href="emi.php">EMI (005)</a></li>
								<li><a href="mundolent.php">Lentes Anual (072)</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="divider"></li>
				<li><a href="#">Reportes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="cuoban.php">Cuota a Banco</a></li>
						<li><a href="depositobanco2.php">Deposito a Banco</a></li>
						<li><a href="salpre.php">Saldos de Prestamos</a></li>
						<li class="disabled"><a class="disabled" href=".php">Prestamos Otorgados</a></li>
						<li><a href="cuocero.php">Cuotas en Cero</a></li>
						<li><a href="monmut.php">Monte Pio/Mutuo Auxilio</a></li>
						<li><a href="vernompre.php">Ver Nominas de Prestamos</a></li>
					</ul>
				<li class="divider"></li>
				<li><a href="devoluciones.php">Devoluciones</a></li>
				<li><a href="regacta.php">Registrar Acta</a></li>
				</li>
			</ul>
	  </li>
	  <!-- fin menu prestamos --

	  <!-- contabilidad --
		<li><a href="#">Contabilidad<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="#">Asientos<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="altaasim.php">Simples</a></li>
						<li><a href="altaasigral.php">Generales</a></li>
						<li><a href="editasi2.php">Buscar/Editar</a></li>
					</ul>
				</li>
				<li><a href="#">Cuentas<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="cuentas.php">Alta</a></li>
						<li><a href="reiniciar.php">Reiniciar</a></li>
						<li><a href="cam_fech.php">Cambio de Fecha</a></li>
						<li><a href="precie.php">Pre-Cierre</a></li>
					</ul>
				</li>
				<li class="divider"></li>
				<li><a href="#">Reportes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="cueaso.php">Cuentas Asociadas</a></li>
						<li><a href="#">Balances<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="balcom.php">Comprobaci&oacute;n</a></li>
								<li><a href="balgen.php">General</a></li>
								<li><a href="sudeca-forma-a.php">SUDECA FORMA-A</a></li>
								<li><a href="estres.php">Estado de Resultados</a></li>
								<li><a href="resdia.php">Resumen de Diario</a></li>
							</ul>
						</li>
						<li><a href="#">Otros<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="diario.php">Diario</a></li>
								<li><a href="asidescu.php">Comprobantes Diferidos</a></li>
								<li><a href="#">Mayor Anal&iacute;tico<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="extractoctas3.php">A&nacute;o Actual</a></li>
										<li><a href="extractoctas_hist.php">A&nacute;os Anteriores</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
	  </li>
	  <!-- fin menu contabilidad --

	  <!-- menu cheques --
		<li><a href="#">Cheques<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="#">Actualizar<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="cheact.php">Cheques</a></li>
						<li><a href="chequeras.php">Chequeras</a></li>
						<li><a href="bancos.php">Bancos</a></li>
						<li><a href="conceptos.php">Conceptos</a></li>
						<li><a href="che_verif.php">Verificaci&oacute;n</a></li>
					</ul>
				</li>
				<li class="divider"></li>
				<li><a href="#">Reportes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="cheimpr.php">Impresi&oacute;n</a></li>
						<li><a href="che_rel.php">Relaci&oacute;n</a></li>
						<li><a href="che_compr.php">Generar comprobantes</a></li>
						<li><a href="conciliacion.php">Conciliaci&oacute;n</a></li>
					</ul>
				</li>
			</ul>
	  </li>
	  <!-- fin menu cheques --
	  
	  <!-- menu activos fijos  --
		<li><a href="#">Activos Fijos<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="#">Actualizar<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="lisact.php">Incorporaci&oacute;n</a></li>
						<li><a href="desact.php">Desincorporar</a></li>
						<li><a href="depact.php">Depreciaci&oacute;n</a></li>
						<li><a href="departamentos.php">Departamentos</a></li>
					</ul>
				</li>
				<li class="divider"></li>
				<li><a href="#">Reportes<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a target=\"_blank\" href="lisactpdf.php">Activos Fijos</a></li>
						<li><a href="desactpdf.php">Desincorporados</a></li>
						<li><a href="listotpdf.php">Totalmente Depreciados</a></li>
					</ul>
				</li>
			</ul>
	  </li>
	  <!-- fin menu cheques -->
          <!-- <ul class="nav navbar-nav navbar-right"> -->
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hola <?php echo $_SESSION['user_session']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li> -->
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Salir</a></li>
              </ul>
            </li>
          <!-- </ul> -->
	  
<!--
      <li><a href="#">Link</a></li>
      <li><a href="#">Link</a></li>
      <li><a href="#">Dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">Nav header</li>
          <li><a href="#">Separated link</a></li>
          <li><a href="#">One more separated link <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">A long sub menu <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="disabled"><a class="disabled" href="#">Disabled item</a></li>
                  <li><a href="#">One more link</a></li>
                  <li><a href="#">Menu item 1</a></li>
                  <li><a href="#">Menu item 2</a></li>
                  <li><a href="#">Menu item 3</a></li>
                  <li><a href="#">Menu item 4</a></li>
                  <li><a href="#">Menu item 5</a></li>
                  <li><a href="#">Menu item 6</a></li>
                  <li><a href="#">Menu item 7</a></li>
                  <li><a href="#">Menu item 8</a></li>
                  <li><a href="#">Menu item 9</a></li>
                  <li><a href="#">Menu item 10</a></li>
                  <li><a href="#">Menu item 11</a></li>
                  <li><a href="#">Menu item 12</a></li>
                  <li><a href="#">Menu item 13</a></li>
                  <li><a href="#">Menu item 14</a></li>
                  <li><a href="#">Menu item 15</a></li>
                  <li><a href="#">Menu item 16</a></li>
                  <li><a href="#">Menu item 17</a></li>
                  <li><a href="#">Menu item 18</a></li>
                  <li><a href="#">Menu item 19</a></li>
                  <li><a href="#">Menu item 20</a></li>
                  <li><a href="#">Menu item 21</a></li>
                  <li><a href="#">Menu item 22</a></li>
                  <li><a href="#">Menu item 23</a></li>
                  <li><a href="#">Menu item 24</a></li>
                  <li><a href="#">Menu item 25</a></li>
                  <li><a href="#">Menu item 26</a></li>
                  <li><a href="#">Menu item 27</a></li>
                  <li><a href="#">Menu item 28</a></li>
                  <li><a href="#">Menu item 29</a></li>
                  <li><a href="#">Menu item 30</a></li>
                  <li><a href="#">Menu item 31</a></li>
                  <li><a href="#">Menu item 32</a></li>
                  <li><a href="#">Menu item 33</a></li>
                  <li><a href="#">Menu item 34</a></li>
                  <li><a href="#">Menu item 35</a></li>
                  <li><a href="#">Menu item 36</a></li>
                  <li><a href="#">Menu item 37</a></li>
                  <li><a href="#">Menu item 38</a></li>
                  <li><a href="#">Menu item 39</a></li>
                  <li><a href="#">Menu item 40</a></li>
                  <li><a href="#">Menu item 41</a></li>
                  <li><a href="#">Menu item 42</a></li>
                  <li><a href="#">Menu item 43</a></li>
                  <li><a href="#">Menu item 44</a></li>
                  <li><a href="#">Menu item 45</a></li>
                  <li><a href="#">Menu item 46</a></li>
                  <li><a href="#">Menu item 47</a></li>
                  <li><a href="#">Menu item 48</a></li>
                  <li><a href="#">Menu item 49</a></li>
                  <li><a href="#">Menu item 50</a></li>
                  <li><a href="#">Menu item 51</a></li>
                  <li><a href="#">Menu item 52</a></li>
                  <li><a href="#">Menu item 53</a></li>
                  <li><a href="#">Menu item 54</a></li>
                  <li><a href="#">Menu item 55</a></li>
                  <li><a href="#">Menu item 56</a></li>
                  <li><a href="#">Menu item 57</a></li>
                  <li><a href="#">Menu item 58</a></li>
                  <li><a href="#">Menu item 59</a></li>
                  <li><a href="#">Menu item 60</a></li>
                </ul>
              </li>
              <li><a href="#">Another link</a></li>
              <li><a href="#">One more link</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
-->
    <!-- Right nav -->
<!-- 
    <ul class="nav navbar-nav navbar-right">
      <li class="active"><a href="bootstrap-navbar.html">Default</a></li>
      <li><a href="bootstrap-navbar-static-top.html">Static top</a></li>
      <li><a href="bootstrap-navbar-fixed-top.html">Fixed top</a></li>
      <li><a href="bootstrap-navbar-fixed-bottom.html">Fixed bottom</a></li>
      <li><a href="#">Dropdown <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">Nav header</li>
          <li><a href="#">A sub menu <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="disabled"><a class="disabled" href="#">Disabled item</a></li>
              <li><a href="#">One more link</a></li>
            </ul>
          </li>
          <li><a href="#">A separated link</a></li>
        </ul>
      </li>
    </ul>

  </div><!--/.nav-collapse -->
</div>


	
<?php
}

function menu_miercoles()
{
echo '<ul>';
echo '<li><a href="?accion=1">Bienvenid@</a></li>';
echo '<li><a href="">Préstamos</a>';
echo '<ul>';
echo '<li><a href="">Reportes</a>';
echo '<ul>';
echo '<li><a href="cuoban.php">Cuota a Banco</a></li>';
echo '</ul>';
echo '</li>';
}

function menu_lunes()
{
echo '<ul>';
echo '<li><a href="?accion=1">Bienvenid@</a></li>';
echo '<li><a href="">Préstamos</a>';
echo '<ul>';
echo '<li><a href="">Actualizar</a>';
echo '<ul>';
echo '<li><a href="aboxnom2.php">Abonos x Nomina</a></li>';
echo '<ul>';
echo '</li>';
}


function ddls()
{
	$hoy="SELECT NOW() as fechasistema";
	$fechasistema=mysql_query($hoy);
	$hoy=mysql_fetch_assoc($fechasistema);
	$completa = $hoy['fechasistema'];
	$hoy=$hoy['fechasistema'];
	$hoy=substr($hoy,0,10);
	$ddls= date('l', strtotime($hoy));
	return $ddls;
}
