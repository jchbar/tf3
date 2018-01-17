<?php
/**
 *   https://bitbucket.org/gbolivar_/searchcne/src/21d60eec7b6ee2cce5d0e6b5a9d5622b4c5dbd2b/getCNE.php?at=master
 * Clase encargada de gestionar diferentes paginas mediantes consumo sea por curl
 * hay que tener claro que podemos ejercer el consumo del html en caso que alla un cambio del resultado del
 * html del CNE hay que modificar las clases porque cambian las posiciones
 */
session_start();
extract($_GET);
extract($_POST);
extract($_SESSION);
class SearchCurl {
    /**
     * Permite consumir e interpretar la informacion del resultado del curl para solo extraer los datos necesarios
     * @author Gregorio Jose Bolivar Bolivar <elalconxvii@gmail.com>
     * @param string $nac Nacionalidad de la persona
     * @param integer $ci Cedula de la persona
     * @return string Json del resultado consultado de los datos asociados a la persona
     */
    public static function SearchCNE($rif) {
	   $url="http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=".$_GET['rif'];
        $resource = self::geUrl($url);
        //$text = strip_tags($resource);
/*
         // Codigo buscar votante
            $rempl = array('Cédula:', 'Primer Nombre:', 'Segundo Nombre:', 'Primer Apellido:', 'Segundo Apellido:', 'ESTATUS');
            $r = trim(str_replace($rempl, '|', $text));
            $resource = explode("|", $r);
            $datoJson = array('error' => 0, 'nacionalidad' => $nac, 'cedula' => $ci, 'nombres' => self::limpiarCampo($resource[2]) . ' ' . self::limpiarCampo($resource[3]), 'apellidos' => self::limpiarCampo($resource[4]) . ' ' . self::limpiarCampo($resource[5]), 'inscrito' => 'NO');
        } elseif ($pos == FALSE AND $pos2 == TRUE) {
            $datoJson = array('error' => 1, 'nacionalidad' => $nac, 'cedula' => $ci, 'nombres' => NULL, 'apellidos' => NULL, 'inscrito' => 'NO');
        }
        echo json_encode($datoJson);
*/
/*
echo 'rs3'.$resource[3];
echo 'rs4'.$resource[4];
echo 'rs5'.$resource[5];
*/
        echo $text;
		header("Content-Type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo "<resultados>";
		echo utf8_encode("<nombre>".$datos[0]."</nombre>");
		echo "</resultados>";
    }

    /**
     * Permite consultar cualquier pagina mediante curl
     * @author Gregorio Jose Bolivar Bolivar <elalconxvii@gmail.com>
     * @param string $url url al cual desea consultar
     * @return string HTML del resultado consultado
     */
    public static function geUrl($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // almacene en una variable
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if (curl_exec($curl) === false) {
            echo 'Curl error: ' . curl_error($curl);
        } else {
            $return = curl_exec($curl);
        }
        curl_close($curl);

        return $return;
    }

    /**
     * Permite limpiar los valores del renorno del carro (\n \r \t) 
     * @author Gregorio Jose Bolivar Bolivar <elalconxvii@gmail.com>
     * @param string $valor Valor que queremos limpiar de caracteres no permitidos
     * @return string Te devuelve los mismo valores pero sin los valores del renorno del carro
     */
    public static function limpiarCampo($valor) {

        $rempl = array('\n', '\t');
        $r = trim(str_replace($rempl, ' ', $valor));
        return str_replace("\r", "", str_replace("\n", "", str_replace("\t", "", $r)));
    }
}



	//la de arriba es la clase, y esta parte es como se aplica
	$curls = new SearchCurl();
	$curls->SearchCNE($rif);
?>

