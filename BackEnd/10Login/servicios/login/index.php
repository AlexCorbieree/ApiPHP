<?php
	$config	='login/configLogin.php';
	include_once '../../base/encabezado.php';
	
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST':
			if($data = json_decode(file_get_contents("php://input"))){
				$conn  =	conexion($conexion);
				$res   =	login($conn,$data->usuario,$data->password);
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