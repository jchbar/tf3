<?php

/**
 *   https://bitbucket.org/gbolivar_/searchcne/src/21d60eec7b6ee2cce5d0e6b5a9d5622b4c5dbd2b/getCNE.php?at=master
 * Clase encargada de gestionar diferentes paginas mediantes consumo sea por curl
 * hay que tener claro que podemos ejercer el consumo del html en caso que alla un cambio del resultado del
 * html del CNE hay que modificar las clases porque cambian las posiciones
 */

session_start();
extract($_GET);
extract($_POST);
extract($_SESSION);

include_once('../classbasededatos.php');
$con = new classbasededatos();
$con->conectar();
$articulo=$_GET['codigousuario'];
$vieja=$_GET['pp'];
$comando = "SELECT *, MD5('".$vieja."') as vieja from ingreso_usuario where (codigousuario = '".$articulo."')";
 //echo $comando;
$result = $con->consulta($comando);
$datos=$con->fetch_assoc($result);
if ($con->num_rows($result) < 1)
	$conseguido = 0;
else 
	if ($datos['vieja'] == $datos['clave'])
		$conseguido = 1;
	else 
	$conseguido = 0;

	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
	echo utf8_encode("<obtenido>".$conseguido."</obtenido>");
	echo "</resultados>";
$con->desconectar();
// http://www.genbetadev.com/desarrollo-web/authy-anade-autenticacion-en-dos-pasos-facilmente-a-tus-aplicaciones
?>
