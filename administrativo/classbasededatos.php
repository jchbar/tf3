<?php
session_start();
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
		$this->guardar_bitacora($query);
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

	function ahora()
	{
		$fechactual="select now() as hoy";
		$fechactual=mysql_query($fechactual);
		$fechactual=mysql_fetch_assoc($fechactual);
		$fechactual=$fechactual['hoy'];
		return $fechactual;
	}

	function guardar_bitacora($consulta)
	{
		$ahora=$this->ahora();
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		if (!$ip) {$ip = $_SERVER['REMOTE_ADDR'];}
		
		$gb="insert into bitacora (fecha, usuario, ipseguimiento, actividad) values ('".$ahora."', '".$_SESSION['usuario_sistema']."', '$ip', '".$this->limpiar($consulta)."')";
		// echo $gb;
		$this->execute_query($gb);
	}
	
	function generateFormToken($form) { 
	   // generar token de forma aleatoria
	   $token = md5(uniqid(microtime(), true));
	   // generar fecha de generación del token
	   $token_time = time();
	   // escribir la información del token en sesión para poder
	   // comprobar su validez cuando se reciba un token desde un formulario
	   $_SESSION['csrf'][$form.'_token'] = array('token'=>$token, 'time'=>$token_time);; 
	   return $token;
	}
	
	function verifyFormToken($form, $token, $delta_time=0) {	 
	   // comprueba si hay un token registrado en sesión para el formulario
	   if(!isset($_SESSION['csrf'][$form.'_token'])) {
		   return false;
	   }
	 
	   // compara el token recibido con el registrado en sesión
	   if ($_SESSION['csrf'][$form.'_token']['token'] !== $token) {
		   return false;
	   }
	 
	   // si se indica un tiempo máximo de validez del ticket se compara la
	   // fecha actual con la de generación del ticket
	   if($delta_time > 0){
		   $token_age = time() - $_SESSION['csrf'][$form.'_token']['time'];
		   if($token_age >= $delta_time){
		  return false;
		   }
	   }
	   return true;
	}
	
	function mensaje_alerta($titulo, $mensaje, $tipo)
	{
		echo '<div class="alert alert-'.$tipo.'" role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		echo '<strong>'.$titulo.'</strong> <br>';
		echo $mensaje;
		echo '</div>';
	}
	
	function obtener_enviadopor($conexion)
	{
		$buscar="select * from configuracion where nombreparametro = 'mailenviadopor'";
		$resb=$conexion->consulta($buscar);
		$enviadopor = $conexion->fetch_assoc($resb);
		$enviadopor = $enviadopor['valorparametro'];
		return $enviadopor;
	}

	function obtener_respondera($conexion)
	{
		$buscar="select * from configuracion where nombreparametro = 'responderemail'";
		$resb=$conexion->consulta($buscar);
		$respondera = $conexion->fetch_assoc($resb);
		$respondera = $respondera['valorparametro'];
		return $respondera;
	}

	function obtener_dirweb($conexion)
	{
		$buscar="select * from configuracion where nombreparametro = 'direccionweb'";
		$resb=$conexion->consulta($buscar);
		$dirweb = $conexion->fetch_assoc($resb);
		$dirweb = $dirweb['valorparametro'];
		return $dirweb;
	}

	function strToHex($string){
		$hex='';
		for ($i=0; $i < strlen($string); $i++){
			$hex .= dechex(ord($string[$i]));
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
	
	function convertir_fechadmy($mifecha)
	{
		$a=explode("-",$mifecha); 
		$elano=substr($a[0],0,2);
		if ($elano="20") $b=$a[2]."/".$a[1]."/".trim($a[0]);
		else $b=$a[2]."/".$a[1]."/"."20".trim($a[0]);
		if ($mifecha=='--') $b='00/00/0000';
		return $b;
	}

}
?>
