<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
//echo 'estoy en buscar tributos';
extract($_POST);
/*
if ($_POST['consulTar']) echo 'pidio consulta';
else if ($_POST['adquiRir']) echo 'pidio comprar';
else if (($_POST['quieRoser'])) echo 'preguntar';
*/
?>

<head>
<?php include('head.html'); ?>

script language="Javascript" src="validaciones.js" type='text/javascript'></script>
<script type="text/javascript" src="ajx/select_dependientes_3_niveles.js"></script>
<script src="ajx/rifjson.js" type="text/javascript"></script>
</head>
<body>

<?php
include_once 'dbconfig.php';
include ('header.html'); 
echo 'falta revisar si esta en mantenimiento';

// echo '        	    <button class="btn btn-primary" value="consulTar" name="consulTar" >Consultar Tributo</button>';
echo '<div class="container-fluid">';
echo '<div class="col-xs-12 col-sm-8 col-md-9">';
echo '<div class="signin-form">';
echo '<div class="container">';
?>
<header>
	<div class="container">
<?php
	echo '<div class="hidden-xs col-xs-12 col-sm-8 col-md-6">'; // hidden-sm 
	echo '<h1>';
	if ($_POST['consulTar']) echo 'pidio consulta';
		else if ($_POST['adquiRir']) echo 'pidio comprar';
		else if (($_POST['quieRoser'])) echo 'preguntar';
	echo '</h1>';
?>
   </div>
</header>
<?php

echo "<form action='buscartributos.php' name='form1' id='form1' method='post'>"; //  onSubmit='return validadatos(form1)'>";
	echo "<table class = 'table table-hover'>";
	if ($_POST['adquiRir']) 
	{
		echo '<tr><td>Nacionalidad/<br>Cedula/Factor</td>';
		echo '<td>';
		$comando="select * from configuracion where NombreParametro = 'Nacionalidad' order by ValorParametro" ;
		$res=mysql_query($comando);
		echo '<select name="nacionalidad" id="nacionalidad" size="1">';
		while ($fila = mysql_fetch_assoc($res)) {
			echo '<option value="'.$fila['ValorParametro'].'" >'.$fila['ValorParametro'].' </option>'; 
		}
		echo '</select> <br>'; 
		echo '<input align="right" name="numero" type="text" id="numero" size="8" maxlength="8" value ="" onChange="validarSiNumero(this.value);"  title="Se necesita el numero de cedula" required>-';
		echo '<select name="digito" id="digito" size="1" onblur="ajax_call_rif()">';
		echo '<option value="0" selected >0 </option>'; 
		for ($elfactor=1; $elfactor < 10; $elfactor++)
			echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
		echo '</select>*'; 
		echo '</td></tr>';
		echo '<tr><td>';
		echo '<td>Nombre/Raz&oacute;n Social</td>';
		echo '<td><input align="right" name="razon" type="text" id="razon" size="30" maxlength="100" value ="" onChange="validarNom_Ape(this.value);" title="Se necesita un nombre" required onfocus="refrescar_select();"></td>';
		echo '</td></tr>';
	}
	// echo '<input type="hidden"  name="ente" id="ente" value="" size="3"></td>';
	echo '<div id="demo" style="width:100px;"><th>Ente </th><td><div id="demoMed">';
	$estado='11';
	$sql="select * from ente order by NombreEnte";

	echo '<select name="ente" id="ente" size="1" onChange="cargaContenido(this.id)">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['CodigoEnte'].'">'.$fila2['NombreEnte'].'</option>'; 		
}
	echo '</select> *'; 

	echo '</td>';

	$sql="select * from entes where estado= '$estado' order by nombre";
	echo '<div id="demo" style="width:100px;"><td>Tributo</td><td> ';
	echo '<select name="entes" id="entes" size="1">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['parroquia'].'">'.$fila2['parroquia'].'-'.$fila2['nombre'].'</option>'; }
	echo '</select> *'; 
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Sector</td>';
	echo '<td><input align="right" name="sector" type="text" id="sector" size="20" maxlength="30" value ="" title="Debe indicar el sector" required></td>';
	$sql="SELECT * FROM `tipos_pasaje` WHERE substr(codigo_ciudad,1,2) = '$estado'";
	echo '<td>Identificador de Tarifa </td><td> ';
	echo '<input align="right" name="tarifa" type="text" id="tarifa" size="2" maxlength="2" value ="" title="Debe indicar la tarifa" disabled=true required></td>';
