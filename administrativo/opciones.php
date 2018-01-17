<?php
session_start();
// include('validasesion.php');
// echo 'session'.$_SESSION['usuario_sistema'];
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
include('head.html');
?>
<script>
   $(document).ready(function()
   {
      $("#mostrarmodal").modal("show");
   });
</script>
    <script>
$.sessionTimeout({
        keepAliveUrl: 'keep-alive.html',
        logoutUrl: 'index.php',
        redirUrl: 'locked.php',
        warnAfter: ((4*60)*1000),  // segundos 15 
        redirAfter: ((15+(4*60))*1000), // 
//        warnAfter: (5000),  // segundos 15 
//        redirAfter: (10000), // 
        countdownBar: true,
        countdownMessage: 'Redireccionando en {timer} segundos...'
    });
    </script>
</head>

<body>

<?php
{
	date_default_timezone_set('America/Caracas'); 
menu_normal();
}
?>
    
<div class="body-container">
<div class="container">
    <div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Bienvenido <?php echo $_SESSION['nombre_usuario']; ?></strong>.
    </div>
</div>
<div class="container">
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
				<li><a href="unidadt.php">Unidad Tributaria</a></li>
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
				<li><a href="rpt_tributos.php">Tributos</a></li>
				<li><a href="rpt_usuarios.php">Usuarios</a></li>
				<li><a href="rpt_ut.php">Unidad Tributaria</a></li>
				<li class="divider"></li>
				<li><a href="#">Timbres Fiscales<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="">Generados</a></li>
						<li><a href="">Pagados</a></li>
						<li><a href="">Usados</a></li>
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
				<li><a href="rpt_notificar.php">Notificaciones</a></li>
			</ul>
	  </li>
	  <!-- fin menu reportes -->

          <!-- <ul class="nav navbar-nav navbar-right"> -->
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hola <?php echo $_SESSION['user_session']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="copiasegu.php"><span></span>&nbsp;Copia de Seguridad</a></li>
                <li><a href="cs2.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Cambiar Clave</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Salir</a></li>
              </ul>
            </li>
          <!-- </ul> -->
	  
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
