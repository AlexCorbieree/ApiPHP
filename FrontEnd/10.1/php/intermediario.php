<?php
/* ----------- Header 		------------------------*/
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/* ----------- Header 		------------------------*/

define("UTF8",JSON_UNESCAPED_UNICODE);  

function curlPHP($url,$metodo,$datos,$auth){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $metodo,
    CURLOPT_POSTFIELDS => $datos,
    CURLOPT_HTTPHEADER => array(
      'Authorization: '.$auth,
      'Content-Type: application/json'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}


$data = json_decode(file_get_contents("php://input"));
if(isset($data->endpoint)){
  if($data->endpoint=="getPeliculas"){
    if($data->metodo=="GET"){
      $url="http://localhost/webmoviles/BackEnd/09ApiRest/servicios/peliculas/";
      $metodo="GET";
      $datos=null;
      $auth="123";
      $respuesta=curlPHP($url,$metodo,$datos,$auth);
      $respuesta=json_decode($respuesta);
      $html="";
      $html2="";
      $response=array();
      if($respuesta->status==200){
        $datos = json_decode($respuesta->data);
        foreach($datos as $clave){
          $html.=trim("<div class='card'><img src='img/$clave->portada' alt='Card 1' class='card-img'><div class='card-content'><h3 class='card-title'>$clave->nombre</h3><p class='card-director'>$clave->director</p><p class='card-text'>$clave->publicado</p></div></div>");
          $html2.=trim("<tr><td>$clave->id</td><td>$clave->nombre</td><td>$clave->director</td><td>$clave->publicado</td><td>$clave->portada</td></tr>");         
        }
        $response["card"]=trim($html);
        $response["tabla"]=trim($html2);
        $response=json_encode($response,UTF8);
        $array=array();
        $array['status']	=	200;
        $array['error']   =	false;
        $array['data']   	=	'{"card":"'.$html.'","tabla":"'.$html2.'"}';
        $array=json_encode($array,UTF8);
        echo $array;
        die();         
      }
    }
  }
}else{
  $array=array();
  $array['status']	=	500;
  $array['error']   =	true;
  $array['data']   	=	"Error";
  $array=json_encode($array,UTF8);
  echo $array;
  die();  
}

