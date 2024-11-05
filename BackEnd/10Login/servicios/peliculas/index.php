<?php
	$config	='peliculas/configPeliculas.php';
	include_once '../../base/encabezado.php';
	
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $conn  =   conexion($conexion);
			$res   =   obtenerPeliculas($conn);
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
				$res   =	insertarPeliculas($conn,$data->year,$data->nombre,$data->portada);
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
        case 'PUT':
			if($data = json_decode(file_get_contents("php://input"))){
				$conn  =	conexion($conexion);
				$res   =	actualizarPeliculas($conn,$data->year,$data->nombre,$data->portada,$data->id);
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
			if($data = json_decode(file_get_contents("php://input"))){
				$conn  =	conexion($conexion);
				$res   =	borrarPeliculas($conn,$data->id);
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
        default:
				$array=array();
				$array['status']	=	401;
				$array['error']   	=	true;
				$array['data']   	=	"";
				$array=json_encode($array);
				echo $array;
				die();
        break;
    }	
?>