/*
	echo '<select name="tarifa" id="tarifa" size="1">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['identificador_equipo'].'">'.$fila2['identificador_equipo'].'-'.$fila2['tipo_tarifa'].'</option>'; }
	echo '</select> *'; 
*/
	echo '</td>';

	echo '</tr>';


echo '</table>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
die('ddd');
{
	echo '<tr><td>Telefono</td>';
	echo '<td><input align="right" name="telefono" type="text" id="telefono" size="20" maxlength="30" value =""></td>';
	echo '<td>Fecha Censo</td>';
	echo '<td><input align="right" name="censado" type="text" id="censado" size="20" maxlength="30" value =""></td>';
	echo '<td>Tipo Usuario</td>';
	echo '<td>';

	$sql="select * from usuario_configuracion where CodTip = 'Preferente' order by CodTip";
	$resultado=mysql_query($sql);
	$contador=0;
//	echo '<select name="tipo" size="1" onChange="deshabilitar()">';
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<input align="right" name="tipo" type="radio" id="'.$fila2['NomTip'].'" size="8" maxlength="8" value ="'.$fila2['NomTip'].'" onClick="deshabilitacampos()" >'.$fila2['NomTip'].'<br>';
		$contador++;
	}
	echo '</select> *'; 
	echo '</td></tr>';
	
	echo '<tr>';
	echo '<td>Nivel Estudio</td>';
	echo '<td>';
	echo '<select name="nivel" id="nivel" size="1">';
	$sql="select * from usuario_configuracion where CodTip = 'Nivel' order by CodTip";
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['NomTip'].'">'.$fila2['NomTip'].'</option>'; }
	echo '</select> *'; 
	echo '</td>';

	echo '<td>Institucion</td>';
	echo '<td>';
	echo "<input type='text' name='inputString' size='10' maxlength='20' id='inputString' onKeyUp='lookup_plantel(this.value);' onBlur='fill_plantel();' autocomplete='off' value=''>";
	
	echo '<div class="suggestionsBox" id="suggestions" style="display: none;">';
	echo '<img src="upArrow.png" style="position: relative; top: -12px; left: 70px; "  alt="upArrow" />';
	echo '<div class="suggestionList" id="autoSuggestionsList">';
	echo '</div>';

	echo '</td>';
	
	echo '<td>Nro. Carnet Discapacitado</td>';
	echo '<td><input align="right" name="carnet="text" id="carnet" size="20" maxlength="30" value =""></td>';
	echo '</td></tr>';

	echo '<tr><td align="center" colspan="2">';
	echo "<input type = 'submit' name='ingresar' id='ingresar' value = 'Ingresar'>";
	echo "<form action='regusu.php?accion=Anadir1' name='form1' id='form1' method='post'  onSubmit='return borrar_usuario()'>";
		echo "<input type = 'submit' name='eliminar' id='eliminar' value = 'Eliminar' disabled='true'>";
	echo '</form>';
	echo "<form action='regusu.php?accion=Anadir1' name='form1' id='form1' method='post'>";
		echo "<input type = 'submit' name='regresar' id='regresar' value = 'Regresar' >";
	echo '</form>';
	echo '</td></tr>';
	echo "</form>\n";
















