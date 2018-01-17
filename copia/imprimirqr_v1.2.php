<?php
	// genero el codigo qr
    include "phpqrcode.php"; 
	$destino='qr_generados/';
    if (!file_exists($destino))
        mkdir($destino);    
    $errorCorrectionLevel = 'M';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
	
	include_once('ClassBasedeDatos.php');
	$con= new ClassBasedeDatos();
	$con->conectar();
	$numeroregistro = 20;
	$comando="select * from timbresfiscales where idregistro = '$numeroregistro'";
	$resultado = $con->consulta($comando);
	$registro = $con->fetch_assoc($resultado);

	$comando = "select * from configuracion where nombreparametro = 'idEstado'";
	$resuni = $con->consulta($comando);
	$estado = $con->fetch_assoc($resuni);
	$estado = $estado['valorparametro'];

	$comando = "select * from configuracion where nombreparametro = 'idMunicipio'";
	$resuni = $con->consulta($comando);
	$municipio = $con->fetch_assoc($resuni);
	$municipio= $municipio['valorparametro'];
	
	$miid=$registro['idregistro'];
	$tramite = $registro['codigoente'];
	
/*
	$unico = substr($registro['idregistro'],10,10);
	$unico.= $registro['fechatimbre'];
	$unico.= $registro['riftimbre'];
	$unico.= sinpunto($registro['montobs'],15);
	$unico.= $registro['planilla'];
	$unico.= $registro['fechapago'];
	$unico.= $registro['plaza'];
*/
	// echo '<br>unico sin convertir '.$unico;
	// $unico = md5($unico);
	// echo '<br>unico con md5 '.$unico;
	// $unico = substr($unico,0,20);
	// echo '<br>unico los  20 '.$unico;

	// generar unico 
    require 'aes/aes.class.php';     // AES PHP implementation
    require 'aes/aesctr.class.php';  // AES Counter Mode implementation
	$comando = "select * from configuracion where nombreparametro = 'PasoIdUnico'";
	$resuni = $con->consulta($comando);
	if ($con->num_rows($resuni) < 1)
	{
		echo '<div class="alert alert-danger" role="alert">';
			echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			echo '<strong>Error!</strong> No se ha definido el parametro de Tiempo';
			echo '</div>';
		die('');
	}
	$pw=$con->fetch_assoc($resuni);
	$pw=$pw['valorparametro'];
	$pt=$miid;
	$encr = AesCtr::encrypt($pt, $pw, 128);
	$todo = $estado . $municipio . $encr;
	$elcrc = str_pad(dechex(crc32($todo)), 8, '0', STR_PAD_LEFT);
	
	
//	echo 'encr '.$encr.'<br>unico '.$unico.'<br> t-enc'.strlen($encr).'<br> crc = '.$elcrc;
//	die('espero');
 
	$comando="update timbresfiscales set unico = '$encr' where idregistro = '$numeroregistro'";
	$resultado = $con->consulta($comando);

	$comando="select * from timbresfiscales where idregistro = '$numeroregistro'";
	$resultado = $con->consulta($comando);
	$registro = $con->fetch_assoc($resultado);
//	echo $comando;

	$comando="select * from campos where idregistro = '$tramite'";
	$resultadot = $con->consulta($comando);
	$registrot = $con->fetch_assoc($resultadot);
//	echo $comando;

	
	
	$data = $todo.$elcrc;
/*
	$data = rellenar('ESTADO BOLIVAR',20); // emisor
	$data.= rellenar($unico,20);		// serial unico 
	$data.= rellenar(substr($registrot['concepto'],0,20),20); // parte del tramite
	$data.= rellenar(sinpunto($registro['montout'],15),15);	// monto en ut
	$data.= rellenar(sinpunto($registro['montobs'],15),15);	// monto en bs
	$data.= rellenar($registro['riftimbre'],14);			// rif solicitante
	$fecha = explode('-',$registro['fechatimbre']);
	$data.= rellenar((substr($fecha[0],2,2).$fecha[1].$fecha[2]),6);
*/
	// echo '<br>data para el qr'.$data; 
	
	$filename = $destino.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	// $filename = $destino.'salida.png'; // ($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	// echo $filename;
	// generando qr
	QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
	// qr almacenado
