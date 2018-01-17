<?php
/*  
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
include("head.php");

if (!$link OR !$_SESSION['empresa']) {
	include("noempresa.php");
	exit;
}
	*/

// $link = @mysql_connect("localhost","root", "",'',65536) or die ("<p /><br /><p /><div style='text-align:center'>En estos momentos no hay conexión con el servidor, inténtalo más tarde.</div>");
// mysql_select_db($_POST['sica'], $link);

session_start();
// header('Content-type: application/pdf');
// include("fpdf/a_cookies.php");

extract($_GET);
extract($_POST);
extract($_SESSION);
include("conex.php");

define('FPDF_FONTPATH','fpdf/font/');
require('fpdf/mysql_table.php');
include("fpdf/comunes.php");
// include ("conex.php"); 

$pdf=new PDF('P','mm','Letter');
$pdf->Open();
$pdf->AddPage();

$linea=15;
$pdf->SetY($linea);
$pdf->SetX(0);
$pdf->SetFont('Arial','B',11);
$izquierda=0;
$arriba=0;
$grandederecha=215;
$pdf->Image('fpdf/logo/nf_media.jpg',$izquierda,$arriba,$grandederecha);
$factura=$_GET['factura'];
$comando="SELECT * FROM fact2_encabeza, fact2_clientes WHERE (factura=$factura) and (usuario=codigo)";
$resul1=mysql_query($comando);
$pdf->SetTextColor(255,128,64);
$linea=27;
$pdf->SetY($linea);
$pdf->SetFont('arial','BI',18);
$pdf->SetX(170);
$pdf->Cell(50,0,'000'.$factura,0,0,'L'); 

$linea+=7;
$pdf->SetY($linea);
$pdf->SetFont('arial','BI',14);
$pdf->SetX(165);
$pdf->Cell(50,0,'Factura: '.substr($factura,1,4),0,0,'L'); 

$fila1 = mysql_fetch_assoc($resul1);
$fecha=$fila1['fecha'];
$fecha=explode('-',$fecha);
$fechae=$fecha[2].'/'.$fecha[1].'/'.$fecha[0];
$fechav=$fechae;

$pdf->SetTextColor(0,0,0);
$linea=+45;
$pdf->SetY($linea);
$pdf->SetFont('arial','',9);

$altofila=5;
// $linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(125,($altofila*5),'',1); 
$pdf->SetY($linea);
$pdf->SetX(140);
$pdf->Cell(60,($altofila*5),'',1); 

$pdf->SetY($linea+($altofila*6));
$pdf->SetX(15);
$pdf->Cell(185,($altofila),'',1); 

$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(150,$altofila,'RAZON SOCIAL :'.$fila1['nombre'],0,0,'L',0); 
$correo=$fila1['email'];
$pdf->SetY($linea+$altofila);
$pdf->SetX(150);
$pdf->Cell(50,0,'FECHA EMISION : '.$fechae,0,0,'R'); 

$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(40,$altofila,'R.I.F.'.$fila1['rif'],0,0,'L',0); 
$pdf->SetY($linea+$altofila);
$pdf->SetX(150);
$pdf->Cell(50,0,'FECHA VENCIMIENTO : '.$fechav,0,0,'R'); 

$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(200,$altofila,'DIRECCION : '.$fila1['direccion1'],0,0,'L',0); 
$pdf->SetY($linea+$altofila);
$pdf->SetX(150);
$pdf->Cell(50,0,'CONDICION : CONTADO',0,0,'R'); 

$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(150,$altofila,$fila1['direccion2'],0,0,'L',0); 

$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetX(15);
$pdf->Cell(80,$altofila,'TELEFONO(S) :'.$fila1['telefono'],0,0,'L',0); 

$comando="SELECT * FROM fact2_detallef WHERE (numero=$factura) order by item";
$resul1=mysql_query($comando);

$linea+=$altofila;
$linea+=$altofila;
$pdf->SetY($linea);

//Cabecera
//$header=array('Nro Item','Cantidad','Descripcion','Descuento','Precio Unit.','SubTotal');
$header=array('Cantidad','Descripcion','Precio Unitario','SubTotal');
$w=array(20,120, 33, 45);
$p=array(15, 35,120,150);
for($j=0;$j<count($header);$j++)  {
	$pdf->SetX($p[$j]);
    $pdf->Cell($w[$j],$altofila,$header[$j],0,0,'C',0); 
}

