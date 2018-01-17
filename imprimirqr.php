<?php
session_start();
	// genero el codigo qr
	// phpinfo();
//	echo 'idp '. $_POST['idp'];
// die('nada');
    include "phpqrcode.php"; 
	$destino='qr_generados/';
    if (!file_exists($destino))
        mkdir($destino);    
	$destinopdf='pdf';
    if (!file_exists($destinopdf))
        mkdir($destinopdf);    
    $errorCorrectionLevel = 'M';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
	
	include_once('classbasededatos.php');
	$con= new classbasededatos();
	$con->conectar();
	if (!$_POST['idp'])
		$numeroregistro = $_GET['idp'];
	else $numeroregistro = $_POST['idp'];
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
	$numeroregistro = $miid;
	// echo ' mi id '.$miid;
	$encr = AesCtr::encrypt($pt, $pw, 128);
	// echo $encr.'<br>';
	$encrHex = str_pad(strToHex($encr), 80, '0', STR_PAD_LEFT);
	// echo '<br>'.$encr;
	// $encr1 = HexTostr($encr);
	// echo '<br>'.$encr1;
	// echo '<br>'.($encr==$encr1); 
	// die('tamano'.strlen($encr));
	$todo = $estado . $municipio . $encr;
	/// para jose
	$todo = $encr;
	$elcrc = str_pad(dechex(crc32($todo)), 8, '0', STR_PAD_LEFT);
	
	
//	echo 'encr '.$encr.'<br>unico '.$unico.'<br> t-enc'.strlen($encr).'<br> crc = '.$elcrc;
//	die('espero');
 
	$comando="update timbresfiscales set unico = '$encrHex', vecesimpreso = (vecesimpreso + 1), statustimbre=3 where idregistro = '$numeroregistro'";
	// $comando="update timbresfiscales set unico = '$encrHex', vecesimpreso = 1, statustimbre=3 where idregistro = '$numeroregistro'";
	$resultado = $con->consulta($comando);
 // echo $comando;

	$comando="select * from timbresfiscales where idregistro = '$numeroregistro'";
	$resultado = $con->consulta($comando);
	$registro = $con->fetch_assoc($resultado);
//	echo $comando. ' /// '.$registro['fechapago'].'////';

	$comando="select * from campos where idregistro = '$tramite'";
	$resultadot = $con->consulta($comando);
	$registrot = $con->fetch_assoc($resultadot);
//	echo $comando;

	
	
	$data = $todo.$elcrc;
	// para jose 
	$data = $encr;
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
	$opacidad = 100;
	$lineas=8;
	// crear patron 
	crear_patron($miid, $alto, $ancho, $lineas);

	// fusionar imagenes
	$nombrearchivo=fusionar_imagenes($miid, $filename, $alto, $ancho, $opacidad);

	$image = colocar_datos($nombrearchivo, $alto, $ancho, $miid, $registro, $registrot);	

//	echo 'nombrearchivo '.$nombrearchivo;
	// header('Content-type: application/pdf');
	// header('Content-type: application/PDF');
	 $archivopdf=hacer_pdf($image, $miid, $destinopdf);
	 if (enviar_estampilla($con, $archivopdf, $miid) > 0)
	 {
		echo '<div class="alert alert-info" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		echo '<strong>Error!</strong> Se ha enviado el Timbre Fisca a su correo...';
		echo '</div>';
	 }
	 else 
	 {
		echo '<div class="alert alert-danger" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		echo '<strong>Error!</strong> No se ha podido enviar el correo... intente mas tarde';
		echo '</div>';
	 }
		 
	 
	
function strToHex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= strtoupper(dechex(ord($string[$i])));
    }
    return $hex;
}


