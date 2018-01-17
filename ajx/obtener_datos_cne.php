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

include("conex.php");
$cedula=$_GET['cedula'];
$factor=$_GET['factor'];
$nacionalidad=$_GET['nacionalidad'];
class SearchCurl {

    /**
     * Permite consumir e interpretar la informacion del resultado del curl para solo extraer los datos necesarios
     * @author Gregorio Jose Bolivar Bolivar <elalconxvii@gmail.com>
     * @param string $nac Nacionalidad de la persona
     * @param integer $ci Cedula de la persona
     * @return string Json del resultado consultado de los datos asociados a la persona
     */
    public static function SearchCNE($nac, $ci) {
        $url = "http://www.cne.gov.ve/web/registro_electoral/ce.php?nacionalidad=$nac&cedula=$ci";
        $resource = self::geUrl($url);
        $text = strip_tags($resource);
        $findme = 'SERVICIO ELECTORAL'; // Identifica que si es población Votante
        $pos = strpos($text, $findme);

        $findme2 = 'ADVERTENCIA'; // Identifica que si es población Votante
        $pos2 = strpos($text, $findme2);

        if ($pos == TRUE AND $pos2 == FALSE) {
            // Codigo buscar votante
            $rempl = array('Cédula:', 'Nombre:', 'Estado:', 'Municipio:', 'Parroquia:', 'Centro:', 'Dirección:', 'SERVICIO ELECTORAL', 'Mesa:');
            $r = trim(str_replace($rempl, '|', self::limpiarCampo($text)));
            $resource = explode("|", $r);
            $datos = explode(" ", self::limpiarCampo($resource[2]));
            $datoJson = array('error' => 0, 'nacionalidad' => $nac, 'cedula' => $ci, 'nombres' => $datos[0] . ' ' . $datos[1], 'apellidos' => $datos[2] . ' ' . $datos[3], 'inscrito' => 'SI', 'cvestado' => self::limpiarCampo($resource[3]), 'cvmunicipio' => self::limpiarCampo($resource[4]), 'cvparroquia' => self::limpiarCampo($resource[5]), 'centro' => self::limpiarCampo($resource[6]), 'direccion' => self::limpiarCampo($resource[7]));
        } elseif ($pos == FALSE AND $pos2 == FALSE) {
            // Codigo buscar votante
            $rempl = array('Cédula:', 'Primer Nombre:', 'Segundo Nombre:', 'Primer Apellido:', 'Segundo Apellido:', 'ESTATUS');
            $r = trim(str_replace($rempl, '|', $text));
            $resource = explode("|", $r);
            $datoJson = array('error' => 0, 'nacionalidad' => $nac, 'cedula' => $ci, 'nombres' => self::limpiarCampo($resource[2]) . ' ' . self::limpiarCampo($resource[3]), 'apellidos' => self::limpiarCampo($resource[4]) . ' ' . self::limpiarCampo($resource[5]), 'inscrito' => 'NO');
        } elseif ($pos == FALSE AND $pos2 == TRUE) {
            $datoJson = array('error' => 1, 'nacionalidad' => $nac, 'cedula' => $ci, 'nombres' => NULL, 'apellidos' => NULL, 'inscrito' => 'NO');
        }
//        echo json_encode($datoJson);
/*
echo 'rs3'.$resource[3];
echo 'rs4'.$resource[4];
echo 'rs5'.$resource[5];
*/
	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
	echo utf8_encode("<nombre>".$datos[0] . ' ' . $datos[1]."</nombre>");
	echo utf8_encode("<apellido>".$datos[2] . ' ' . $datos[3]."</apellido>");
	$estado=$resource[3];
	$punto=strpos($estado,".")+2;
	$tam=strlen(trim($estado));
	$estado=substr($estado,$punto,($tam-$punto));
	echo utf8_encode("<estado>".$estado."</estado>");

	$estado=$resource[4];
	$punto=strpos($estado,".")+2;
	$tam=strlen(trim($estado));
	$estado=substr($estado,$punto,($tam-$punto));
	echo utf8_encode("<lmunicipio>".$estado."</lmunicipio>");

	$estado=$resource[5];
	$punto=strpos($estado,".")+2;
	$tam=strlen(trim($estado));
	$estado=substr($estado,$punto,($tam-$punto));
	echo utf8_encode("<parroquia>".$estado."</parroquia>");
	echo utf8_encode("<obtencion_local>0</obtencion_local>");
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

$cedulafactor=$nacionalidad.'-'.$cedula.'-'.$factor;
// $sql="select * from usr_prf where cedula = '$cedula' and factor = '$factor'";
$sql="select * from usr_prf where cedulafactor = '$cedulafactor'";
$result=mysql_query($sql);
if (mysql_num_rows($result)>0)
{
	$datos=mysql_fetch_assoc($result);
	$nace=explode('-',$datos['fecha_nacimiento']);
	$nace=$nace[2].'/'.$nace[1].'/'.$nace[0];
	$registro=explode('-',$datos['fecha_registro']);
	$registro=$registro[2].'/'.$registro[1].'/'.$registro[0];
	$ciudad=$datos['codigo_ciudad'];
	$sqlc="select * from ciudades where codigo_ciudad = '$ciudad' order by nombre_ciudad";
	$resc=mysql_query($sqlc);
	$ciudad=mysql_fetch_assoc($resc);
	$ciudad=$datos['codigo_ciudad']; // .'-'.$ciudad['nombre_ciudad'];
	
	$instituto=$datos['codigo_institucion_estudiante'];
	$sqlc="select * from planteles where codigo_plantel='$instituto' order by nombre_plantel";
	$resc=mysql_query($sqlc);
	$instituto=mysql_fetch_assoc($resc);
	$instituto=$instituto['nombre_plantel'];
/*
	if (($instituto=="") and ($datos['tipo_preferencial']='0002'))
	{
		$sqlc="select * from planteles order by nombre_plantel limit 1";
		$resc=mysql_query($sqlc);
		$instituto=mysql_fetch_assoc($resc);
		$instituto=$instituto['nombre_plantel'];
	}
*/

	header("Content-Type: text/xml");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo "<resultados>";
	echo utf8_encode("<nombre>".$datos['nombres']."</nombre>");
	echo utf8_encode("<apellido>".$datos['apellidos']."</apellido>");
	echo utf8_encode("<estado>".($datos['estado']==""?' ':$datos['estado'])."</estado>");
	echo utf8_encode("<fecha_registro>".$registro."</fecha_registro>");
	echo utf8_encode("<fecha_nacimiento>".$nace."</fecha_nacimiento>");
	echo utf8_encode("<telefono>".($datos['telefono']==""?' ':$datos['telefono'])."</telefono>");
	echo utf8_encode("<sexo>".($datos['sexo']==""?"Masculino":$datos['sexo'])."</sexo>");
	echo utf8_encode("<censado>".($datos['censado']==""?' ':$datos['censado'])."</censado>");
	echo utf8_encode("<ciudad>".$ciudad."</ciudad>");
	echo utf8_encode("<municipio>".$datos['municipio']."</municipio>");
	echo utf8_encode("<parroquia>".$datos['parroquia']."</parroquia>");
	echo utf8_encode("<sector>".$datos['sector']."</sector>");
	if ($datos['tipo_preferencial'] == 'ANCIANO')
		echo utf8_encode("<tipo_preferencial>TERCERA EDAD</tipo_preferencial>");
	else 
	echo utf8_encode("<tipo_preferencial>".$datos['tipo_preferencial']."</tipo_preferencial>");
	echo utf8_encode("<codigo_institucion_estudiante>".($instituto==""?' ':$instituto)."</codigo_institucion_estudiante>");
	echo utf8_encode("<numero_carnet_discapacitado>".($datos['numero_carnet_discapacitado']==""?' ':$datos['numero_carnet_discapacitado'])."</numero_carnet_discapacitado>");
	echo utf8_encode("<nivel_estudios_estudiante>".($datos['nivel_estudios_estudiante']==""?' ':$datos['nivel_estudios_estudiante'])."</nivel_estudios_estudiante>");
	echo utf8_encode("<identificador_tarifa>".($datos['identificador_tarifa']==""?' ':$datos['identificador_tarifa'])."</identificador_tarifa>");
	echo utf8_encode("<obtencion_local>1</obtencion_local>");
	echo "</resultados>";
}
else 
{
	//la de arriba es la clase, y esta parte es como se aplica
	$curls = new SearchCurl();
	$curls->SearchCNE($nacionalidad, $cedula);
}
?>

