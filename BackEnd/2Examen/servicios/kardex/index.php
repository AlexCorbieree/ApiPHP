<?php

$config = "kardex/configKardex.php";
include_once "../../base/encabezado.php";

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':

        $conn = conexion($conexion);
        $res = getCalificaciones($conn);
        $array = array();
        $array['status'] = 200;
        $array['error'] = "false";
        $array['data'] = $res;
        $array = json_encode($array, UTF8);
        echo $array;
        break;
    case 'POST':
        if($data = json_decode(file_get_contents("php://input"))) { 

            $conn = conexion($conexion);
            $res = postCalificaciones($conn);
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
    case 'PATCH':
        if($data = json_decode(file_get_contents("php://input"))) { 
            $conn = conexion($conexion);
            $res = patchCalificaciones($conn);
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
    case 'DELETE':
        if($data = json_decode(file_get_contents("php://input"))) { 
            $conn = conexion($conexion);
            $res = deleteCalificaciones($conn);
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
