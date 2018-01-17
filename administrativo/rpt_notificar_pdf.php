<?php
session_start();
 header('Content-type: application/pdf');
extract($_GET);
extract($_POST);
extract($_SESSION);
ini_set("memory_limit","30M");
session_start();
if(!isset($_SESSION['usuario_sistema']))
{
	header("Location: index.php");
}
define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/mysql_table.php');
include("fpdf/comunes.php");
include_once('classbasededatos.php');
$con = new classbasededatos();
$con->conectar();
$columna=3;
// echo $sql_360;
$rpl=250; 	// registros por listado
$crl=0;		// contador de registros por listado
$col_listado=0;
$nuevoarchivo=false;
$col_listado=0;
$header[0]='ID';
$header[1]='Nombre';
$header[2]='Nivel';
$columna=2;
$w[0]=30;
$w[1]=60;
$w[2]=30;

		$losusuarios = "SELECT * FROM configuracion where nombreparametro = 'NivelUsuario' and valorparametro != 'Operador'";
		$resultado = $con->consulta($losusuarios);
		$elegidos = '(status = 1) and ';
		while($row = $con->fetch_assoc($resultado)){
			$elegidos.= "(nivel = '".$row['valorparametro']."') or ";
		}
		$tamano = strlen($elegidos)-4;
		$elegidos= substr($elegidos,0,$tamano);
		
		$estatus_pendiente=1;
		//consulta principal para recuperar los datos
		$paginas="select * FROM ingreso_usuario where (".$elegidos.") order by nombre ";


// $res=$con->consulta($paginas);

$comando="select * from configuracion where nombreparametro = 'Notificables' order by valorparametro" ;
$res=$con->consulta($comando);
while ($fila = $con->fetch_assoc($res)) {
			$columna++;
			$header[$columna]=$fila['valorparametro'];
			$w[$columna]=20;
}

$alto=4;
$salto=$alto;
$p[0]=10;
for ($posicion=1;$posicion<=count($w);$posicion++) 
	$p[$posicion]=$p[$posicion-1]+$w[$posicion-1];
//$p=array(10,18,31,36,76,91,106,131,136,161,196,221,246);
// echo 'ancho '.count($w);

$pdf=new PDF('L','mm','Letter');
$pdf->Open();
$linea=encabeza_l_ut($header,$w,$p,$pdf,$salto,$alto, $con);
$sql_360=$paginas;
// echo $paginas;
$a_360=$con->consulta($sql_360);
$registros=$con->num_rows($a_360);
set_time_limit($registros);
while ($r_nopr = $con->fetch_assoc($a_360)){
	$pdf->SetY($linea);
	$linea+=$alto;
	$pdf->SetX($p[0]);
	$pdf->Cell($w[0],$alto,substr($r_nopr["codigousuario"],-8),0,0,'LRTB',0);
	$pdf->SetX($p[1]);
	$pdf->Cell($w[1],$alto,$r_nopr["nombre"],0,0,'LRTB',0); 
	$pdf->SetX($p[2]);
	$pdf->Cell($w[2],$alto,$r_nopr["nivel"],0,0,'LRTB',0);  

	$comando = "select * from notificacion, configuracion where codigousuario = '".$r_nopr['codigousuario']."' and (notificacion=configuracion.idregistro) order by valorparametro";
	$res=$con->consulta($comando);
	echo $comando;
	$columna = 2;
	while ($fila = $con->fetch_assoc($res)) {
		$columna++;
		$pdf->SetX($p[$columna]);
		$pdf->Cell($w[$columna],$alto,($fila["activo"]==1?'X':''),0,0,'LRTB',0);  
//		echo  '<td><input class="checkbox" align="center" disabled="true"  type="checkbox" id="cancelar'.$registros.'" name="cancelar'.$registros.'" value="'.$fila["idregistro"] .'" '.($fila["activo"]==1?'checked':'').'></td>'; // '<option '.($fila['valorparametro']=='V'?' selected="selected" ':'') .' value="'.$fila['valorparametro'].'">'.$fila['valorparametro'].' </option>'; 
	//	$registros++;
	}

/*
	$pdf->SetX($p[3]);
	$pdf->Cell($w[3],$alto,($r_nopr["status"]=='1'?'Act':'In'),0,0,'R');
	$pdf->SetX($p[4]);
	$pdf->Cell($w[4],$alto,$r_nopr["nivel"],0,0,'R');
*/
	if ($linea>=$rpl)
		$linea=encabeza_l_ut($header,$w,$p,$pdf,$salto,$alto, $con);
};
// $pdf->Output('reportesprestamos/'.$fechadescuento.'cuotas.pdf');
$pdf->Output();
set_time_limit(30);

////////////////////////////////////////////////////
function encabeza_l_ut($header,$w,$p,&$pdf,$salto,$alto, $con)
{
$pdf->AddPage();
$linea=25;
$pdf->SetY($linea);
$pdf->SetX(0);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,0,"Reporte de Notificaciones de Acciones al ".$con->convertir_fechadmy(substr($con->ahora(),0,10)),0,'C',0);
$pdf->SetY($linea);
$pdf->SetFont('Arial','',7);
$linea+=5;
$pdf->SetX(240);
// date_default_timezone_set('America/Caracas'); 
//$pdf->Cell(20,0,'Realizado el '.date('d/m/Y h:i A'),0,0,'C'); 
// $pdf->Cell(20,0,'Realizado el '.$con->ahora(),0,0,'C'); 
//Títulos de las columnas
$linea+=5;
$pdf->SetY($linea);
//$header=array($$arrtitulo);
//Colores, ancho de línea y fuente en negrita
$pdf->SetFillColor(200,200,200);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.2);
$pdf->SetFont('Arial','B',7);
//Cabecera
for($i=0;$i<count($w);$i++){
	$pdf->SetY($linea);
	$pdf->SetX($p[$i]);
	$pdf->Cell($w[$i],$alto,$header[$i],1,0,'C',1);
}
//Restauración de colores y fuentes
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',7);
$linea+=$salto;
$linea+=$salto;
$pdf->SetY($linea);
$pdf->SetX($p[0]);
$pdf->Cell(0,0,'  ',1,0,'L',0);
return $linea;
}
?>
