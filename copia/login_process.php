<?php
	session_start();
	include_once('ClassBasedeDatos.php');
	$crud = new ClassBasedeDatos();
	if(isset($_POST['btn-login']))
	{
		//$user_name = $_POST['user_name'];
		$user_email = trim($_POST['nombre_usuario']);
		$user_password = trim($_POST['password']);
		
		$password = md5($user_password);
		$password = ($user_password);
		
		try
		{	
		
			/*
			$stmt = $db_con->prepare("SELECT * FROM sgcapass WHERE user_email=:email");
			$stmt->execute(array(":email"=>$user_email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			*/
			$comando="SELECT * FROM usuarios WHERE '$user_email'=email and MD5('$password')=klave";
			 // echo $comando;
			$crud->conectar();
			$res=$crud->consulta($comando); // mysql_query($comando) or die(mysql_error($res). ' - '.$comando);
			$row=$crud->fetch_assoc($res);
			// if($row['user_password']==$password){
			if($crud->num_rows($res) > 0){
				
				echo "ok"; // log in
				$_SESSION['rif'] = $row['rif_usuario'];
			}
			else{
				
				echo "Nombre de usuario o clave inv&aacute;lida"; // wrong details 
			}
				
		}
		catch(PDOException $e){
			/* echo $e->getMessage();*/
			echo 'Algo ha fallado!';
		}
	}

?>