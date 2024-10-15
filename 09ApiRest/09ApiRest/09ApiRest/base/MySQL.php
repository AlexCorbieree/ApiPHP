<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "peliculas";

function conexion($conexion) { 
    define( "UTF8", JSON_UNESCAPED_UNICODE);
    $conn = new mysqli(
                    $conexion["servername"],
                    $conexion["username"],
                    $conexion["password"],
                    $conexion["dbname"]);
    if ($conn->connect_error) {
        die("connection failed: ". $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

function closeConn($conn, $conexion){

    $conn = null;
    try {
        $conn = new mysqli(
            $conexion["servername"],
            $conexion["username"],
            $conexion["password"],
            $conexion["dbname"]); 
        
    } catch (Exception $e) {
        
    } finally {
        if ($conn !== null) {
            $conn->close();
        }
    }


}