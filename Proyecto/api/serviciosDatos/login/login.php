<?php
    function login($conn,$usuario,$clave){
		$clave=md5($clave);
        $stmt 	= $conn->prepare("SELECT * FROM usuarios WHERE usuario=? AND clave=?");
		$stmt->bind_param("ss",$usuario,$clave);
		if ($stmt->execute()) {
        	$row["status"]   =  $stmt->fetch();
			if($row["status"]){
				$row["usuario"]   =  $usuario;
				$row["clave"]  =  $clave;
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