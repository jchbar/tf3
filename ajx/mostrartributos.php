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

include_once('../classcrud.php');
$crud = new classcrud();
// include_once '../dbconfig.php';
$con = new classbasededatos();
$con->conectar();
$articulo=$_GET['articulo'];
$comando = "select * from campos where idregistro = '".$articulo."'";
$result = $con->consulta($comando);
// $res = $con->fetch_assoc($result);
// $res=mysql_query($comando);
// echo $comando;
$datos=$con->fetch_assoc($result);
$comando="Select * from unidadtributaria where ((now() >= fechainicio) and now()<= fechafinal)";
$res2 = $con->consulta($comando);
// echo $comando;
if ($con->num_rows($res2) < 0)
	$valorut = 0;
$valorut = $con->fetch_assoc($res2);
$valorut = $valorut['montout'];

$SubTotal = 0;
if ($datos['valorfijo'] == 1)
{
	$subtotal = $valorut * $datos['ut'];
	
}
else if ($datos['valorfijo'] == 2)
{
	$subtotal = $valorut * $datos['porcentajeaplicado'];
}

/*
if ((strlen(trim($datos['DescripcionMedida'])))==0)
	$DescripcionMedida=' ';
else $DescripcionMedida=$datos['DescripcionMedida'];
*/
$descripcionmedida=(((strlen(trim($datos['descripcionmedida'])))==0)?' ':$datos['descripcionmedida']);

	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
/*
	echo utf8_encode("<ut>".number_format($datos['cantidadut'],2,'.','')."</ut>");
	echo utf8_encode("<valorfijo>".(float)$datos['valorfijo']."</valorfijo>");
	echo utf8_encode("<funcionalidad>".(float)$datos['funcionalidad']."</funcionalidad>");
	echo utf8_encode("<descripcionmedida>".$descripcionmedida."</descripcionmedida>");
	echo utf8_encode("<porcentajeaplicado>".(float)$datos['porcentajeaplicado']."</porcentajeaplicado>");
	echo utf8_encode("<utminimo>".(float)$datos['utminimo']."</utminimo>");
	echo utf8_encode("<utmaximo>".(float)$datos['utmaximo']."</utmaximo>");
	echo utf8_encode("<valorfraccion>".(($datos['valorfraccion'],2,'.','')."</valorfraccion>");
//	echo utf8_encode("<articulo>".$datos['articulo']."</articulo>");
	echo utf8_encode("<subtotal>".(float)$subtotal."</subtotal>");
	echo utf8_encode("<valorut>".(float)$valorut."</valorut>");
*/

	echo utf8_encode("<ut>".(float)$datos['cantidadut']."</ut>");
	echo utf8_encode("<valorfijo>".(float)$datos['valorfijo']."</valorfijo>");
	echo utf8_encode("<funcionalidad>".(float)$datos['funcionalidad']."</funcionalidad>");
	echo utf8_encode("<descripcionmedida>".$descripcionmedida."</descripcionmedida>");
	echo utf8_encode("<porcentajeaplicado>".(float)$datos['porcentajeaplicado']."</porcentajeaplicado>");
	echo utf8_encode("<utminimo>".(float)$datos['utminimo']."</utminimo>");
	echo utf8_encode("<utmaximo>".(float)$datos['utmaximo']."</utmaximo>");
	echo utf8_encode("<valorfraccion>".(float)$datos['valorfraccion']."</valorfraccion>");
//	echo utf8_encode("<articulo>".$datos['articulo']."</articulo>");
	echo utf8_encode("<subtotal>".(float)$subtotal."</subtotal>");
	echo utf8_encode("<valorut>".(float)$valorut."</valorut>");

	echo "</resultados>";

// http://www.genbetadev.com/desarrollo-web/authy-anade-autenticacion-en-dos-pasos-facilmente-a-tus-aplicaciones
?>
