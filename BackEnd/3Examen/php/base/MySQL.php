<?php
function conexion($conexion){
	define("UTF8",JSON_UNESCAPED_UNICODE);  
	$conn = new mysqli(
						$conexion["servername"],
						$conexion["username"], 
						$conexion["password"],
						$conexion["dbname"]
	);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$conn->set_charset("utf8mb4");
	return $conn;
}