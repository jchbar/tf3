<?php

    include_once 'final.php';
					include_once('classbasededatos.php');
					$con = new classbasededatos();
					$con->conectar();

    if (isset($_POST['password_change'])) {

        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['old_password']);
        $newpassword = strip_tags($_POST['new_password']);
        $confirmnewpassword = strip_tags($_POST['con_newpassword']);

        // match username with the username in the database
        $sql = "SELECT * FROM ingreso_usuario WHERE `email` = '".$username."' LIMIT 1";
echo $sql;
/*
        $query = $dbh->prepare($sql);
        $query->bindParam(1, $username, PDO::PARAM_STR);
*/
  //      if($query->execute() && $query->rowCount()){
		$res=$con->consulta($sql); 
		if ($con->num_rows($res) > 0 ) {
            $hash = $con->fetch_assoc($res); // $query->fetch();
            if ($password == $pwd['clave']){
                if($newpassword == $confirmnewpassword) {
//                    $sql = "UPDATE `ingreso_usuario` SET `clave` = MD5('".$confirmnewpassword."') WHERE `username` = ?";
                    $sql = "UPDATE `ingreso_usuario` SET `clave` = MD5('".$confirmnewpassword."') WHERE `username` = '".$username."'";
echo $sql;
/*
                    $query = $dbh->prepare($sql);
                    $query->bindParam(1, $newpassword, PDO::PARAM_STR);
                    $query->bindParam(2, $username, PDO::PARAM_STR);
*/
                    if($query->execute()){
                        echo "Password Changed Successfully!";
                    }else{
                        echo "Password could not be updated";
                    }
                } else {
                    echo "Passwords do not match!";
                }
            }else{
                echo "Please type your current password accurately!";
            }
        }else{
            echo "Incorrect username";
        }
    }

?>