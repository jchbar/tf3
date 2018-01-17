<?php

require_once 'login_mysql.php';

//Conexion con la base de datos basada en el patron singleton
class ConexionBD
{
	private static $db = null;
	private static $pdo;
	
	final private function __construct()
	{
		try{
			self::getDB();
		}catch (PDOException $e){
		}
	}
	public static function getInstance()
	{
		if (self::$db == null){
			self::$db = new self();
		}
		return self::$db;
	}
	public static function getDB()
	{
		if (self::$pdo == null){
			self::$pdo = new PDO('mysql:host=' . NOMBRE_HOST . ';dbname=' . BASE_DE_DATOS, 
			USUARIO,
			CONTRASENA,
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		return self::$pdo;
	}
	final protected function __clone()
	{
	}
	function _destructor()
	{
		self::$pdo = null;
	}
}
?>