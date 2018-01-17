<?php
session_start();
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
include('head.html');
include_once('opciones.php');
?>
<script language="javascript">
function abrir2Ventanas()
{
window.open("rpt_ut_pdf.php","parte1","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");	// los primeros 500 socios	width=385,height=180,
// window.open("cuobanpdf2.php?fechadescuento="+fechadescuento,"parte2","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");
// "width=385,height=180,top=0,left=395,status,toolbar=1,scrollbar s,location");	// los demas
// window.open("cuobanpdf3.php?fechadescuento="+fechadescuento,"resumen","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");
//,"width=385,height=180,top=0,left=395,status,toolbar=1,scrollbar s,location");	// resumen de los montos
// window.open("cuobanpdf4.php?fechadescuento="+fechadescuento,"banco","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");
// "width=385,height=180,top=0,left=395,status,toolbar=1,scrollbar s,location");	// el listado a banco
// window.open("cuobanpdf5.php?fechadescuento="+fechadescuento,"amortiza","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");
// "width=385,height=180,top=0,left=395,status,toolbar=1,scrollbar s,location");	// amortizacion / capital
//window.open("cuobanpdf6.php?fechadescuento="+fechadescuento,"descargar","top=0,left=395,status=no,toolbar=no,scrollbar=yes,location=no,type=fullWindow,fullscreen");
// "width=385,height=180,top=0,left=395,status,toolbar=1,scrollbar s,location");	// amortizacion / capital
}
</script>
<?php
echo '<body>';
$ip = $_SERVER['HTTP_CLIENT_IP'];
if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
$accion=$_POST['accion'];
if (!$accion) {
	echo '<div class="container-fluid">';
	echo "<div class='col-xs-6'>";
	echo "<h3><strong> Reporte de Unidades Tributarias Sistema Administrativo </strong></h3>";
	echo "</div>";
	echo "<div id='div1'>";
	echo "<form action='' name='form1' method='post'>";
	echo '<input type="hidden" id="accion" name="accion" value="ListadoDeCuotas">';
	echo '<input type="submit" class="btn btn-primary" name="Submit" value="Realizar Listado" onClick="abrir2Ventanas()" />';
	echo '</form>';
	echo '</div>';
	echo '</div>';
}	// !$accion
else
{
	echo '<div class="container-fluid">';
	echo "<div class='col-xs-6'>";
	echo "<h3><strong> El Reporte de  Unidades Tributarias del Sistema Administrativo se est&aacute; generando en nueva ventana independiente</strong></h3>";
	echo "</div>";
	echo "<div id='div1'>";
	echo '</div>';
	echo '</div>';
}
/*
if (($accion=='ListadoDeCuotas') and ($nominasnormales == 'on')) {
	echo 'La fecha del día de hoy es: '. date("d/m/Y"). ' La hora local del servidor es: '. date("G:i:s").'<br>'; 
	$fechadescuento=convertir_fecha($_POST['fechadelpago']);		// revisar que no hayan nominas con esa fecha
	$sql="delete from sgcanopr where fecha = '$fechadescuento' ";
	$resultado=mysql_query($sql);
	$sql_amor="delete from sgcaamor where ('$fechadescuento' = fecha)"; //  limit 30"; //  limit 20";
	$resultado=mysql_query($sql_amor);
//	echo $sql;
	$sql="select count(fecha) as cuantos, ip from sgcanopr where fecha = '$fechadescuento' group by fecha";
	$resultado=mysql_query($sql);
	if (mysql_num_rows($resultado)>0) {
		$registro=mysql_fetch_assoc($resultado);
		echo '<h2>No se puede procesar esta nomina existe una ya realizada con '.$registro['cuantos'].' registro generada desde la IP '.$registro['ip'].'</h2>';
		exit;
	}
	// verificar codigos contra cedulas 
	$sql="select cod_prof, ced_prof from sgcaf200 where ced_prof='V-03855577' order by cod_prof";
	$sql="select cod_prof, ced_prof from sgcaf200 order by cod_prof";
	$a_200=mysql_query($sql);
	$registros=mysql_num_rows($a_200);
	$ValorTotal=$registros;
	if ($registros < 30)
		$registros = 30;
	$todobien=true;
	$cuantos=0;
	echo '
	 <div class="ProgressBar">
      <div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
      <div id="getProgressBarFill"></div>
    </div>';
	set_time_limit($registros);
//	echo $registros;
	while ($r200 = mysql_fetch_assoc($a_200))
	{
		$cobuscar=$r200['cod_prof'];
		$cebuscar=$r200['ced_prof'];
		$sql2="select codsoc_sdp, cedsoc_sdp, nropre_sdp from sgcaf310 where codsoc_sdp='$cobuscar'";

//		echo $sql2.'<br>';
		$a_310=mysql_query($sql2);
		while ($r310 = mysql_fetch_assoc($a_310))
		{


//			echo $cebuscar .' / '.$r310['cedsoc_sdp'].'<br>';
//			$estacedula=substr($r310['cedsoc_sdp'],0,4).substr($r310['cedsoc_sdp'],4,3).substr($r310['cedsoc_sdp'],7,3);
			$estacedula=substr($cebuscar,0,4).'.'.substr($cebuscar,4,3).'.'.substr($cebuscar,7,3);
//			die($estacedula);
// echo $estacedula. ' '.$r310['cedsoc_sdp'].'<br>';
			if ($estacedula != $r310['cedsoc_sdp'])
			{
				echo $cobuscar. ' - '.$estacedula. ' - '.$r310['cedsoc_sdp'].'<br>';
				$todobien=false;
			}
		}
	}
	echo "</div>";
	if (! $todobien)
		die ('<h2> Las siguiente informacion tiene problemas en prestamo, corregir');
	$fechaarchivo=explode('-',$fechadescuento);
	$fechaarchivo=$fechaarchivo[0].$fechaarchivo[1].$fechaarchivo[2];
	$nombre_archivo = 'nompre/'.$fechaarchivo.'domiciliacion.txt';
	$contenido = $nombre;
	fopen($nombre_archivo, 'w');

	// Asegurarse primero de que el archivo existe y puede escribirse sobre el.
	$registros=mysql_num_rows($a_200);
	if ($registros < 30)
		$registros = 30;
	set_time_limit($registros);
	if (is_writable($nombre_archivo)) {

		// En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adicion.
		// El apuntador de archivo se encuentra al final del archivo, asi que
		// alli es donde ira $contenido cuando llamemos fwrite().
		if (!$gestor = fopen($nombre_archivo, 'a')) {
			echo "<h2>No se puede abrir el archivo ($nombre_archivo) revise permisologia</h2>";
			exit;
		}
		else {

			echo "<div id='div1'>";
			echo "<form action='cuoban.php?accion=Abonar' name='form1' method='post' onsubmit='return realizo_abono(form1)'>";
			echo '<input type="hidden" name="nombre_archivo" value = "'.$nombre_archivo.'"/>';
			echo '<input type="hidden" name="nominasnormales" value = "on"/>';
			$fechadescuento=$_POST['fechadelpago'];
			echo '<fieldset><legend>Recopilando información Para Descuentos de Prestamos al '.$fechadescuento.'</legend>';
			echo '<h2>Preparando información...</h2>';
			$fechadescuento=convertir_fecha($fechadescuento);
			$sql_360="select * from sgcaf360 where (dcto_sem) order by cod_pres";
			$a_360=mysql_query($sql_360);
			$sql_200="select cod_prof, ced_prof, concat(ape_prof, ' ', nombr_prof) as nombre, ctan_prof from sgcaf200 where (ucase(statu_prof) != 'RETIRA') and (tipo_socio='P') and (ced_prof='V-03855577' or ced_prof='V-16770549'  or ced_prof='V-17572385') order by ced_prof";
			$sql_200="select cod_prof, ced_prof, concat(ape_prof, ' ', nombr_prof) as nombre, ctan_prof from sgcaf200 where (ucase(statu_prof) != 'RETIRA') and (tipo_socio='P') order by ced_prof";
			$a_200=mysql_query($sql_200);
			$registros = mysql_num_rows($a_200);
			$ValorTotal=$registros;
			$cuantos=0;
			while ($r200 = mysql_fetch_assoc($a_200))
			{
				$cedula=$r200['ced_prof'];
				$micedula=substr($cedula,0,4).'.'.substr($cedula,4,3).'.'.substr($cedula,7,4);
				
		$cuantos++;
		$porcentaje = $cuantos * 100 / $ValorTotal; //saco mi valor en porcentaje
		echo "<script>callprogress(".round($porcentaje).")</script>"; //llamo a la función JS(JavaScript) para actualizar el progreso
		flush(); //con esta funcion hago que se muestre el resultado de inmediato y no espere a terminar todo el bucle con los 25 registros para recien mostrar el resultado
		ob_flush();


				// original sin sp_
				$sql_310="select * from sgcaf310 where (stapre_sdp='A') and (cedsoc_sdp='$micedula') and (f_1cuo_sdp <= '$fechadescuento') order by codpre_sdp";
				$a_310=mysql_query($sql_310);
//				echo $sql_310.'<br>';
				// fin original sin sp_

				revisar_prestamo($r200,$a_310,$a_360,$fechadescuento,$micedula,$ip,$gestor);
			} // ($r200 = mysql_fetch_assoc($a_200))
			echo '<input type="hidden" name="fechadescuento" value="'.$fechadescuento.'">';
			echo '<h2>Información Lista...</h2><br>';
			echo '<h2>Se ha generado el archivo '.$nombre_archivo.'<br> para su procesamiento a banco</h2>';
			echo '<input type="submit" name="Submit" value="Impresión de Listados" onClick="abrir2Ventanas(';
			echo "'";
			echo $fechadescuento;
			echo "'";
//			echo "'".'&downloadfile='.$nombre_archivo.'&';
			echo ');">  ';
//			echo '<input type="submit" name="Submit" value="Realizar Abono " />';
			echo '</legend>';
			echo '</form>';
			echo '</div>';	
		}
		fclose($gestor);
	}
	else {
		echo "<h2>No se puede crear el archivo ($nombre_archivo) revise permisologia</h2>";
		exit;
	}
	echo 'La fecha final de hoy es: '. date("d/m/Y"). ' La hora local del servidor es: '. date("G:i:s").'<br>'; 
	set_time_limit(30);
}	// ($accion=='ListadoDeCuotas')
if (($accion=='Abonar')) { // and ($nominasnormales == 'on')) {
// if ($nominasnormales == 'on') {
	$fechadescuento=$_POST['fechadescuento'];
	$nombre_archivo=$_POST['nombre_archivo'];
//	echo '<input type="hidden" name="nombre_archivo" value = "'.$nombre_archivo.'"/>';
	echo "<div id='div1'>";
	
	echo '<h2>Puede proceder luego de la impresion de los listados a <br>realizar el abono a prestamos y el asiento contable y';
	echo '<br>recuerde obtener descargar el archivo </h2><h1>'.$nombre_archivo.'</h1><h2> para enviar al banco</h2>';
//	echo "<form action='bajpre.php' name='form1' method='post'>";
//	echo '<input type="submit" name="Submit" value="Descargar Archivo TXT"';
//	echo '</form>';
	/// hacer el asiento ver asiento original con intereses y demas
//	echo '<a href="" onClick="abrir2Ventanas();">KK</a>';
//	echo "<a target=\"_blank\" href=\"cuobanpdf1.php?fechadescuento=$fechadescuento\" onClick=\"info.html\', \'\',\'width=250, height=190\')\">Imprimir Listados de Descuentos</a>"; 	

	echo "<form action='cuoban.php?accion=Asiento' name='form1' method='post' onsubmit='return realiza_asiento_montepio(form1)'>";
	$fechadescuento=$_POST['fechadescuento'];
	echo '<input type="hidden" name="fechadescuento" value = "'.$fechadescuento.'">';
	echo '<input type="hidden" name="nombre_archivo" value = "'.$nombre_archivo.'"/>';
	echo '<input type="submit" name="procesar" value="Generar Asiento Contable" />';
	echo '</form>';
	echo '</div>';
}	// ($accion=='ImpresionListados') 
if (($accion=='Asiento')) { 
/////
	$fechadescuento=$_POST['fechadescuento'];
	$sql_360="select * from sgcaf360 where (dcto_sem) order by cod_pres"; //  limit 30"; //  limit 20";
	$a_360=mysql_query($sql_360);
	$columna=3;
	$rpl=300; 	// registros por listado
	$crl=0;		// contador de registros por listado
	$col_listado=0;
	$nuevoarchivo=false;
	$condicion_sql='select codigo, cedula, nombre, nrocta, ';
	$col_listado=0;
	$max_cols=mysql_num_rows($a_360);
	echo 'Realizando Calculo<br>';
	while ($r360 = mysql_fetch_assoc($a_360))
	{
		$col_listado++;
		$columna++;
		if (trim($r360['desc_cor'])!='') ;// $header[$columna]=$r360['desc_cor'] ;
		else ; // $header[$columna]=substr($r360['descr_pres'],0,12);
		$totales[$col_listado]=0;
		$campo='colpre'.$col_listado;
		$condicion_sql.=' colpre'.$col_listado;
		if ($col_listado != $max_cols) 
		{
			$arrtitulo.=', ';
			$condicion_sql.=', ';
		}
	}
	$sql_nopr=$condicion_sql." from sgcanopr where ('$fechadescuento' = fecha) order by nombre "; //  limit 20";
	$a_nopr=mysql_query($sql_nopr);
	$registros=mysql_num_rows($a_nopr);
	set_time_limit($registros);
	$lascolumnas=mysql_num_fields($a_nopr)-4;
	while ($r_nopr = mysql_fetch_assoc($a_nopr)){
		$t1=0;
		for ($prestamos=1;$prestamos<=$lascolumnas;$prestamos++) {		// sumatoria de los prestamos
			$item='colpre'.$prestamos;
			$t1+=$r_nopr[$item];
			$totales[$prestamos]+=$r_nopr[$item];
		}
	}
	$general=0;
	for ($i=1;$i<count($totales);$i++)
		if ($totales[$i]!=0) {
			$general+=$totales[$i];
	}
	set_time_limit(30);

	$b=$fechadescuento;
	$b2 = date("Y-m-d");
	$c=explode('-',$b2);
	$asiento=$c[0].$c[1].$c[2].'001';
	echo "Generado Asiento Contable <strong><a target=\"_blank\" href='editasi2.php?asiento=$asiento'>$asiento </a></strong> <br>";
	$cuento='Nomina por cobrar al Banco de fecha '.convertir_fechadmy($b);
	$sql = "INSERT INTO sgcaf830 (enc_clave, enc_fecha, enc_desco, enc_desc1, enc_debe, enc_haber, enc_item, enc_dif, enc_igual, enc_refer, enc_sw, enc_explic) VALUES ('$asiento', '$b', '$cuento','',0,0,0,0,0,0,0,'$cuento')"; 
	if (!mysql_query($sql)) die ("El usuario $usuario no tiene permiso para añadir Asientos.<br>".$sql);

	$sql="select * from sgcaf000 where tipo='CtaPrexCobAmo'";
	$result=mysql_query($sql); 
	$cuentas=mysql_fetch_assoc($result);
	$cuenta_amortizacion=trim($cuentas['nombre']);
	$sql="select * from sgcaf000 where tipo='CtaPrexCobBco'";
	$result=mysql_query($sql); 
	$cuentas=mysql_fetch_assoc($result);
	$cuentabanco=trim($cuentas['nombre']);			
	$referencia='';
	$debe=$general;
	agregar_f820($asiento, $b2, '+', $cuentabanco, 'Amort. Prest. p/cobrar banco al '.convertir_fechadmy($b), $debe, $haber, 0,$ip,0,$referencia,'','S',0); 
	agregar_f820($asiento, $b2, '-', $cuenta_amortizacion, 'Total Retenciones del '.convertir_fechadmy($b), $debe, $haber, 0,$ip,0,$referencia,'','S',0); 	

	$nombre_archivo=$_POST['nombre_archivo'];
	echo '<form action="depositotxt.php" method="post" name="form1" enctype="multipart/form-data">';
	echo '<input type="hidden" name="archivo" value = "'.$nombre_archivo.'">';
	echo '<input type="submit" name="procesar" value="Descargar Archivo '.$nombre_archivo.'" />';
	echo '</form>';
	
	$comando = "update sgcaf8co set fechanominamiercoles= now()";
	$resultado=mysql_query($comando);
	

/////
}

*/
?>

</body></html>

