<?php
	class classbasededatos
	{
		var $host;
		var $user;
		var $db;
		var $pwd;
		var $conexion;
	
	function __construct()
	{
		include ('final.php');
		$this->host=$Servidor;
		$this->user=$Usuario;
		$this->db=$bdd;
		$this->pwd=$Password;
	}
	
	function conectar()
	{
		$this->conexion = mysql_connect($this->host, $this->user, $this->pwd);
		mysql_select_db($this->db, $this->conexion);
	}
	
	function execute_query($query)
	{
		return mysql_query($query);
	}
	
	function limpiar($query)
	{
		return mysql_real_escape_string($query);
	}
	function consulta($query)
	{
		// $query=mysql_real_escape_string($query);
		return mysql_query($query);
	}
	
	function fetch_assoc($result)
	{
		return mysql_fetch_assoc($result);
	}
	
	function num_rows($result)
	{
		return mysql_num_rows($result);
	}
	
	function desconectar()
	{
		mysql_close($this->conexion);
	}
}
?>
