<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function curlPHP($url, $metodo, $datos = null, $auth = ""){
    $curl = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $metodo,
        CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $auth,
            'Content-Type: application/json'
        ),
    );

    if ($metodo == "POST") {
        $options[CURLOPT_POSTFIELDS] = $datos;
    }

    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

$data = json_decode(file_get_contents("php://input"));
if(isset($data->endpoint)){
    if($data->endpoint == "getTablero") {
        // Consumir la API para obtener el tablero
        $url = "http://localhost/webmoviles/BackEnd/3Examen/php/servicios/loteria//";
        $metodo = "GET";
        $auth = "123";
        $respuesta = curlPHP($url, $metodo, null, $auth);
        $respuesta = json_decode($respuesta);

        if($respuesta->status == 200) {
            $datos = json_decode($respuesta->data);
            $response = array();
            $html = "";
            foreach($datos as $clave){
                $html .= "<div class='card'>
                            <img src='img/{$clave->imagen}' alt='{$clave->nombre}' class='card-img'>
                            <div class='card-content'>
                                <h3 class='card-title'>{$clave->nombre}</h3>
                            </div>
                        </div>";
            }
            $response["tablero"] = trim($html);
            echo json_encode($response);
        }
    }

    if($data->endpoint == "getCartas") {
        // Consumir la API para obtener las cartas
        $url = "http://localhost/webmoviles/BackEnd/3Examen/php/servicios/loteria/";
        $metodo = "GET";

        // Verificar si se ha proporcionado un número de cartas
        if (isset($data->cantidad)) {
            $cantidad = (int)$data->cantidad;
            $url .= "?n=" . $cantidad; // Agregar parámetro de cantidad
        }

        $auth = "123";
        $respuesta = curlPHP($url, $metodo, null, $auth);
        $respuesta = json_decode($respuesta);

        if($respuesta->status == 200) {
            $datos = json_decode($respuesta->data);
            $response = array();
            $html = "";
            foreach($datos as $clave){
                $html .= "<div class='card'>
                            <img src='img/{$clave->imagen}' alt='{$clave->nombre}' class='card-img'>
                            <div class='card-content'>
                                <h3 class='card-title'>{$clave->nombre}</h3>
                            </div>
                        </div>";
            }
            $response["cartas"] = trim($html);
            echo json_encode($response);
        }
    }
} else {
    echo json_encode(["status" => 500, "error" => true, "data" => "Error"]);
}
?>
