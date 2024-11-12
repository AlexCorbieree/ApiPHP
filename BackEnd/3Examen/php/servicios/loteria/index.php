<?php
	$config	='loteria/configLoteria.php';
	include_once '../../base/encabezado.php';
	
switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
		// if($data = json_decode(file_get_contents("php://input"))){				
			if (isset($_GET['id'])) {
				$id=$_GET['id'];
				$conn  =	conexion($conexion);
				$res   =	ObtenerCartaPorId($conn, $id);
				$array=array();
				$array['status']	=	200;
				$array['error']   	=	false;
				$array['data']   	=	$res;
				$array=json_encode($array,UTF8);
				echo $array;
				die();
			} else {
				if (isset($_GET['n'])) {
					$n=$_GET['n'];
					$conn  =	conexion($conexion);
					$res   =	ObtenerCartas($conn, $n);
					$array=array();
					$array['status']	=	200;
					$array['error']   	=	false;
					$array['data']   	=	$res;
					$array=json_encode($array,UTF8);
					echo $array;
					die();
				} else {
					$n = 54;
					$conn  =	conexion($conexion);
					$res   =	ObtenerCartas($conn, $n);
					$array=array();
					$array['status']	=	200;
					$array['error']   	=	false;
					$array['data']   	=	$res;
					$array=json_encode($array,UTF8);
					echo $array;
					die();
				}
			}
		// }
		// else{
		// 	$array=array();
		// 	$array['status']	=	400;
		// 	$array['error']   	=	true;
		// 	$array['data']   	=	"";
		// 	$array=json_encode($array);
		// 	echo $array;
		// 	die();
		// }
    default:
		$array=array();
		$array['status']	=	401;
		$array['error']   	=	true;
		$array['data']   	=	"";
		$array=json_encode($array);
		echo $array;
		die();
}	