/*
	$plantel=$inputString;
	$plantel="select codigo_plantel from planteles where nombre_plantel='$plantel'";
	$rc=mysql_query($plantel);
	$plantel=mysql_fetch_assoc($rc);
	$plantel=$plantel['codigo_plantel'];
	
	
	if ($ingresar=='Ingresar'){
		$sql1="INSERT INTO usuarios_preferenciales (cedula, nombres, apellidos, fecha_nacimiento, sexo, codigo_ciudad, telefono, tipo_preferencial, codigo_alianza, codigo_institucion_estudiante, nivel_estudios_estudiante, numero_carnet_discapacitado, estatus, identificador_tarifa, serial_medio_pago, proxima_actualizacion) VALUES ('$cedulafactor', '$nombre', '$apellido', '$nace', '$sexo', '$ciudad', '$telefono', '$tipo_preferencial', '$codigo_alianza', '$plantel', '$nivel', '$numero_carnet_discapacitado', '$estatus', '$tarifa', ' ', '$proxima')" ;
		$sql2="INSERT INTO usr_prf (cedulafactor, cedula, factor, nombres, apellidos, fecha_nacimiento, sexo, codigo_ciudad, telefono, 	tipo_preferencial, codigo_alianza, codigo_institucion_estudiante, nivel_estudios_estudiante, numero_carnet_discapacitado, estatus, identificador_tarifa, fecha_registro, municipio, parroquia, sector, censado, serial_medio_pago, proxima_actualizacion) VALUES ('$cedulafactor', '$cedula', '$factor', '$nombre', '$apellido	', '$nace', '$sexo', '$ciudad', '$telefono', '$tipo_preferencial', '$codigo_alianza', '$plantel', '$nivel', '$numero_carnet_discapacitado', '$estatus', '$tarifa', '$registro', '$municipio', '$parroquia', '$sector', '$censado', ' ', '$proxima')" ;
	}
	if ($ingresar=='Modificar'){
		$sql1="UPDATE usuarios_preferenciales set nombres='$nombre', apellidos='$apellido', fecha_nacimiento='$nace', sexo='$sexo', codigo_ciudad='$ciudad', telefono='$telefono', tipo_preferencial='$tipo_preferencial', codigo_alianza='$codigo_alianza', codigo_institucion_estudiante='$plantel', nivel_estudios_estudiante='$nivel', numero_carnet_discapacitado='$numero_carnet_discapacitado', estatus='$estatus', identificador_tarifa='$tarifa', proxima_actualizacion='$proxima' WHERE cedula='$cedulafactor'" ;
		$sql2="UPDATE usr_prf SET cedula='$cedula', factor='$factor', nombres='$nombre', apellidos='$apellido', fecha_nacimiento='$nace', sexo='$sexo', codigo_ciudad='$ciudad', telefono='$telefono', tipo_preferencial='$tipo_preferencial', codigo_alianza='$codigo_alianza', codigo_institucion_estudiante='$plantel', nivel_estudios_estudiante='$nivel', numero_carnet_discapacitado='$numero_carnet_discapacitado', estatus='$estatus', identificador_tarifa='$tarifa', fecha_registro='$registro', municipio='$municipio', parroquia='$parroquia', sector='$sector', censado='$censado',  proxima_actualizacion='$proxima' WHERE cedulafactor='$cedulafactor'" ;
	}
	if ($eliminar=='Eliminar'){
		$sql1="delete from usuarios_preferenciales  where cedula='$cedulafactor'";
		$sql2="delete from usr_prf where cedulafactor='$cedulafactor'";
	}

//	echo 'sql 1'.$sql1.'<br>';
//	echo 'sql 2'.$sql2;
	if ($ingresar=='Ingresar'){
		if (! mysql_query($sql1)) 
			die ("<p />El usuario $usuario no tiene permisos para añadir usuarios o cedula-factor ya existente.");
		else {
			echo 'Usuario agregado(a) satisfactoriamente...<br>';
			if (! mysql_query($sql2)) 
				die ("<p />El usuario $usuario no tiene permisos para añadir usuarios o cedula-factor ya existente.");
			else echo 'Usuario agregado satisfactoriamente...<br>';
			}
	}
	if ($ingresar=='Modificar'){
		if (! mysql_query($sql1)) 
			die ("<p />El usuario $usuario no tiene permisos para modificar usuarios o cedula-factor NO existente.");
		else {
			echo 'Usuario modificado(a) satisfactoriamente...<br>';
			if (! mysql_query($sql2)) 
				die ("<p />El usuario $usuario no tiene permisos para modificar usuarios o cedula-factor NO existente.");
			else echo 'Usuario agregado satisfactoriamente...<br>';
			}
	}
	if ($eliminar=='Eliminar'){
		if (! mysql_query($sql1)) 
			die ("<p />El usuario $usuario no tiene permisos para eliminar usuarios o cedula-factor NO existente.");
		else {
			echo 'Usuario agregado(a) satisfactoriamente...<br>';
			if (! mysql_query($sql2)) 
				die ("<p />El usuario $usuario no tiene permisos para eliminar usuarios o cedula-factor NO existente.");
			else echo 'Usuario agregado satisfactoriamente...<br>';
			}
	}
*/
	$accion="";
}	// accion

