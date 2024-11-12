<?php
function obtenerCartas($conn, $num){
	if ($num) {
		$sql        =   "SELECT * FROM loteria
						ORDER BY RAND()
						LIMIT $num";
		$result     =   $conn->query($sql);
		$row        =   $result->fetch_all(MYSQLI_ASSOC);
		$row        =  json_encode($row,UTF8);
		return $row;
	} else {
		$sql        =   "SELECT * FROM loteria
						ORDER BY RAND()";
		$result     =   $conn->query($sql);
		$row        =   $result->fetch_all(MYSQLI_ASSOC);
		$row        =  json_encode($row,UTF8);	
	}
}
function ObtenerCartaPorId($conn, $id){
	$sql        =   "SELECT * FROM loteria WHERE id=$id";
	$result     =   $conn->query($sql);
	$row        =   $result->fetch_all(MYSQLI_ASSOC);
	$row        =  json_encode($row,UTF8);
	return $row;
}
