<?php
    // $rif='J400102464'; // 
	// $rif='J310029539';
	extract($_GET);

    $url="http://contribuyente.seniat.gob.ve/BuscaRif/BuscaRif.jsp?p_rif=$rif"; // no funciona
	$url="http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=$rif"; 
//	echo $url;
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // almacene en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

/*
    $xxx1 = curl_exec($ch);
    curl_close($ch);
    // Separamos el resultado en un arreglo y dividirlo por \n\r\n
    $xxx = explode("\n\r\n", $xxx1);
    // Con este comando podemos ver toda la pantalla de seniat impresa por reglones de arreglos
    // print_r($xxx);
    // Impreme el rif y la razon social
    print_r($xxx[6]);
*/	
	$xxx1 = curl_exec($ch);
    curl_close($ch);
    // Separamos el resultado en un arreglo y dividirlo por \n\r\n
    // $xxx = explode("\n\r\n", $xxx1);
	$xxx = explode("\r", $xxx1);
    // Con este comando podemos ver toda la pantalla de seniat impresa por reglones de arreglos
    // print_r($xxx);
    // Impreme el rif y la razon social
    // print_r($xxx[6]);
	foreach($xxx as $key => $node) {
			print($key. ' '.$node).'<br>';
          // $index = strtolower($node->getName());
          // $seniat[$index] = (string)$node;
	}
    print_r($xxx[8]);
	// header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
	echo utf8_encode("<code_result>".$xxx[0] . ' ' . $datos[1]."</code_result>");
	echo utf8_encode("<message>".$xxx[7] . ' ' . $datos[1]."</message>");
	echo utf8_encode("<nombre>".$seniat[0]."</nombre>");
	echo utf8_encode("<agenteretensioniva>".$seniat[1]."</agenteretensioniva>");
	echo utf8_encode("<contribuyenteiva>".$seniat[2]."</contribuyenteiva>");
	echo utf8_encode("<tasa>".$seniat[3]."</tasa>");
//	echo utf8_encode("<obtencion_local>0</obtencion_local>");
	echo "</resultados>";

	?>
