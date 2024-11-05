<?php
    function obtenerPeliculas($conn){
        $sql        =   "SELECT * FROM peliculas";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all(MYSQLI_ASSOC);
        $row        =  json_encode($row,UTF8);
        return $row;
    }
    function insertarPeliculas($conn,$year,$nombre,$portada){
		$stmt 	= $conn->prepare("INSERT INTO peliculas (nombre,year,portada) VALUES (?,?,?)");
		$stmt->bind_param("sis",$nombre,$year,$portada);
		if ($stmt->execute()) {
			$res=array(
				"year"=>$year,
				"nombre"=>$nombre,
				"portada"=>$portada,
				"id"=>$conn->insert_id
			);
			return json_encode($res,UTF8);
		} else {
			echo "Error: " . $stmt->error;
		}
    }
    function actualizarPeliculas($conn,$year,$nombre,$portada,$id){
		$stmt 	= $conn->prepare("UPDATE peliculas SET nombre=?,year=?,portada=? WHERE id=?");
		$stmt->bind_param("sisi",$nombre,$year,$portada,$id);
		if ($stmt->execute()) {
			$res=array(
				"year"=>$year,
				"nombre"=>$nombre,
				"portada"=>$portada,
				"id"=>$id
			);
			return json_encode($res,UTF8);
		} else {
			echo "Error: " . $stmt->error;
		}
    }
    function borrarPeliculas($conn,$id){
		$stmt 	= $conn->prepare("UPDATE peliculas SET activo=0 WHERE id=?");
		$stmt->bind_param("i",$id);
		if ($stmt->execute()) {
			$res=array(
				"activo"=>0,
				"id"=>$id
			);
			return json_encode($res,UTF8);
		} else {
			echo "Error: " . $stmt->error;
		}
    }