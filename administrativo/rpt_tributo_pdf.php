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
$sql_360="select * from campos order by articulo ";// limit 30"; //  limit 20";
$a_360=$con->consulta($sql_360);
$columna=3;
// echo $sql_360;
$rpl=250; 	// registros por listado
$crl=0;		// contador de registros por listado
$col_listado=0;
$nuevoarchivo=false;
$condicion_sql='select codigo, cedula, nombre, ';
$col_listado=0;
$header[0]='Art.No.';
$header[1]='Descripcion';
$header[2]='Funcion';
$header[3]='U.T.';
$header[4]='Fraccion';
$alto=4;
$salto=$alto;
$w=array(18,130,15,15,15,25); //,25,25,25,25,25,25);
$p[0]=10;
for ($posicion=1;$posicion<=count($w);$posicion++) 
	$p[$posicion]=$p[$posicion-1]+$w[$posicion-1];
//$p=array(10,18,31,36,76,91,106,131,136,161,196,221,246);

$pdf=new PDF('P','mm','Letter');
$pdf->Open();
$linea=encabeza_l_tributos($header,$w,$p,$pdf,$salto,$alto, $con);
$registros=$con->num_rows($a_360);
set_time_limit($registros);
while ($r_nopr = $con->fetch_assoc($a_360)){
	$pdf->SetY($linea);
	$linea+=$alto;
	$pdf->SetX($p[0]);
	$pdf->Cell($w[0],$alto,$r_nopr["articulo"],0,0,'LRTB',0);
	$pdf->SetX($p[1]);
	$pdf->Cell($w[1],$alto,$r_nopr["concepto"],0,0,'LRTB',0); 
	$pdf->SetX($p[2]);
	$pdf->Cell($w[2],$alto,$r_nopr["funcionalidad"],0,0,'LRTB',0);  
	$pdf->SetX($p[3]);
	$pdf->Cell($w[3],$alto,number_format($r_nopr["cantidadut"],2,',','.'),0,0,'R');
	$pdf->SetX($p[4]);
	$pdf->Cell($w[4],$alto,number_format($r_nopr["valorfraccion"],2,',','.'),0,0,'R');
	if ($linea>=$rpl)
		$linea=encabeza_l_tributos($header,$w,$p,$pdf,$salto,$alto, $con);
};
// $pdf->Output('reportesprestamos/'.$fechadescuento.'cuotas.pdf');
$pdf->Output();
set_time_limit(30);

////////////////////////////////////////////////////
function encabeza_l_tributos($header,$w,$p,&$pdf,$salto,$alto, $con)
{
$pdf->AddPage();
$linea=25;
$pdf->SetY($linea);
$pdf->SetX(0);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(0,0,"Reporte de Tributos al ".$con->convertir_fechadmy(substr($con->ahora(),0,10)),0,'C',0);
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
for($i=0;$i<5;$i++){
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
