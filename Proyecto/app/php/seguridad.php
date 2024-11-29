<?php
	if (isset($_SERVER['HTTP_ORIGIN'])) {
		$allowedOrigins = ['http://localhost'];
		if (!in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
			die('Origen no permitido');
		}
	}
	define("UTF8",JSON_UNESCAPED_UNICODE);  
	session_start();
	$_SESSION["llave_peticion"] =  uniqid();
	$key=json_encode($_SESSION["llave_peticion"]);
	$array=array();
	$array['status']	=	200;
	$array['error']   	=	false;
	$array['data']   	=	$key;
	$array				=	json_encode($array,UTF8);
	echo $array;
	die();  