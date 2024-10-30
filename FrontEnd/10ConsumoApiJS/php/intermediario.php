<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

define("UTF8",value: JSON_UNESCAPED_UNICODE);  

function curlPHP (){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL            => 'http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'GET',
        CURLOPT_POSTFIELDS     => '{
            "id": 17
        }',
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response;
}

// $data = json_decode(file_get_contents("php://input"));
// print_r($data);
// exit();



// if(isset($data->endpoint)){
//     if($data->endpoint=="getPeliculas"){
//         if($data->metodo=="GET"){
//             $url="http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/";
//             $metodo="GET";
//             $datos=null;
//             $auth="123";
//             $respuesta=curlPHP($url,$metodo,$datos,$auth);
//             $respuesta=json_decode($respuesta);
//             $html="";
//             if($respuesta->status==200){
//                 $datos = json_decode($respuesta->data);
//                 foreach($datos as $clave){
//                 foreach($clave as $registro){
//                     $html.="
//                     $registro
//                         <div class='card'>
//                             <img src='https://via.placeholder.com/300x200' alt='Card 1' class='card-img'>
//                             <div class='card-content'>
//                                 <h3 class='card-title'>Card 1</h3>
//                                 <p class='card-text'>Contenido de la tarjeta 1</p>
//                             </div>
//                         </div>
//                     ";
//                 }
//             }
//             $array=array();
//             $array['status']	=	200;
//             $array['error']   =	false;
//             $array['data']   	=	$html;
//             $array=json_encode($array,UTF8);
//             echo $array;
//             die();         
//             }
//         }
//     }
// }else{
//     $array=array();
//     $array['status']	=	500;
//     $array['error']   =	true;
//     $array['data']   	=	"Error";
//     $array=json_encode($array,UTF8);
//     echo $array;
//     die();  
// }