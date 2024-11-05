<?php
    function login($conn,$usuario,$password){
		$password=md5($password);
        $stmt 	= $conn->prepare("SELECT * FROM login WHERE usuario=? AND password=?");
		$stmt->bind_param("ss",$usuario,$password);
		if ($stmt->execute()) {
        	$row["status"]   =  $stmt->fetch();
			if($row["status"]){
				$row["usuario"]   =  $usuario;
				$row["password"]  =  $password;
			}else{
				$row["status"]   =  false;
			}
        	$row       		 =  json_encode($row,UTF8);
        	return $row;
		}else{
			$row["status"]   =  false;
			return $row;
		}
    }