//	echo '<img src="'.$filename.'" alt="Imagen con el código QR generado"><br><br>';  
	
	// imprima($filename,$idregistro, $registro, $registrot);

	
	$ancho = $alto = 200;
	$opacidad = 80;
	$lineas=8;
	// crear patron 
	crear_patron($miid, $alto, $ancho, $lineas);

	// fusionar imagenes
	$nombrearchivo=fusionar_imagenes($miid, $filename, $alto, $ancho, $opacidad);
// echo $registrot['concepto'];
// die('espero');	
	$image = colocar_datos($nombrearchivo, $alto, $ancho, $idregistro, $registro, $registrot);	
	
/*
	require_once('imageworkshop/imageworkshop/imageworkshop.php');
	$norwayLayer = new ImageWorkshop(array("imageFromPath" => $nombrearchivo,));
 	$textLayer = new ImageWorkshop(array(
		"text" => "PHP ",
		"fontPath" => "arial.ttf",
		"fontSize" => 40,
		"fontColor" => "ffffff",
		"textRotation" => calculAngleBtwHypoAndLeftSide($norwayLayer->getWidth(), $norwayLayer->getHeight()),
	));
 // phpinfo();

//	echo $nombrearchivo;
// Some funky opacity
$textLayer->opacity(70);
 
// We add the $textLayer on the norway layer, in its middle
$norwayLayer->addLayer(1, $textLayer, 0, 0, 'MM');
$image = $norwayLayer->getResult();


	 header('Content-type: image/jpeg');
	 
	 imagejpeg($image, null, 60); 
*/	
	
	
function fusionar_imagenes($miid, $filename, $alto, $ancho, $opacidad)
{
	require_once('imageworkshop/imageworkshop/imageworkshop.php');
//	$norwayLayer = new ImageWorkshop(array("imageFromPath" => $filename,));
//	$watermarkLayer = new ImageWorkshop(array("imageFromPath" => "patron/".$miid.'.png',));
	$watermarkLayer = new ImageWorkshop(array("imageFromPath" => $filename,));
	$norwayLayer = new ImageWorkshop(array("imageFromPath" => "img-patron/".$miid.'.png',));
	$logo = new ImageWorkshop(array("imageFromPath" => 'identificacion/logo.jpg',));

	$watermarkLayer->opacity($opacidad);
	$norwayLayer->addLayer(2, $watermarkLayer, 25, 25, "LB");
	$altologo=35;
	$anchologo=60;
	$logo->resizeInPixel(60, $altologo, false);
	$norwayLayer->addLayer(1, $logo, 0, ($alto-$altologo), "LB");
	$norwayLayer->addLayer(1, $logo, ($ancho-$anchologo), ($alto-$altologo), "LB");
 
	$image = $norwayLayer->getResult();
	// $image = colocar_datos($image, $alto, $ancho);	
	
	/*
	header('Content-type: image/jpeg');
	 
	imagejpeg($image, null, 60); 
	*/
	$nombreimagen='img-resultado/'.$miid.'.jpg';
	imagejpeg($image,$nombreimagen);
	return $nombreimagen;
}	