$items=0;
while ($fila1 = mysql_fetch_assoc($resul1)) {
	imprimir($fila1, $linea, $p, $w, $altofila, $pdf, $total, $total2);
	$total+=$fila1['monto']*$fila1['cantidad'];
	$items++;
}
$faltan=4-$items;
// $linea+=($faltan*$altofila);
// $linea+=$altofila;
$concuadro=0;
$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',9);
// $pdf->SetX($p[0]);
//  $pdf->Cell($w[0]+$w[1]+$w[2],$altofila,'Total',$concuadro,0,'R',0);
$pdf->SetX($p[2]);
$pdf->Cell($w[2],$altofila,'Base Imponible : ',$concuadro,0,'R',0);
$pdf->SetX($p[3]);
$pdf->Cell($w[3],$altofila,number_format($total,2,'.',','),$concuadro,0,'R',0);
$linea+=$altofila;
$pdf->SetY($linea);
$iva=12;
$eliva=$total*0.12;
$pdf->SetY($linea);
$pdf->SetFont('Arial','',9);
$pdf->SetX($p[2]);
$pdf->Cell($w[2],$altofila,'I.V.A. :'.number_format($iva,2,'.',','),$concuadro,0,'R',0);
$pdf->SetFont('Arial','B',9);
$pdf->SetX($p[3]);
$pdf->Cell($w[3],$altofila,number_format($eliva,2,'.',','),$concuadro,0,'R',0);
$linea+=$altofila;
$pdf->SetY($linea);
$pdf->SetFont('Arial','B',9);
$pdf->SetX($p[2]);
$pdf->Cell($w[2],$altofila,'Total Factura : ',$concuadro,0,'R',0);
$pdf->SetX($p[3]);
$pdf->Cell($w[3],$altofila,number_format($total+$eliva,2,'.',','),$concuadro,0,'R',0);

$generar='lospdf/'.$factura.'.pdf';
$pdf->Output('lospdf/'.$factura.'.pdf');


	// enviar email
	$ip = $_SERVER['HTTP_CLIENT_IP'];
	if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
	$titulo = "Factura ".$factura." de HeRos Servicios C.A. \n";
	$separator = md5(time());
	$boundary = $separator;
	$eol = PHP_EOL;

//    $cuerpo .= $message.$eol;


//.................
//	$cuerpo="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"es-ES\" lang=\"es\">";

	$cuerpo = "--" . $separator . "\r\n";
	$cuerpo.= "Content-type:text/html; charset=utf-8"."\r\n";
//	$cuerpo.= "Content-Type: text/html; charset=iso-8859-1"."\r\n";
	$cuerpo.= "Content-Transfer-Encoding: 8bit\r\n\r\n";

	$cuerpo.='<html><head><title>'.$titulo.'</title></head><body>';
	$cuerpo.='<div align="center">';
	$cuerpo.='<table width="390" border="0" cellspacing="1" cellpadding="1" summary="sumario aqui">';
	$cuerpo.='<caption>';
	$cuerpo.='<br />';
	$cuerpo.='</caption>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<td colspan="2"><div align="center">Factura '.$factura.' de Heros Servicios C.A</div></td>';
	$cuerpo.='</tr>';
	$cuerpo.='<td colspan="2"><div align="center">Favor realizar transferencia a alguna de nuestras cuentas en las entidades</div></td>';
	$cuerpo.='</tr>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<td colspan="2"><div align="center"><strong>Banco Provincial Cuenta Corriente Nro. 0108-0906-11-0100017577</strong></div></td>';
	$cuerpo.='</tr>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<td colspan="2"><div align="center"><strong>Banco Bicentenario Cuenta Corriente Nro. 0175-0050-39-0071308775</strong></div></td>';
	$cuerpo.='</tr>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<br></tr>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<td colspan="2"><div align="center">Al realizar el pago favor notificarlo en el siguiente enlace </div></td>';
	$cuerpo.='</tr>';
	$cuerpo.='<tr class="caja_texto">';
	$cuerpo.='<td colspan="2"><div align="center">';
	//www.facturador.heros.com.ve/
	$cuerpo.="<a target=\"_blank\" href=\"recibirpago.php?factura=$factura&validar=".base64_encode(trim($factura))."\">Notificar Pago</a>. <br>Si al hacer clic en el link parece que esta roto o no funciona, por favor, copie esto: <br><strong>www.facturador.heros.com.ve/recibirpago.php?factura=".$factura."&validar=".base64_encode(trim($factura))."&</strong><br> y peguelo en una ventana de navegador nueva. <br>Por favor no responda a este mensaje. <br>En caso de que se le presente alguna duda o inquietud, puede contactarnos a traves de la direccion electronica juan.hernandez@heros.com.ve<br></div></td>'";