if (!$accion)
{
?>

<table class='basica 100 hover' width='100%'>
<tr><th>Cedula</th><th>Nombre(s)<br />[ <a href='regusu.php?accion=Anadir'>Actualizar Usuario</a> ]</th><th>Apellido(s)<br />[ <a href='regusu.php?accion=Anadir'>Actualizar Usuario</a> ]</th><th>Fecha <br>Nacimiento</th><th>Proxima <br>Actualizacion</th><th>Edad</th><th>Sexo</th><th>Tipo de Usuario</th><th>Parroquia</th><th>Sector</th><th>Telefono</th><th>Fecha Registro</th></tr>
<?php
$ord=' order by proxima_actualizacion';
$conta = $_GET['conta'];
if (!$_GET['conta']) {
	$conta = 1;
}

$sql = "SELECT COUNT(cedula) AS cuantos FROM usuarios_preferenciales ";
$rs = mysql_query($sql);
$row= mysql_fetch_array($rs);
$numasi = $row[cuantos]; 

// $sql = "SELECT * FROM usuarios_preferenciales, usr_prf where usuarios_preferenciales.cedula=usr_prf.cedula and usuarios_preferenciales.factor=usr_prf.factor ORDER BY cedula DESC";
$sql = "SELECT * FROM usr_prf ORDER BY proxima_actualizacion, cedula ";


$rs = mysql_query($sql." LIMIT ".($conta-1).", 20");

if (pagina($numasi, $conta, 20, "Usuarios Preferenciales", $ord)) {$fin = 1;}


// bucle de listado

while($row=mysql_fetch_array($rs)) {
	echo "<tr>";
	echo '<td align="center">';
/*
	echo "<img src='imagenes/16-em-cross.png' width='16' height='16' border='0' />"; 
	echo "<a href='regusu.php?accion=Editar&codigo=".$row['idcas']."'>";
	echo $row['cedula']."</a>";
*/	echo $row['cedula']."</td>";
	echo "<td align='center'>".$row['nombres']."</td>";
	echo "<td align='center'>".$row['apellidos']."</td>";
	echo "<td align='center'>".convertir_fechadmy($row['fecha_nacimiento'])."</td>";
	echo "<td align='center'>".convertir_fechadmy($row['proxima_actualizacion'])."</td>";
	$sqledad="select TIMESTAMPDIFF(YEAR,'".$row['fecha_nacimiento']."',NOW()) as edad";
	$res=mysql_query($sqledad);
	$redad=mysql_fetch_assoc($res);
	echo "<td align='center'>".$redad['edad']."</td>";	// calcular
	echo "<td align='center'>".$row['sexo']."</td>";
/*
	$sm="select * from municipio where id_municipio = '".$row['municipio']."'";
	$rm=mysql_query($sm);
	$elmunicipio=mysql_fetch_assoc($rm);
	$elmunicipio=$elmunicipio['Nombre_Municipio'];
	echo "<td>".$elmunicipio."</td>";
*/
    if (trim(strtoupper($row['tipo_preferencial']))=='ANCIANO')
		echo "<td>TERCERA EDAD</td>";
    else echo "<td>".$row['tipo_preferencial']."</td>";

	$sm="select * from parroquia where parroquia = '".$row['parroquia']."'";
	$rm=mysql_query($sm);
	$elmunicipio=mysql_fetch_assoc($rm);
	$elmunicipio=$elmunicipio['nombre'];
	echo "<td align='center'>".$elmunicipio."</td>";
	echo "<td align='center'>".$row['sector']."</td>";
	echo "<td align='center'>".$row['telefono']."</td>";
	echo "<td align='center'>".$row['censado']."</td>";
	echo "</tr>";

}

echo "</table>";

pagina($numasi, $conta, 20, "Usuarios Preferenciales", $ord);
}
?>

</div><div id='div2' class="div2">

<?php

