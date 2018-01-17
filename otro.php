<?php
include_once('ClassCrud.php');
$crud = new ClassCrud();
echo $crud->header;
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
?>
