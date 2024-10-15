<?php

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

            $conn = conexion($conexion);
            $res = postPeliculas($conn);
            echo $res;
            return $res;
        } else {
            $array = array();
            $array['estatus']	=	400;
            $array['error']   	=	"Error de datos";
            $array=json_encode($array);
            echo $array;
            die();
        }
    default:
        break;
}

closeConn($conn, $conexion);
