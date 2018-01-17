<?php

require_once 'datos/ConexionBD.php';

class TimbreFiscal{
const NOMBRE_TABLA = 'timbresfiscales';
const CAMPO_BUSQUEDA = 'unico';

	public function getTF ($uidTF) {
		$command = 'SELECT *' .
			' FROM ' . self::NOMBRE_TABLA . 
			' WHERE ' . self::CAMPO_BUSQUEDA . '=?';
		$sentence = ConexionBD::getInstance()->getDB()->prepare($command);
		$sentence->bindParam(1,$uidTF);
		if($sentence->execute()){
			$result = $sentence->fetch();
			return $result;
		}else return null;	
	}
}
?>