if ($accion == "Anadir") {
/* readonly='readonly' */
	echo "<form action='regusu.php?accion=Anadir1' name='form1' id='form1' method='post'  onSubmit='return validadatos(form1)'>";
	// enctype='multipart/form-data'
//	echo "<label>Código de Juzgado</label><br /><input type = 'text' size='40' maxlength='40' name='codigo'><br />";

	echo '<table width=\'100%\'>';
	echo '<tr><td>Nacionalidad/<br>Cedula/Factor</td>';
	echo '<td>';

	echo '<select name="nacionalidad" id="nacionalidad" size="1">';
	echo '<option value="V" selected >V </option>'; 
	echo '<option value="E">E </option>'; 
	echo '</select> <br>'; 

// 	echo '<input align="right" name="nacionalidad" type="text" id="nacionalidad" size="1" maxlength="1" value ="">-';
	echo '<input align="right" name="cedula" type="text" id="cedula" size="10" maxlength="10" value ="" onChange="validarSiNumero(this.value);"  title="Se necesita el numero de cedula" required>-';
//	echo '<input align="right" name="factor" type="text" id="factor" size="1" maxlength="1" value ="" onChange="validarSiNumero(this.value);">';
	echo '<select name="factor" id="factor" size="1" onblur="ajax_call_cedula()">';
	echo '<option value="0" selected >0 </option>'; 
	for ($elfactor=1; $elfactor < 10; $elfactor++)
		echo '<option value='.$elfactor.' >'.$elfactor.' </option>'; 
	echo '</select>*'; 
	
//	echo '<input type="button" name="calculo" value="Buscar" onClick="ajax_call_cedula()"></td>';
//	echo '<td class="ayuda"><img src="ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, \"Nombre\")"></td>';

	echo '<td>Nombre(s)</td>';
	echo '<td><input align="right" name="nombre" type="text" id="nombre" size="30" maxlength="100" value ="" onChange="validarNom_Ape(this.value);" title="Se necesita un nombre" required onfocus="refrescar_select();"></td>';

	echo '<td>Apellido(s)</td>';
	echo '<td><input align="right" name="apellido" type="text" id="apellido" size="30" maxlength="100" value ="" onChange="validarNom_Ape(this.value);" title="Se necesita un apellido" required></td>';
	echo '</tr>';

	$hoy=" SELECT substr( now( ) , 1, 10 ) AS hoy, substr(date_add(now(), INTERVAL 6 MONTH),1,10) AS proxima";
	$ahoy=mysql_query($hoy);
	$rhoy=mysql_fetch_assoc($ahoy);
	$hoy=explode('-',$rhoy['hoy']);
	$hoy=$hoy[2].'/'.$hoy[1].'/'.$hoy[0];

	echo '<tr>';
	echo '<td>Sexo</td>';
	echo '<td><input align="right" name="sexo" type="radio" id="Masculino" size="10" maxlength="10" value ="Masculino" >Masculino';	// onchange="deshabilitar()" 
	echo '<input align="right" name="sexo" type="radio" id="Femenino" size="10" maxlength="10" value ="Femenino" >Femenino</td>'; // onchange="deshabilitar()" 

	echo '<td>Fecha Nacimiento</td>';
	echo '<td><input align="right" name="nacimiento" type="text" id="nacimiento" size="10" maxlength="10" value ="" onChange="validarFormatoFecha(this.value);" onblur = "fechavalida(this.value);"  title="Debe indicar la fecha de nacimiento" required> <input type="hidden"  name="edad" id="edad" value="" size="3"></td>'; // 
	echo '<td>Fecha Censo</td>';
	echo "<input type = 'hidden' value ='".$rhoy['proxima']."' name='proxima' id='proxima'>";
	echo '<td><input align="right" name="registro" type="text" id="registro" size="10" maxlength="10" value ="'.$hoy.'" onChange="validarFormatoFecha(this.value);" readonly=true title="Debe indicar la fecha de registro" required></td>'; // onblur = "fechavalida(this.value)"; 
	echo '</tr>';
/*
	echo '<td>Ciudad</td><td><div id="demoIzq">';
	$estado='11';
	$sql="select codigo_ciudad as codigo, nombre_ciudad as nombre from ciudades where codigo_estado= '$estado' order by nombre_ciudad";

	echo '<div id="demo" style="width:150px;"><select name="ciudad" id="ciudad" size="1" onChange="cargaContenido(this.id)">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['codigo'].'">'.$fila2['codigo'].'-'.$fila2['nombre'].'</option>'; }
//		echo '<option value="'.$fila2['nombre_ciudad'].'">'.$fila2['nombre_ciudad'].'</option>'; }
	echo '</select> '; 
*/
	echo '<input type="hidden"  name="ciudad" id="ciudad" value="" size="3"></td>';
	echo '<div id="demo" style="width:100px;"><td>Municipio </td><td><div id="demoMed">';
	$estado='11';
	$sql="select * from municipio where id_estado= '$estado' order by Nombre_Municipio";

	echo '<select name="municipio" id="municipio" size="1" onChange="cargaContenido(this.id)">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['ID_MUNICIPIO'].'">'.$fila2['ID_MUNICIPIO'].'-'.$fila2['Nombre_Municipio'].'</option>'; 		
}
	echo '</select> *'; 

	echo '</td>';

	$sql="select * from parroquia where estado= '$estado' order by nombre";
	echo '<div id="demo" style="width:100px;"><td>Parroquia</td><td> ';
	echo '<select name="parroquia" id="parroquia" size="1">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['parroquia'].'">'.$fila2['parroquia'].'-'.$fila2['nombre'].'</option>'; }
	echo '</select> *'; 
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>Sector</td>';
	echo '<td><input align="right" name="sector" type="text" id="sector" size="20" maxlength="30" value ="" title="Debe indicar el sector" required></td>';
	$sql="SELECT * FROM `tipos_pasaje` WHERE substr(codigo_ciudad,1,2) = '$estado'";
	echo '<td>Identificador de Tarifa </td><td> ';
	echo '<input align="right" name="tarifa" type="text" id="tarifa" size="2" maxlength="2" value ="" title="Debe indicar la tarifa" disabled=true required></td>';