/*
function imprima_imagen ($image, $tamano, $angulo, $fila, $columna, $color, $fuente, $texto, $sombra, $gris)
{
	if ($sombra == 1)
		imagettftext($image, $tamano, $angulo, ($fila+1), ($columna+1), $gris, $fuente, $texto);
	imagettftext($image, $tamano, $angulo, ($fila), ($columna), $color, $fuente, $texto);
}
*/
function colocar_datos($image, $alto, $ancho,$idregistro, $registro, $registrot)
{
	// putenv('GDFONTPATH=' . realpath('.'));
	require_once('imageworkshop/imageworkshop/imageworkshop.php');
	/*
	$image = imagecreatetruecolor($alto, $ancho);
	$fuente = 'arial.ttf';
	$blanco = imagecolorallocate($image, 255, 255, 255);
	$gris = imagecolorallocate($image, 128, 128, 128);
	$negro = imagecolorallocate($image, 0, 0, 0);
	echo $image;
	*/
	$blanco = "848484"; // fffff";
	$negro = "000000";
	$norwayLayer = new ImageWorkshop(array("imageFromPath" => $image,));
 	$txtgober = new ImageWorkshop(array(
		"text" => 'GOBERNACION ESTADO BOLIVAR',
		"fontPath" => "arial.ttf",
		"fontSize" => 4,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtdir = new ImageWorkshop(array(
		"text" => 'DIRECCION DE TRIBUTOS',
		"fontPath" => "arial.ttf",
		"fontSize" => 4,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtrif = new ImageWorkshop(array(
		"text" => 'RIF: '.$registro['riftimbre'],
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtrazon = new ImageWorkshop(array(
		"text" => $registro['nombretimbre'],
		"fontPath" => "arial.ttf",
		"fontSize" => 5,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtapos = new ImageWorkshop(array(
		"text" => 'Espacio para apostillar',
		"fontPath" => "arial.ttf",
		"fontSize" => 4,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
///////////////////////////////
 	$txtemision = new ImageWorkshop(array(
		"text" => 'Emision: '.$registro['fechapago'] . ' s/Planilla ' .$registro['nroplanilla'],
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
		"fontColor" => $negro,
		"textRotation" => 90,
	));
 	$txtmonto = new ImageWorkshop(array(
		"text" => 'Monto BsF: '.number_format($registro['fechatimbre'],2,'.',''),
		"fontPath" => "arial.ttf",
		"fontSize" => 10,
		"fontColor" => $negro,
		"textRotation" => 90,
	));

 	$txttributo1 = new ImageWorkshop(array(
		"text" => 'Tramite: '.substr($registrot['concepto'],0,30),
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
		"fontColor" => $negro,
		"textRotation" => 270,
	));
 	$txttributo2 = new ImageWorkshop(array(
		"text" => substr($registrot['concepto'],30,40),
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
		"fontColor" => $negro,
		"textRotation" => 270,
	));

	$medidas='';
	if ($registro['requeridas'] > 0)
		$medidas = $registro['medidasfijas']. '='.$registro['requeridas'];
	if ($registro['requerido'] > 0)
		$medidas = $registro['medidasvariables']. '='.$registro['requerido'];

 	$txttributo3 = new ImageWorkshop(array(
		"text" => $medidas,
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
		"fontColor" => $negro,
		"textRotation" => 270,
	));
	
	
 	$textLayer = new ImageWorkshop(array(
		"text" => 'PARA REVISION',
		"fontPath" => "arial.ttf",
		"fontSize" => 16,
		"fontColor" => $blanco,
		"textRotation" => calculAngleBtwHypoAndLeftSide($norwayLayer->getWidth(), $norwayLayer->getHeight()),
	));


// Some funky opacity
$txtgober->opacity(200);
$txtdir->opacity(150);
$txtrif->opacity(200);
$txtrazon->opacity(150);
$txtapos->opacity(200);
//////
$txtemision->opacity(150);
$txtmonto->opacity(175);
////
$txttributo1->opacity(175);
$txttributo2->opacity(175);
$txttributo3->opacity(175);
/////
$textLayer->opacity(225);

 
// We add the $textLayer on the norway layer, in its middle
$norwayLayer->addLayer(1, $txtgober, 0, 10, 'MT');
$norwayLayer->addLayer(1, $txtdir, 0, 20, 'MT');
//
$norwayLayer->addLayer(1, $txtrif, 15, 20, 'LB');
$norwayLayer->addLayer(1, $txtrazon, 15, 15, 'RB');
$norwayLayer->addLayer(1, $txtapos, 0, 10, 'MB');
//////
$norwayLayer->addLayer(1, $txtemision, 10, 10, 'LM');
$norwayLayer->addLayer(1, $txtmonto, 20, 10, 'LM');
/////
$norwayLayer->addLayer(1, $txttributo1, 05, 10, 'RM');
$norwayLayer->addLayer(1, $txttributo2, 15, 10, 'RM');
$norwayLayer->addLayer(1, $txttributo3, 25, 10, 'RM');
///////
$norwayLayer->addLayer(1, $textLayer, 0, 10, 'MM');
///////
$image = $norwayLayer->getResult();


	 header('Content-type: image/jpeg');
	 
	 imagejpeg($image, null, 60); 
	$nombreimagen='img-resultado/x'.$miid.'.jpg';
	imagejpeg($image,$nombreimagen);


/*
	*/
}
	
	
function crear_patron($archivo,$alto,$ancho, $lineas)
{	
	$image = @imagecreatetruecolor($alto, $ancho) or die("Cannot Initialize new GD image stream");
	// set background and allocate drawing colours
	//$background = imagecolorallocate($image, 0x66, 0x99, 0x66);
	$background = imagecolorallocate($image, 0xff, 0xff, 0xff);
	imagefill($image, 0, 0, $background);
	$linecolor = imagecolorallocate($image, 0x84, 0x84, 0x84);
	$elipsecolor_amarillo = imagecolorallocatealpha($image, 255, 255, 0, 125);
	$elipsecolor_azul = imagecolorallocatealpha($image, 0, 0, 255, 115);
	 $textcolor1 = imagecolorallocate($image, 0x00, 0x00, 0x00);
	 $textcolor2 = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
	$par = 0;
	// draw random lines on canvas
	for($i=0; $i < $lineas; $i++) {
		imagesetthickness($image, rand(0,2));
		imageline($image, 0, rand(0,$alto), $ancho, rand(0,$ancho) , $linecolor);
		$radio = rand(0,$ancho);
		if ($par == 0)
		{
			imagefilledellipse($image, rand(0,$alto), rand(0,$ancho), $radio, $radio, $elipsecolor_amarillo);
			$par = 1;
		}
		else 
		{
			imagefilledellipse($image, rand(0,$alto), rand(0,$ancho), $radio, $radio, $elipsecolor_azul);
			$par = 0;
		}
		// imagen, izq, alto, der, fin, color
	}
	    // write some text into the image
    // imagestring($image, 6,10, 10, 'NO IMAGE', $textcolor1);
    // imagestring($image, 6,10, 30, 'AVAILABLE', $textcolor2);
	imagepng($image,'img-patron/'.$archivo.'.png');
//  session_start();
  // add random digits to canvas using random black/white colour
/*
  $digit = '';
  for($x = 15; $x <= 95; $x += 20) {
    $textcolor = (rand() % 2) ? $textcolor1 : $textcolor2;
    $digit .= ($num = rand(0, 9));
    imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
  }
  // record digits in session variable
  $_SESSION['digit'] = $digit;
*/

  // display image and clean up
  /*
  header('Content-type: image/png');
  imagepng($image);
  imagedestroy($image);
  */
  
}

	
function calculAngleBtwHypoAndLeftSide($bottomSideWidth, $leftSideWidth)
{
    $hypothenuse = sqrt(pow($bottomSideWidth, 2) + pow($leftSideWidth, 2));
    $bottomRightAngle = acos($bottomSideWidth / $hypothenuse) + 180 / pi();
     
    return -round(90 - $bottomRightAngle);
}

    
	
function rellenar($variable,$caracteres)
{
	$tamano=strlen(trim($variable));
	$variable=trim($variable);
	$faltan=$caracteres-$tamano;
	for ($relleno = 0; $relleno < $faltan; $relleno++)
		$variable.='.';
	return $variable;
}

function sinpunto($monto,$caracteres)
{
	$sinpunto='';
	for ($i=0;$i<strlen($monto);$i++)
		if (substr($monto,$i,1)!= '.')
			$sinpunto.=substr($monto,$i,1);
	$monto=ceroizq($sinpunto,$caracteres);
	return $monto;
}

function ceroizq($laultima,$digitos)
{
	$tamano=$digitos-strlen($laultima);
	$nuevacadena="";
	// echo $tamano;
	// (5-$tamano)=$posicion)
	for ($posicion=1;$posicion <= $tamano;$posicion++) {
		$nuevacadena=$nuevacadena."0"; 
		// echo $nuevacadena."-";
		}
		// echo $nuevacadena."---------".$laultima;
	$nuevacadena=$nuevacadena.$laultima;
	// echo $nuevacadena;
	return $nuevacadena;
		
}


/*
class PDF_AutoPrint extends PDF_JavaScript
{
function AutoPrint($dialog=false)
{
	//Open the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}
}
*/

function imprima($filename, $idregistro, $registro, $registrot)
{
	header('Content-type: application/pdf');
//	require('fpdf/pdf_js.php');
	define('FPDF_FONTPATH','fpdf/font/');
//	require('fpdf/mysql_table.php');
//	include("fpdf/comunes.php");


//	define('FPDF_FONTPATH','fpdf/font/');
//	require('fpdf/mysql_table.php');
//	include("fpdf/comunes.php");
	require('fpdf/rotation.php');
	
	class PDF extends PDF_Rotate
	{
		function RotatedText($x,$y,$txt,$angle)
		{
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

		function RotatedImage($file,$x,$y,$w,$h,$angle)
		{
			//Image rotated around its upper-left corner
			$this->Rotate($angle,$x,$y);
			$this->Image($file,$x,$y,$w,$h);
			$this->Rotate(0);
		}
	}


	$pdf=new PDF('P','mm','Letter');
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',11);

	$arrvlogo=[10,75,10,75];
	$arrhlogo=[10,10,75,75];
	$alto=10;
	$linea=10;
	for ($veces=0;$veces<4;$veces++)
	{
		$pdf->SetY($arrvlogo[$veces]);
		$pdf->SetX($arrhlogo[$veces]);
		$x=$arrvlogo[$veces];
		$y=$arrhlogo[$veces];
		$ancho=15;
		$alto=15;
		$pdf->Image('identificacion/logo.jpg',$x,$y,$ancho,$alto,jpg);
		// $pdf->Cell(0,6,'x='.$x.' y='.$y,0,0,'C',0);
		// $pdf->Cell(0,10,'-- '.$this->PageNo().' --',0,0,'C');	
	}
	$x=25;
	$y=25;
	$ancho=50;
	$alto=50;
	$pdf->Image($filename,$x,$y,$ancho,$alto,png);
	$linea+=$alto;
	$linea=10;
	//	$pdf->Cell(0,6,'x=',0,0,'C');
	
	$alto=5;
	$pdf->SetY($linea);
	$pdf->SetX(0);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(100,5,'GOBERNACION ESTADO BOLIVAR',0,'C',0);
	$linea+=$alto;
	$pdf->SetY($linea);
	$pdf->SetX(0);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(100,5,'DIRECCION DE TRIBUTOS',0,'C',0);
	$linea+=65;
	$pdf->SetY($linea);
	$pdf->SetX(0);
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(100,5,$linea .'RIF: '.$registro['riftimbre'],0,'C',0);

	$linea+=$alto;
	$pdf->SetY($linea);
	$pdf->SetX(0);
	$pdf->SetFont('Arial','I',7);
	$pdf->MultiCell(100,5,$linea .$registro['nombretimbre'],0,'C',0);

	$linea+=$alto;
	$pdf->SetY($linea);
	$pdf->SetX(0);
	$pdf->SetFont('Arial','I',7);
	$pdf->MultiCell(100,5,$linea .'Espacio para el apostillado',0,'C',0);

// $pdf->RotatedImage('circle.png',85,60,40,16,45);
	$pdf->RotatedText(25,65,'Fecha Emision: '.$registro['fechatimbre'],90);

	$pdf->SetFont('Arial','B',13);
	$pdf->RotatedText(20,75,'Monto BsF: '.number_format($registro['fechatimbre'],2,'.',''),90);
	
	$pdf->SetFont('Arial','I',7);
	$pdf->RotatedText(78,25,'Tramite: '.substr($registrot['concepto'],0,30),270);
	$pdf->RotatedText(75,25,substr($registrot['concepto'],31,40),270);
	$pdf->RotatedText(82,25,''.$registro['unico'],270);
	
	if ($registro['requeridas'] > 0)
		$medidas = $registro['medidasfijas']. '='.$registro['requeridas'];
	if ($registro['requerido'] > 0)
		$medidas = $registro['medidasvariables']. '='.$registro['requerido'];

	$pdf->RotatedText(90,30,$medidas,270);
	


	
	$salida='generado/'.$registro['idregistro'].'.pdf';
// $pdf->Output($salida,'F');
 $pdf->Output();

/*
$consulta = "select * from sgcaf200 where ced_prof='$cedula'";
$query = mysql_query($consulta);
$socio = mysql_fetch_assoc($query);
if ($prestamo['aprobar']==0) {
	$cuento= '   Yo, '.trim($socio['ape_prof']). ' '.trim($socio['nombr_prof']).' mayor de edad, titular de la Cédula de Identidad: ';
	$cuento.=$socio['ced_prof'].' y Socio de esta institución identificado con el Código '.$socio['cod_prof'];
	$cuento.=' me dirijo a la Junta Directiva con el fin de solicitar la cantidad de Bolívares '.strtoupper(num2letras($prestamo['monpre_sdp']-$prestamo['inicial']));
	$cuento.='  ****Bs. ('.trim(number_format($prestamo['monpre_sdp']-$prestamo['inicial'],2,".",",")).')**** en calidad de prestamo. ';
	$cuento.=' Para garantizar el pago de esta obligación doy en garantía los Ahorros que tengo en la institución' ;
	$cuento.=' y de  no ser  suficiente  avalarán   los fiadores abajo firmantes, hasta por las cantidades especificadas. ';
	$cuento.=' Dicho préstamo comenzará a ser descontado a partir del '.convertir_fechadmy3($prestamo['fecha_acta']);
}
else
{
	$cuento= '   Yo, '.trim($socio['ape_prof']). ' '.trim($socio['nombr_prof']).' mayor de edad, titular de la Cédula de Identidad: ';
	$cuento.=$socio['ced_prof'].' y Socio de esta institución identificado con el Código '.$socio['cod_prof'];
	$cuento.=' me dirijo a la Junta Directiva con el fin de solicitar la cantidad de Bolívares '.strtoupper(num2letras($prestamo['monpre_sdp']-$prestamo['inicial']));
	$cuento.='  ****Bs. ('.trim(number_format($prestamo['monpre_sdp']-$prestamo['inicial'],2,".",",")).')**** en calidad de prestamo. ';
	$cuento.='De igual manera, en reunión de Junta Directiva según Acta N° ' . $prestamo['nro_acta'] . ' de fecha ' . convertir_fechadmy3($prestamo['fecha_acta']).' se acordó la aprobación del prestamo arriba indicado al socio ';
	$cuento.= trim($socio['ape_prof']). ' '.trim($socio['nombr_prof']).', titular de la Cédula de Identidad: ';
	$cuento.=$socio['ced_prof'].' identificado con el Código '.$socio['cod_prof'];
	$cuento.=' por la cantidad de Bolívares '.strtoupper(num2letras($prestamo['monpre_sdp']-$prestamo['inicial']));
	$cuento.='  ****Bs. ('.trim(number_format($prestamo['monpre_sdp']-$prestamo['inicial'],2,".",",")).')****. ';
	$cuento.='Dicha operacion será acreditada en la Cuenta ';
	$cuento.='Nro. '.$socio['ctan_prof']. ' a partir de '.convertir_fechadmy3($prestamo['f_1cuo_sdp']);
}
$codigosocio=$socio['cod_prof'];
$linea+=10;
$pdf->SetY($linea);
$pdf->SetX(10);
$pdf->MultiCell(0,5,$cuento,0,'L'); 
$linea+=30;
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX(10);
$pdf->Cell(0,6,'______________________________________',0,0,'C',0);
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX(10);
$pdf->Cell(0,6,'Firma/Cédula del Asociado',0,0,'C',0);

$linea+=10;
$columna=array(10,80,110,140);
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$pdf->Cell(0,6,'Prestamo concedido por la cantidad de ',0,0,'L',0);
$pdf->SetX($columna[3]);
$pdf->Cell(60,6,number_format($prestamo['monpre_sdp'],2,".",","),0,0,'R',0);
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$pdf->Cell(80,6,'MENOS Inicial',0,0,'L',0);
$pdf->SetX($columna[3]);
$pdf->Cell(60,6,number_format($prestamo['inicial'],2,".",","),0,0,'R',0);
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[2]);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,6,'TOTAL PRESTAMO',0,0,'R',0);
$pdf->SetX($columna[3]);
$pdf->Cell(60,6,number_format(($prestamo['monpre_sdp']-$prestamo['inicial']),2,".",","),0,0,'R',0);
$pdf->SetFont('Arial','',12);

$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,6,'MENOS Deducciones',0,0,'L',0);
$pdf->SetFont('Arial','',12);

$t_deduccion=0;
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$pdf->Cell(0,6,'Intereses cobrados por anticipado al '.number_format($prestamo['interes_sd'],2,".",",").'%',0,0,'L',0);
$pdf->SetX($columna[2]);
$pdf->Cell(60,6,number_format($prestamo['intereses'],2,".",","),0,0,'R',0);
$t_deduccion+=$prestamo['intereses'];

$sql_deducciones="select * from sgcaf312 where cedula='$micedula' and numero = '$elnumero' and tipo = '-' order by cuento ";
$a_deduccion=mysql_query($sql_deducciones);
while($r_deduccion=mysql_fetch_assoc($a_deduccion)) {
	$linea+=5;
	$pdf->SetY($linea);
	$pdf->SetX($columna[0]);
	$pdf->Cell(0,6,$r_deduccion['cuento'],0,0,'L',0);
	$pdf->SetX($columna[2]);
	$pdf->Cell(60,6,number_format($r_deduccion['monto'],2,".",","),0,0,'R',0);
	$t_deduccion+=$r_deduccion['monto'];
}

$linea+=5;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',12);
$pdf->SetX($columna[2]);
$pdf->Cell(60,6,'Total Deducciones',0,0,'R',0);
$pdf->SetX($columna[3]);
$pdf->Cell(60,6,number_format($t_deduccion,2,".",","),0,0,'R',0);
$pdf->SetFont('Arial','',12);


$t_reintegro=0;
$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,6,'MAS Reintegros',0,0,'L',0);
$pdf->SetFont('Arial','',12);

$sql_deducciones="select * from sgcaf312 where cedula='$micedula' and numero = '$elnumero' and tipo = '+' order by cuento ";
$a_deduccion=mysql_query($sql_deducciones);
while($r_deduccion=mysql_fetch_assoc($a_deduccion)) {
	$linea+=5;
	$pdf->SetY($linea);
	$pdf->SetX($columna[0]);
	$pdf->Cell(0,6,$r_deduccion['cuento'],0,0,'L',0);
	$pdf->SetX($columna[2]);
	$pdf->Cell(60,6,number_format($r_deduccion['monto'],2,".",","),0,0,'R',0);
	$t_reintegro+=$r_deduccion['monto'];
}

$linea+=5;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',12);
$pdf->SetX($columna[2]);
$pdf->Cell(60,6,'Total Reintegros',0,0,'R',0);
$pdf->SetX($columna[3]);
$pdf->Cell(60,6,number_format($t_reintegro,2,".",","),0,0,'R',0);
$pdf->SetFont('Arial','',12);

$linea+=5;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',10);
$pdf->SetX($columna[2]);
$pdf->Cell(60,6,'Neto a Recibir',0,0,'R',0);
$pdf->SetX($columna[3]);
$neto=($prestamo['monpre_sdp']-$prestamo['inicial'])+$t_reintegro-$t_deduccion;
$pdf->Cell(60,6,number_format($neto,2,".",","),0,0,'R',0);
$pdf->SetFont('Arial','',12);

$linea+=5;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',10);
$pdf->SetX($columna[0]);
$pdf->Cell(0,6,'Condiciones del Crédito',0,0,'C',0);
$pdf->SetFont('Arial','',12);

$linea+=5;
$pdf->SetY($linea);
$pdf->SetX($columna[0]);
$cuento=trim($prestamo['descr_pres']). ' otorgado por la cantidad de Bs. '.number_format(($prestamo['monpre_sdp']-$prestamo['inicial']),2,".",",");
$cuento.=' entre la forma en que se propone cancelar el préstamo ' . trim($prestamo['nrocuotas']) . ' cuotas de Bs. ';
$cuento.=strtoupper(num2letras($prestamo['cuota'])); 
$cuento.=' Bs. ('.number_format($prestamo['cuota'],2,".",",").') ';
$cuento.=' *** LOS PRESTAMOS ESPECIALES NO TIENEN DERECHO A REINTEGRO *** ';
$pdf->MultiCell(0,5,$cuento,0,'L'); 

// fiadores
$sql_fiador="select * from sgcaf320, sgcaf200 where (codsoc_fia='$codigosocio') and (nropre_fia = '$elnumero') and (codfia_fia=cod_prof)";
$a_fiador= mysql_query($sql_fiador);
// echo $sql_fiador;
if (mysql_num_rows($a_fiador) > 0) {
	$linea+=15;
	$pdf->SetY($linea);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX($columna[0]);
	$pdf->Cell(0,6,'Espacio para ser llenado por los fiadores',0,0,'C',0);
	$pdf->SetFont('Arial','',12);

	$header=array('Apellidos y Nombres','Nro. C.I.','Monto Fianza','Firma','Revisado por');
	//Cabecera
    $w=array(60,40, 30, 20, 40);
	$c=array(10,70,110,140,160);
	$linea+=5;
	$pdf->SetY($linea);
    for($i=0;$i<count($header);$i++) {
		$pdf->SetX($c[$i]);
        $pdf->Cell($w[$i],6,$header[$i],1,0,'C',0);
	}

	while($r_fiador=mysql_fetch_assoc($a_fiador)) {
		$linea+=5;
		$pdf->SetY($linea);
		$pdf->SetX($c[0]);
		$pdf->Cell($w[0],6,trim($r_fiador['ape_prof']).' '.trim($r_fiador['nombr_prof']));
		$pdf->SetX($c[1]);
		$pdf->Cell($w[1],6,$r_fiador['ced_prof'],0,0,'L',0);
		$pdf->SetX($c[2]);
		$pdf->Cell($w[2],6,number_format($r_fiador['monto_fia'],2,".",","),0,0,'R',0);
	}	
}


//$linea+=25;
$linea+=20;
$pdf->SetY($linea);
$pdf->SetX(10);
$pdf->Cell(70,6,'Elaborado por',1,0,'C',0);
$pdf->SetX(80);
$pdf->Cell(30,6,'Verificado por ',1,0,'C',0);
$pdf->SetX(110);
$pdf->Cell(30,6,'Presidente',1,0,'C',0);
$pdf->SetX(140);
$pdf->Cell(50,6,'Tesorero',1,0,'C',0);
$linea+=15;
$pdf->SetY($linea);
$pdf->SetX(10);
$elasiento=$_SESSION['elasiento'];
$pdf->Cell(70,6,'Nro de Comprobante: '.$elasiento,0,0,'L',0);

// revisar si tienen planilla de descuento especial con nominas
// ------------
if ($prestamo['pla_autor']==1) {
//  $pdf->AddPage();
  $linea+=15;
	$pdf->SetFont('Arial','',10);
  $pdf->SetY($linea);
  $pdf->SetX(20);

	$cuento= '   Yo, '.trim($socio['ape_prof']). ' '.trim($socio['nombr_prof']).' titular de la Cédula de Identidad: ';
	$cuento.=$socio['ced_prof'].' y Socio de esta institución identificado con el Código '.$socio['cod_prof'];
  $cuento.=' de la Caja de Ahorro y Préstamo del Personal ';
  $cuento.='Obrero de la Universidad Centroccidental "Lisandro Alvarado" (CAPPO-UCLA)';
  $cuento.=', autorizo a la Administración de la Caja de Ahorro para que me sea descontado POR ';
  $cuento.='UNA SOLA VEZ de la(s) nómina(s) correspondientes a PAGOS ESPECIALES, que cancela la ';
  $cuento.='UCLA; por la cantidad de BOLIVARES ';
  $cuento.=strtoupper(num2letras($prestamo['cuota'])); 
  $cuento.=' por concepto de '.trim($prestamo['descr_pres']);

  $pdf->MultiCell(0,5,$cuento,0,'L'); 
  $linea+=30;
  $linea+=5;
  $pdf->SetY($linea);
  $pdf->SetX(10);
  $pdf->Cell(0,6,'______________________________________',0,0,'C',0);
  $linea+=5;
  $pdf->SetY($linea);
  $pdf->SetX(10);
  $pdf->Cell(0,6,'Firma/Cédula del Asociado',0,0,'C',0);
*/
}


/*
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../temp'.DIRECTORY_SEPARATOR;
	$PNG_TEMP_DIR = 'temp/'; //.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'test/qr/temp/';   
	echo 'temporal '.$PNG_TEMP_DIR.'<br>';
    include "phpqrcode.php"; 
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);    
    // $filename = $PNG_TEMP_DIR.'test.png';
	$filename = $PNG_TEMP_DIR.'test.png';
	echo $filename;

    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && 
in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

    if (isset($_REQUEST['data'])) { 

        if (trim($_REQUEST['data']) == '')
            die('No hay datos! <a href="?">Volver</a>');    
        

        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		echo '<br>filename '.$filename.'<br>';
        
    }     
    // echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" alt="Imagen con el código QR generado"><br><br>';  
	echo '<img src="'.$filename.'" alt="Imagen con el código QR generado"><br><br>';  

    echo '<form action="" method="post"><div>		
Introduce los datos a codificar:<br><textarea rows="4" 
cols="58" class="ent" 
name="data">'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'
 ').'</textarea><br>		
        ECC:&nbsp;<select class="campos" name="level">
            <option value="L"'.(($errorCorrectionLevel=='L')?' 
selected':'').'>L - menor</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' 
selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' 
selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' 
selected':'').'>H - el mejor</option>
        </select>&nbsp;
        Tamaño de la imagen:&nbsp;<select class="campos" 
name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' 
selected':'').'>'.$i.'</option>';
        
    echo '</select><br>
	Introduce los caracteres que ves en la imagen<br>
	    <img style="margin-top:4px;" alt="Numeros aleatorios" 
src="../image.php">  
        <input class="campos" type="text" name="num"><br>
        <input class="campos" type="submit" 
value="GENERAR"></div>
		</form><br>';
 session_start(); 
$_REQUEST = (get_magic_quotes_gpc() ? array_map('stripslashes', 
$_REQUEST) : $_REQUEST); //satinizar
if($_SESSION['img_number'] != $_POST['num']){ 
  echo'<div style="color:red;">Los caracteres no se 
corresponden.<br> 
 Trate de nuevo por favor</div>'; 
}else{ 	
QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, 
$matrixPointSize, 2); 
}
*/         
?> 
