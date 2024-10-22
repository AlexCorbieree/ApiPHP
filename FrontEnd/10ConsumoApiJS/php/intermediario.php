<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function curlPHP ($url, $metodo, $datos, $auth){


    
}


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL            => 'http://localhost/webmoviles/FrontEnd/10ConsumoApiJS/php/indermediario.php/',
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
echo $response;