/*
	echo '<select name="tarifa" id="tarifa" size="1">';
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['identificador_equipo'].'">'.$fila2['identificador_equipo'].'-'.$fila2['tipo_tarifa'].'</option>'; }
	echo '</select> *'; 
*/
	echo '</td>';

	echo '</tr>';

	echo '<tr><td>Telefono</td>';
	echo '<td><input align="right" name="telefono" type="text" id="telefono" size="20" maxlength="30" value =""></td>';
	echo '<td>Fecha Censo</td>';
	echo '<td><input align="right" name="censado" type="text" id="censado" size="20" maxlength="30" value =""></td>';
	echo '<td>Tipo Usuario</td>';
	echo '<td>';

	$sql="select * from usuario_configuracion where CodTip = 'Preferente' order by CodTip";
	$resultado=mysql_query($sql);
	$contador=0;
//	echo '<select name="tipo" size="1" onChange="deshabilitar()">';
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<input align="right" name="tipo" type="radio" id="'.$fila2['NomTip'].'" size="8" maxlength="8" value ="'.$fila2['NomTip'].'" onClick="deshabilitacampos()" >'.$fila2['NomTip'].'<br>';
		$contador++;
	}
	echo '</select> *'; 
	echo '</td></tr>';
	
	echo '<tr>';
	echo '<td>Nivel Estudio</td>';
	echo '<td>';
	echo '<select name="nivel" id="nivel" size="1">';
	$sql="select * from usuario_configuracion where CodTip = 'Nivel' order by CodTip";
	$resultado=mysql_query($sql);
	while ($fila2 = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$fila2['NomTip'].'">'.$fila2['NomTip'].'</option>'; }
	echo '</select> *'; 
	echo '</td>';

	echo '<td>Institucion</td>';
	echo '<td>';
	echo "<input type='text' name='inputString' size='10' maxlength='20' id='inputString' onKeyUp='lookup_plantel(this.value);' onBlur='fill_plantel();' autocomplete='off' value=''>";
	
	echo '<div class="suggestionsBox" id="suggestions" style="display: none;">';
	echo '<img src="upArrow.png" style="position: relative; top: -12px; left: 70px; "  alt="upArrow" />';
	echo '<div class="suggestionList" id="autoSuggestionsList">';
	echo '</div>';

	echo '</td>';
	
	echo '<td>Nro. Carnet Discapacitado</td>';
	echo '<td><input align="right" name="carnet="text" id="carnet" size="20" maxlength="30" value =""></td>';
	echo '</td></tr>';

	echo '<tr><td align="center" colspan="2">';
	echo "<input type = 'submit' name='ingresar' id='ingresar' value = 'Ingresar'>";
	echo "<form action='regusu.php?accion=Anadir1' name='form1' id='form1' method='post'  onSubmit='return borrar_usuario()'>";
		echo "<input type = 'submit' name='eliminar' id='eliminar' value = 'Eliminar' disabled='true'>";
	echo '</form>';
	echo "<form action='regusu.php?accion=Anadir1' name='form1' id='form1' method='post'>";
		echo "<input type = 'submit' name='regresar' id='regresar' value = 'Regresar' >";
	echo '</form>';
	echo '</td></tr>';
	echo "</form>\n";

}

?>

</div>

<?php 
// include("pie.php");
//SELECT * FROM `usuarios_preferenciales` WHERE cedula = 'V-9377388-0'
?></body></html>


?>