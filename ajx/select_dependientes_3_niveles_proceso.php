<?php
// include("head.php");
include_once '../dbconfig.php';
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
// "ciudad"=>"E",
"ente"=>"M",
"entes"=>"P"
// "tarifa"=>"T"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
//	echo 'la opcion '.$opcionSeleccionada. ' - '.$selectDestino;
	$tamano=strlen($opcionSeleccionada);
//	include 'conexion.php';
//	conectar();
	if ($selectDestino == 'ente')
	{
		$sql="select id_municipio as codigo, nombre_municipio as nombre from municipio where id_municipio= '$opcionSeleccionada' order by Nombre_Municipio";
		$sql="select * from ente order by NombreEnte";
//		echo $sql;
		$consulta=mysql_query($sql) or die(mysql_error());
	}
	else 
	if ($selectDestino == 'entes')
	{
		// $sql="select parroquia as codigo, nombre from parroquia where substr(parroquia,1,4)= '$opcionSeleccionada' order by nombre";
		$sql="select CodigoEntes as codigo, nombreEnte as nombre from entes where codigoente= '$opcionSeleccionada' order by nombreEnte";
		// echo $sql;
		$consulta=mysql_query($sql) or die(mysql_error());
	}
	else 
	if ($selectDestino == 'tarifa')
	{
		$sql="SELECT * FROM `tipos_pasaje` WHERE substr(codigo_ciudad,1,2) = '$estado'";
		$sql="select identificador_equipo as codigo, tipo_tarifa as nombre from tipos_pasaje where substr(codigo_ciudad,1,4)= substr('$opcionSeleccionada',1,4) order by nombre";
//		echo $sql;
		$consulta=mysql_query($sql) or die(mysql_error());
	}
		// mysql_query("SELECT id, opcion FROM ubicacion WHERE tipo='$opcionSeleccionada'") or die(mysql_error());
//	desconectar();
	
	// Comienzo a imprimir el select
	echo 'cuento '.$cuento;
	$cuento=($selectDestino=='ente'?'Ente':($selectDestino=='entes'?'Tributo':'Tarifa')) ;
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige ".$cuento."</option>";
	while($registro=mysql_fetch_assoc($consulta))
	{
// 	echo '<option value="'.trim($fila2['codigo']).'" '.(($elmunicipio==trim($fila2['codigo']))?' selected':'').'>'.$fila2['nombre'].'</option>';}
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[codigo]=htmlentities($registro[codigo]);
		// Imprimo las opciones del select
		echo "<option value='".$registro[codigo]."'>".$registro[codigo].'-'.$registro[nombre]."</option>";
	}			
	echo "</select>";
}
?>