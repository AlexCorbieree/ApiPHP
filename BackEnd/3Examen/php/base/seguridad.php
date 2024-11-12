<?php
	function seguridad(){
		if (session_status() === PHP_SESSION_NONE) {
			if(isset($_SESSION["llave_peticion"])){
				$array=array();
				$array['estatus']	=	500;
				$array['error']   	=	"Error de seguridad";
				$array=json_encode($array);
				echo $array;
				die();
			}
		}
	}
	seguridad();
?>