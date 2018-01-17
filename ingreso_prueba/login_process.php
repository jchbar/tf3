<?php
	session_start();
	include_once('ClassCrud.php');
	$crud = new ClassCrud();
echo 'lleguw';
	if(isset($_POST['btn-login']))
	{
		//$user_name = $_POST['user_name'];
		$user_email = trim($_POST['nombre_usuario']);
		$user_password = trim($_POST['password']);
		
		$password = md5($user_password);
		$password = ($user_password);
		echo 'clave '.$password;
		
		try
		{	
		
			/*
			$stmt = $db_con->prepare("SELECT * FROM sgcapass WHERE user_email=:email");
			$stmt->execute(array(":email"=>$user_email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			*/
			$comando="SELECT * FROM usuarios WHERE '$user_email'=email and MD5('$password')=password";
			// echo $comando;
			$res=$con->consulta($comando); // mysql_query($comando) or die(mysql_error($res). ' - '.$comando);
			$row=$con->fetch_assoc($res);
			// if($row['user_password']==$password){
			if($con->num_rows($res) > 0){
				
				echo "ok"; // log in
				$_SESSION['user_session'] = $row['email'];
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