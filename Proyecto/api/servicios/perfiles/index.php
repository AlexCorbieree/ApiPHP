<?php
$config = 'perfiles/configPerfiles.php';
include_once '../../base/encabezado.php';


switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
            $conn  =	conexion($conexion);
            $res   =	obtenerPerfiles($conn);
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        
        break;
    case 'POST':
        if($data = json_decode(file_get_contents("php://input"))){
            $conn  =	conexion($conexion);
            $res   =	crearPerfil($conn, $data->nombre, $data->puesto,$data->puesto, $data->edad, $data->educacion, $data->locacion, $data->foto, $data->biografia, $data->metas, $data->motivaciones, $data->preocupaciones);
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        }else{
            $array=array();
            $array['status']	=	400;
            $array['error']   	=	true;
            $array['data']   	=	"";
            $array=json_encode($array);
            echo $array;
            die();
        }
        break;
    case 'DELETE':
        if($data = json_decode(file_get_contents("php://input"))) { 
            $conn = conexion($conexion);
            $res = eliminarPerfil($conn);
            $array=array();
            $array['status']	=	200;
            $array['error']   	=	false;
            $array['data']   	=	$res;
            $array=json_encode($array,UTF8);
            echo $array;
            die();
        } else {
            $array = array();
            $array['estatus']	=	400;
            $array['error']   	=	"Error de datos";
            $array=json_encode($array);
            echo $array;
            die();
        }
    break;
}