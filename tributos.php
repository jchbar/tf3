<?php
// session_start();
include_once('classcrud.php');
$crud = new classcrud();
include_once('classtributos.php');
$tributo = new classtributos();
// unset($_SESSION['rif']);
// $_SESSION['rif']='V093773884';
/*
		$tributo->tabla = 'timbresfiscales';
		$tributo->id	= 'idregistro';
		$tributo->campos = array(
			array('campo'=>'idregistro','tipo'=>'NoMostrar','titulo'=>'idregistro','required'=>'required'),
			array('campo'=>'fechatimbre','tipo'=>'text','titulo'=>'Generado el','required'=>'required'),
			array('campo'=>'montobs','tipo'=>'text','titulo'=>'Monto Bs','required'=>'required'),
		array('campo'=>'montout','tipo'=>'text','titulo'=>'Cantidad UT','required'=>'required')
			);

*/

echo '<head>';
include('head.html');
echo '</head>';
echo '<body>';
include ('header.html'); 

echo '<div align="center" class="container-responsive">
    <section class="row">
    	<div class="col-xs-12 col-sm-8 col-md-10">';

echo "<form action='tributos.php' name='form1' id='form1' method='post'>";// onsubmit='return validar0(form1)'>"; // hidden-xs div class="col-xs-12 col-sm-8 col-md-6"> --> ;
if (isset($_POST['adquiRir']))
{
	$tributo->pedir_rif();
}
$tributo->normal();
if (isset($_POST['adquiRir']))
{
	echo '<button class="btn btn-success" value="Agregar" name="AgregarT">Agregar Tributo a la Lista</button>'; // onclick="return validar0(this);"
//	echo '<section class="row">';
		
	// $tributo->generarTablaTributos();
}
if ($_POST['AgregarT'])
{
	$tributo->agregar_tf();
}
echo "</form>";
if (isset($_POST['adquiRir']))
{
	// echo '<form id="tributosadq">';
	echo '<section class="row">
			<div id="mostrartributosadq" class="collapse-in">
			<div class="col-xs-12 col-sm-6 col-md-6 ">';
//	$tributo->generarTablaTributos('');
//	include_once('cargartributos.php');
	
// 	echo 'texto<br>	texto';
	echo '</div></div></section>';
	// echo '</form>';	
	
echo '</div></section></div>';

}
else 
{
		echo '<section class="row">
			<div class="col-xs-12 col-sm-6 col-md-10 ">';
	echo '<form action="index.php" method="POST">';
	echo '<button class="btn btn-danger" value="Regresar" name="Regresar">Regresar al Men&uacute;</button>'; 
	echo '</form></div></section>';

}

/*
$crud->tabla = 'timbresfiscales';
$crud->id	= 'idregistro';
$crud->campos = array(
	array('campo'=>'idregistro',
		'tipo'=>'NoMostrar',
		'titulo'=>'idregistro',
		'required'=>'required'),
	array('campo'=>'fechatimbre',
		'tipo'=>'text',
		'titulo'=>'Generado el',
		'required'=>'required'),
	array('campo'=>'montobs',
		'tipo'=>'text',
		'titulo'=>'Monto Bs',
		'required'=>'required'),
array('campo'=>'montout',
		'tipo'=>'text',
		'titulo'=>'Cantidad UT',
		'required'=>'required')
	);
		
if ((isset($_GET['method'])) && (isset($_GET['method'])!=''))
{
	echo 'metodo '.$_GET['method'];
	switch ($_GET['method'])
	{
		default:
			$crud->generarTabla();
			break;
		case agregar:
			$crud->agregarRegistro();
			break;
		case eliminar:
			$crud->eliminarRegistro();
			break;
		case modificar:
			echo 'voy';
			$crud->modificarRegistro();
			echo 'regreso';
		break;
	}
}
else
$crud->generarTabla();
*/
?>