//	$cuerpo.="<a target=\"_blank\" href=\"www.facturador.heros.com.ve/recibirpago.php?factura=$factura&validar=".base64_encode(trim($factura))."&\" onClick=(\"info.html\', \'\',\'width=250, height=190\')\">Notificar Pago</a>. Si al hacer clic en el link parece que esta roto o no funciona, por favor, copie esto: <br><strong>www.facturador.heros.com.ve/recibirpago.php?factura=".$factura."&validar=".base64_encode(trim($factura))."&</strong><br> y peguelo en una ventana de navegador nueva. <br>Por favor no responda a este mensaje. <br>En caso de que se le presente alguna duda o inquietud, puede contactarnos a traves de la direccion electronica juan.hernandez@heros.com.ve<br></div></td>'";

	$cuerpo.='</tr>';

	$cuerpo.='<td>Este correo ha sido generado desde la direccion IP </td>';
	$cuerpo.='<td>'.$ip.'</td>';
	$cuerpo.='</tr>';

	$cuerpo.='</table>';
															$cuerpo.='</div></body></html>'.$eol;

// echo $cuerpo;
    // adjunto
   
    	$elarchivo="lospdf/".$factura.".pdf";
	$filename=$elarchivo;
	$attachment = chunk_split(base64_encode(file_get_contents($elarchivo)));

	
	$cuerpo.= "--" . $separator . "\r\n";
	$cuerpo.= "Content-Type: application/octet-stream; name=\"" . $elarchivo. "\"\r\n";
	$cuerpo.= "Content-Transfer-Encoding: base64"."\r\n";
	$cuerpo.= "Content-Disposition: attachment; filename=\"" . $elarchivo. "\"\r\n\r\n";
	$cuerpo.= $attachment . "\r\n\r\n";
	$cuerpo.= "--" . $separator . "--";
    

//.................
	
	# genera el cuerpo del mensaje


		$headers  = "From: juan.hernandez@heros.com.ve"."\r\n";
		$headers .= "MIME-Version: 1.0"."\r\n";
	        $headers .= "Reply-To: juan.hernandez@heros.com.ve" . "\r\n";
		$headers .= 'Return-Path: juan.hernandez@heros.com.ve'."\r\n";
        // This two steps to help avoid spam   
		$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">"."\r\n";
		$headers .= "X-Mailer: PHP v".phpversion()."\r\n";         
//		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"\r\n\r\n";
        // With message

	       $to='jchbar@cantv.net, juan.hernandez@heros.com.ve, familiahernandezrosales@hotmail.com, '.$correo;
//	       $to='juan.hernandez@heros.com.ve';
	       
	$ok = mail($to, $titulo, $cuerpo, $headers);
// $ok=enviar_correo($to, $titulo, $cuerpo, 'info@heros.com.ve', 'Administracion HeRos Servicios C.A.', 'lospdf',$factura.".pdf");
		echo ' ok '.$ok;
   
		if($ok) { 
			echo "<font face=verdana size=2><center>Correo enviado<br><br>";
			echo '<form action="menu.php" method="post" name="form1" target="_parent" id="form1">';
			echo '<input name="regresar" type="submit" class="boton"  value="Regresar" />  ' ;
			echo '</form>';

		} 
		else { 
		echo "Lo sentimos pero el correo no pudo ser enviado. Por favor regrese y vuelve a intentarlo!";
		} 
//	}


