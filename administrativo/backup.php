<?php

if (!is_dir("_backups")) {mkdir("_backups");}

deldir("_backups");

// $fich = $_SESSION['idempresa']."---".date('Y-m-d-His').".sql";
$fich = 'RespaldoDatos'."---".date('Y-m-d-His').".sql";

if( !@function_exists('gzopen')) {
	$gz = false;
	$f = fopen( "_backups/".$fich, 'w' );
}
else {
	$fich = $fich . ".gz";
	$gz = true;
	$f = gzopen( "_backups/".$fich, 'w6' );
}

// $db = mysql_select_db($_SESSION['empresa']);
//$db = mysql_select_db($bdd);
/*
include('classbasededatos.php');
*/
$con = new classbasededatos();

$escribir = "-- Base de datos: "." - Fecha: " . strftime( "%d/%m/%Y - %H:%M:%S", time() )."\n";
escribir($f, $gz, $escribir);

//$result = mysql_query( 'SHOW tables' );
$result = $con->consulta( 'SHOW tables' );
// while( $fila = mysql_fetch_array($result) ) {
while( $fila = mysql_fetch_array($result) ) {
	//if ($_SESSION['empresa'] == "nuevocat" AND $fila[0] == "referers") {continue;}
	if ($fila[0] == "referers") {continue;}
	if ($fila[0] != "configuracion")
	{
		escribetabla( $fila[0], $f, $gz, $con);
		escribir($f, $gz, "\n");
	}
}

if( !$gz ){ 
	fclose($f);
	} else {
	gzclose($f);
}
// $con->desconectar();

echo "<a href='_backups/$fich'>Descargar la copia de seguridad <span class='b'>$fich</span></a>";

function escribetabla($table, $f = 0, $gz, $con) {
	$escribir = "\n-- Tabla `$table`\n";
	escribir($f, $gz, "\n");
	escribir($f, $gz, $escribir);
//	$escribir = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table"));
	$escribir = mysql_fetch_assoc($con->consulta("SHOW CREATE TABLE $table"));
	quitar($escribir['Create Table']);
	$escribir = "DROP TABLE IF EXISTS $table;\n" . $escribir['Create Table'] . ";\n\n";
	escribir($f, $gz, $escribir);
	$escribir = "--\n";
	escribir($f, $gz, $escribir);
	$escribir = "-- Dumping `$table`\n";
	escribir($f, $gz, $escribir);
	$escribir = "--\n\n";
	escribir($f, $gz, $escribir);
	$escribir = "LOCK TABLES $table WRITE;\n";
	escribir($f, $gz, $escribir);

	// $result = mysql_query("SELECT * FROM $table where idempresa='".$_SESSION['idempresa']."'");
	$result = $con->consulta("SELECT * FROM $table");
	$campos=mysql_num_fields($result);
	while ($fila = mysql_fetch_array($result)) {
		$escribir = "INSERT INTO $table VALUES(";
		escribir($f, $gz, $escribir);
		$n = 0;
		while ($n < $campos) {
			$escribir = "";
			if ($n) {$escribir = ", ";}
			if( !isset($fila["$n"])) {$escribir .= 'NULL';} else {$escribir .= "'" . mysql_escape_string($fila["$n"]) . "'";}
			escribir($f, $gz, $escribir);
			$n = $n+1;
		}
		$escribir = ");\n";
		escribir($f, $gz, $escribir);
	}
	$escribir = "UNLOCK TABLES;";
	escribir($f, $gz, $escribir);
}

function quitar(&$text) {
	return $text;
}

function escribir($f, $gz, $escribir) {
	if( !$gz ){
		fwrite( $f, $escribir );
	} else {
		gzwrite( $f, $escribir );	
	}
}

function deldir($dir){
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir)){
		if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
			 deldir("${dir}/${entryname}");
			}elseif($entryname != "." and $entryname!=".."){
			unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
}

?>