function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

	function enviar_estampilla($conexion, $archivoimagen, $tramite)
	{
		$buscar = "select * from usuarios where rif_usuario = '".$_SESSION['rif']."'";
		$resb=$conexion->consulta($buscar);
		$enviara = $conexion->fetch_assoc($resb);
		$enviara = $enviara['email'];

		$buscar = "select * from timbresfiscales, campos, plazas where (timbresfiscales.idregistro = '".$tramite."') and (codigoente = campos.idregistro) and (plaza = plazas.codigo)";
		// echo $buscar;
		$resb=$conexion->consulta($buscar);
		$eltri = $conexion->fetch_assoc($resb);
		$eltrib = $eltri['articulo']. ' / '.$eltri['concepto'];
		
		$buscar="select * from configuracion where nombreparametro = 'mailenviadopor'";
		$resb=$conexion->consulta($buscar);
		$enviadopor = $conexion->fetch_assoc($resb);
		$enviadopor = $enviadopor['valorparametro'];
		
		$buscar="select * from configuracion where nombreparametro = 'responderemail'";
		$resb=$conexion->consulta($buscar);
		$respondera = $conexion->fetch_assoc($resb);
		$respondera = $respondera['valorparametro'];

		$buscar="select * from configuracion where nombreparametro = 'direccionweb'";
		$resb=$conexion->consulta($buscar);
		$dirweb = $conexion->fetch_assoc($resb);
		$dirweb = $dirweb['valorparametro'];

		include_once('enviarmail.php');

		$cuento= '<table>';
		$cuento.= '<tr>';
		$cuento.= '<td><img src="'.$dirweb.'/identificacion/logo.jpg"/></td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td><strong>Estimada(o) Contribuyente:</strong></td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td><strong>'.$_SESSION['nombre_usuario'] .'</strong> ('.$_SESSION['rif'].')</td>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '</tr>';
		$cuento.= '<tr>';
		$cuento.= '<td>Adjunto al presente encontrara el Timbre Fiscal solicitado</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Tramite Nro. = '.$tramite;
		$cuento.= '</td>';
		$cuento.= '</tr>';

/*
		$cuento.= '<tr>';
		$cuento.= '<td>Tributo = '.$eltrib;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Planilla = '.$planilla;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Fecha de Pago = '.$fechapago;
		$cuento.= '</td>';
		$cuento.= '</tr>';

		$cuento.= '<tr>';
		$cuento.= '<td>Plaza = '.$eltri['nombre'];
		$cuento.= '</td>';
		$cuento.= '</tr>';
*/

		$cuento.= '<tr>';
		$cuento.= '<td>Gracias por su atenci&oacuten</td>';
		$cuento.= '</tr>';
		$cuento.= '</table>';
// echo $cuento;
		return (enviar_email('Informacion sobre pago de Timbre Fiscal', $cuento, true, $archivoimagen, $enviadopor, $respondera , $enviara ) >0);
	}


function hacer_pdf($image, $archivopdf, $destinopdf)
{
//	header('Content-type: application/pdf');
//	require('fpdf/pdf_js.php');
	ob_end_clean();
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

	$alto=10;
	$linea=10;
	$x=10;
	$y=10;
	$ancho=50;
	$alto=50;
	//  echo 'archvi '.$image;
	$pdf->Image($image,$x,$y,$ancho,$alto,jpeg);
	$linea+=$alto;
	$linea=10;
	// $pdf->Output();
	$salida = $destinopdf.'/'.$archivopdf.'.pdf';
	$filed = $pdf->Output($salida, 'F');
	return $salida;
	//	$pdf->Cell(0,6,'x=',0,0,'C');
}
	
	
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
//	$norwayLayer->addLayer(1, $logo, ($ancho-$anchologo), ($alto-$altologo), "LB");
 
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
	// echo 'la fecha '.$registro['fechapago'];
	// echo 'el monto' .$registro['montobs'];
	$blanco = "ffffff"; // "848484"; // fffff";
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
		"fontSize" => 7,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtrif = new ImageWorkshop(array(
		"text" => 'RIF: '.$registro['riftimbre'],
		"fontPath" => "arial.ttf",
		"fontSize" => 8,
		"fontColor" => $negro,
		"textRotation" => 0,
	));
 	$txtrazon = new ImageWorkshop(array(
		"text" => $registro['nombretimbre'],
		"fontPath" => "arial.ttf",
		"fontSize" => 6,
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
	$emis=explode('-',$registro['fechapago']);
	$emis=$emis[2].'/'.$emis[1].'/'.substr($emis[0],2,2);
 	$txtemision = new ImageWorkshop(array(
		"text" => 'Emision: '.$emis . ' Pago#:' .$registro['nroplanilla'],
		"fontPath" => "arial.ttf",
		"fontSize" => 7,
		"fontColor" => $negro,
		"textRotation" => 90,
	));
 	$txtmonto = new ImageWorkshop(array(
		"text" => 'Monto BsF: '.number_format($registro['montobs'],2,'.',''),
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
		"fontSize" => 7,
		"fontColor" => $negro,
		"textRotation" => 270,
	));
	
	
 	$textLayer = new ImageWorkshop(array(
		"text" => 'PARA REVISION',
		"fontPath" => "arial.ttf",
		"fontSize" => 16,
		"fontColor" => $negro,
		"textRotation" => calculAngleBtwHypoAndLeftSide($norwayLayer->getWidth(), $norwayLayer->getHeight()),
	));
 	$txtversion = new ImageWorkshop(array(
		"text" => 'V-1.3',
		"fontPath" => "arial.ttf",
		"fontSize" => 4,
		"fontColor" => $negro,
		"textRotation" => 0,
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
$textLayer->opacity(60);

 
// We add the $textLayer on the norway layer, in its middle
// $norwayLayer->addLayer(1, $txtgober, 0, 10, 'MT');
$norwayLayer->addLayer(1, $txtdir, 20, 10, 'MT');
//
$norwayLayer->addLayer(1, $txtrif, 15, 25, 'LB');
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
// $norwayLayer->addLayer(1, $textLayer, 0, 10, 'MM');
///////
$norwayLayer->addLayer(1, $txtversion, 10, 10, 'LB');
$image = $norwayLayer->getResult();


	 // header('Content-type: image/jpeg');
	 //	 imagejpeg($image, null, 60); 
	$nombreimagen='img-resultado/x'.$idregistro.'.jpg';
	imagejpeg($image,$nombreimagen);
// echo 'nombre de archi '.$nombreimagen;
	return $nombreimagen;
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

?> 
