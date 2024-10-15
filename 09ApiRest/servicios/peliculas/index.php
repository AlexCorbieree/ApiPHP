<?php

// include "../../base/MySQL.php";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "peliculas";
// $conn=conexion($servername, $username, $password, $dbname);


// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $conn->set_charset("utf8mb4");

// $sql = "SELECT * FROM pelicula";

// $result = $conn->query($sql);
// $row = $result->fetch_all();
// $row =  json_encode($row,UTF8);
// $conn->close();
// echo $row;



$config = "peliculas/configPeliculas.php";
include_once "../../base/encabezado.php";

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $conn = conexion($conexion);
        $res = getPeliculas($conn);
        echo $res;
        break;
    case 'POST':
        if($data = json_decode(file_get_contents("php://input"))) { 
            return $data;
        } else {
            $array = array();
            $array['estatus']	=	400;
            $array['error']   	=	"Error de datos";
            $array=json_encode($array);
            echo $array;
            die();
        }
        // break;
    default:
        break;
}

closeConn($conn, $conexion);
