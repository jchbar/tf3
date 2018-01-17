<?php
class classemail
{
/*
	protect $titulo;
	protect $cuento;
	protect $enviar_ip;
	protect $archivoadjunto;
	protect $enviadopor;
	protect $respondera;
	protect $enviara;
*/
	function __construct ($params = array())
	{
		$enviar_ip = true;
		$enviadopor = $respondera = 'juan.hernandez@heros.com.ve';
		$enviara = $titulo = $cuento = 'falta asignar';
        if (array_key_exists("titulo", $params)) {
            $this->titulo = $params["titulo"];
        }

        if (array_key_exists("cuento", $params)) {
            $this->cuento = $params["cuento"];
        }

        if (array_key_exists("enviar_ip", $params)) {
            $this->enviar_ip = $params["enviar_ip"];
        }

        if (array_key_exists("enviadopor", $params)) {
            $this->enviadopor = $params["enviadopor"];
        }
        if (array_key_exists("respondera", $params)) {
            $this->respondera = $params["respondera"];
        }
        if (array_key_exists("enviara", $params)) {
            $this->enviara = $params["enviara"];
        }
		// enviar_email($titulo, $cuento, $enviar_ip, $archivoadjunto, $enviadopor, $respondera, $enviara);

	}
	
	function enviar_email($titulo = 'Asignar asunto', $cuento='Asignar el cuento', $enviar_ip=true, $archivoadjunto='', $enviadopor='juan.hernandez@heros.com.ve', $respondera='juan.hernandez@heros.com.ve', $enviara='' )
	{
		// enviar email
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
		// $titulo = "Factura ".$factura." de HeRos Servicios C.A. \n";
		$separator = md5(time());
		$boundary = $separator;
		$eol = PHP_EOL;

		$cuerpo = "--" . $separator . "\r\n";
		$cuerpo.= "Content-type:text/html; charset=utf-8"."\r\n";
		$cuerpo.= "Content-Transfer-Encoding: 8bit\r\n\r\n";

		$cuerpo.='<html><head><title>'.$titulo.'</title></head><body>';
		$cuerpo.=$cuento;

		if ($enviar_ip == true)
		{
			$cuerpo.='<table><tr>';
			$cuerpo.='<td>Este correo ha sido generado desde la direccion IP </td>';
			$cuerpo.='<td>'.$ip.'</td>';
			$cuerpo.='</tr>';

			$cuerpo.='</table>';

		}

		$cuerpo.='</div></body></html>'.$eol;

		if ($archivoadjunto!='')
		{
	    	$elarchivo=$archivoadjunto;
			$filename=$elarchivo;
			$attachment = chunk_split(base64_encode(file_get_contents($elarchivo)));

			$cuerpo.= "--" . $separator . "\r\n";
			$cuerpo.= "Content-Type: application/octet-stream; name=\"" . $elarchivo. "\"\r\n";
			$cuerpo.= "Content-Transfer-Encoding: base64"."\r\n";
			$cuerpo.= "Content-Disposition: attachment; filename=\"" . $elarchivo. "\"\r\n\r\n";
			$cuerpo.= $attachment . "\r\n\r\n";
			$cuerpo.= "--" . $separator . "--";
		}

	//.................
	# genera el cuerpo del mensaje

		$headers  = "From: ".$enviadopor."\r\n";
		$headers .= "MIME-Version: 1.0"."\r\n";
	    $headers .= "Reply-To: ".$respondera. "\r\n";
		$headers .= "Return-Path: ".$respondera."\r\n";
		// This two steps to help avoid spam   
		$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">"."\r\n";
		$headers .= "X-Mailer: PHP v".phpversion()."\r\n";         
	//		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"\r\n\r\n";
	    // With message

		$to=$enviara;

		echo 'header '.$headers;
		echo '<br>titulo'.$titulo;
		echo '<br>cuerpo'.$cuerpo;
		$ok = mail($to, $titulo, $cuerpo, $headers);
		return $ok;
	}
}

?>