function imprimir($registro, &$linea, $p, $w, $altofila = 5, $pdf, $total, $total2)
{

$cuadro=0;
	$linea+=$altofila;
	$pdf->SetY($linea);
	$pdf->SetX($p[0]);
//	$pdf->Cell($w[0],$altofila,$registro['item'],$cuadro,0,'C',1);
//	$pdf->SetX($p[1]);
	$pdf->Cell($w[0],$altofila,''.number_format($registro['cantidad'],2,'.',','),$cuadro,0,'R',0);

	$pdf->SetX($p[1]);
	$pdf->Cell($w[1],$altofila,''.$registro['descripcion'],$cuadro,0,'L',0);

//	$pdf->SetX($p[3]);
//	$pdf->Cell($w[3],$altofila,''.number_format($registro['descuento'],2,'.',','),$cuadro,0,'R',0);

	$pdf->SetX($p[2]);
	$pdf->Cell($w[2],$altofila,''.number_format($registro['monto'],2,'.',','),$cuadro,0,'R',0);

	$pdf->SetX($p[3]);
	$pdf->Cell($w[3],$altofila,''.number_format($registro['monto']*$registro['cantidad'],2,'.',','),$cuadro,0,'R',0);
	$total+=$registro['monto']*$registro['cantidad'];
}

function convertir_fechadmy($mifecha)
{
//	$mifecha=strtotime($mifecha);
//	echo $mifecha;
	$a=explode("-",$mifecha); 
	$elano=substr($a[0],0,2);
	if ($elano="20") $b=$a[2]."/".$a[1]."/".$a[0];
	else $b=$a[2]."/".$a[1]."/"."20".$a[0];
//	if ($elano="20") $b=(($a[2]<10)?'0'.$a[2]:$a[2])."/".(($a[1]<10)?'0'.$a[1]:$a[1])."/".$a[0];
//	else $b=$b=(($a[2]<10)?'0'.$a[2]:$a[2])."/".(($a[1]<10)?'0'.$a[1]:$a[1])."/"."20".$a[0];
	if ($mifecha=='--') $b='00/00/0000';
return $b;
}

function convertir_fecha($mifecha)
{
//	echo $mifecha;
	$a=explode("/",$mifecha); 
	$elano=substr($a[0],0,2);
// 	if ($elano="20") $b=$a[2]."-".$a[1]."-".$a[0];
//	echo 'a1 '.($a[1] < 10).'<br>'; 
	if ($elano="20") $b=$a[2].'-'.(($a[1]<10)?'0'.$a[1]:$a[1])."-".(($a[0]<10)?'0'.$a[0]:$a[0]);
	else $b="20".$a[2]."-".(($a[1]<10)?'0'.$a[1]:$a[1])."-".(($a[0]<10)?'0'.$a[0]:$a[0]);
	if ($mifecha=='//') $b='0000-00-00';
return $b;
}

function enviar_correo($destinatarios, $mail_asunto, $mail_contendio, $from, $from_name, $archivos_adjuntos_ruta,$archivos_adjuntos_temp){
$mail= new PHPMailer(); // defaults to using php "mail()"
$mail->CharSet = 'UTF-8';
$body= $mail_contendio;
$mail->IsSMTP(); // telling the protocol to use SMTP
$mail->Host = "www.heros.com.ve"; // SMTP server
$mail->From = $from;
$mail->FromName = $from_name;
$mail->Subject = $mail_asunto;
$mail->MsgHTML($body);
$destinatarios=explode(",", $destinatarios);
if(!empty($destinatarios)){
foreach($destinatarios as $un_destinatario){
$mail->AddAddress($un_destinatario); //destinatarios
}
}else{
return false;
}
if(!empty($archivos_adjuntos_ruta)){
foreach($archivos_adjuntos_ruta as $archivo){
$mail->AddAttachment($archivo); // attachment
}
}
if(!empty($archivos_adjuntos_temp)){
foreach($archivos_adjuntos_temp as $nombrearchivo=>$contenidoArchivo){
$mail->AddStringAttachment($contenidoArchivo,$nombrearchivo,'base64');
}
}
$mail->Timeout = 20;
if($mail->Send()) {
return array(true);
}else {
return array(false,"Mailer Error: ".$mail->ErrorInfo);
}
}
?> 

