<?php
/* ----------- Header ------------------------*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/* ----------- Header ------------------------*/

define("UTF8", JSON_UNESCAPED_UNICODE);
session_start();

function curlPHP($url, $metodo, $datos, $auth) {
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
            'Authorization: ' . $auth,
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

$data = json_decode(file_get_contents("php://input"));

if (isset($_SESSION["llave_peticion"])) {
    if (isset($data->endpoint)) {
        if ($data->endpoint == "obtenerPerfiles") {
            if ($data->metodo == "GET") {
                $url = 'http://localhost/webmoviles/Proyecto/api/servicios/perfiles/';
                $metodo = "GET";
                $datos = null;
                $auth = isset($_SESSION['key']) ? $_SESSION['key'] : "123"; 
                $respuesta = curlPHP($url, $metodo, $datos, $auth);
                $respuesta = json_decode($respuesta);
                $html = "";  
                
                if ($respuesta->status == 200) {
                    $datos = json_decode($respuesta->data, true);
                    $esAdmin = isset($data->admin) && $data->admin === "true";
                    foreach ($datos as $perfil) {
                        $html .= "
                        <div class='col'>
                            <div class='card shadow-sm'>
                            <img src='https://api.dicebear.com/9.x/avataaars/svg?seed={$perfil[1]}' class='card-img-top' style='width: 100%; height: 225px; object-fit: cover;' alt='Avatar de {$perfil[1]}'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$perfil[1]}</h5>
                                    <p class='card-text'>{$perfil[2]}</p>
                                    <p class='card-text'><small class='text-muted'>{$perfil[3]} años</small></p>
                                    <p class='card-text'>Carrera: {$perfil[4]}</p>
                                    <p class='card-text'>Ubicacion: {$perfil[5]}</p>
                                    <p class='card-text'>Habilidades: {$perfil[8]}</p>
                                    <p class='card-text'>{$perfil[7]}</p>
                                    <div class='d-flex justify-content-between align-items-center'>";

                        if ($esAdmin) {
                            $html .= "
                                        <button type='button' class='btn btn-sm btn-outline-warning editar' data-id='{$perfil[0]}'>Editar</button>
                                        <button type='button' class='btn btn-sm btn-outline-danger eliminar' data-id='{$perfil[0]}'>Eliminar</button>";
                        }
                        $html .= "
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }

                    $respuesta = array(
                        "html" => $html
                    );
                    $array = array();
                    $array['status'] = 200;
                    $array['error'] = false;
                    $array['data'] = $respuesta;
                    $array = json_encode($array, UTF8);  
                    echo $array;
                    die();
                }
            }
        }


        if ($data->endpoint == "eliminarPerfil") {
            if ($data->metodo == "DELETE") { 
                $url = 'http://localhost/webmoviles/Proyecto/api/servicios/perfiles/';
                $metodo = "DELETE";  
                $datos = json_encode(array("id" => $data->id));  
        
                $auth = isset($_SESSION['key']) ? $_SESSION['key'] : "123"; 
                $respuesta = curlPHP($url, $metodo, $datos, $auth);  
        
                if ($respuesta) {
                    $respuesta = json_decode($respuesta, true);
                    
                    if ($respuesta && $respuesta['status'] == 200) {
                        $array = array();
                        $array['status'] = 200;
                        $array['error'] = false;
                        $array['data'] = "Perfil eliminado correctamente.";
                        echo json_encode($array, JSON_UNESCAPED_UNICODE);
                    } else {
                        $array = array();
                        $array['status'] = 500;
                        $array['error'] = true;
                        $array['data'] = "Error al eliminar el perfil.";
                        echo json_encode($array, JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    $array = array();
                    $array['status'] = 500;
                    $array['error'] = true;
                    $array['data'] = "Error al eliminar el perfil. No se recibió respuesta.";
                    echo json_encode($array, JSON_UNESCAPED_UNICODE);
                }
        
                die();
            }
        }
        
        if ($data->endpoint == "crearPerfil") {
            if ($data->metodo == "POST") { 
                $url = 'http://localhost/webmoviles/Proyecto/api/servicios/perfiles/';
                $metodo = "POST";  
                $datos = json_encode($data->datos);  
                // print __LINE__;
                // exit();
                
                $auth = isset($_SESSION['key']) ? $_SESSION['key'] : "123"; 
                $respuesta = curlPHP($url, $metodo, $datos, $auth);  
                
                echo $respuesta; 
                die();
            }
        }
        
        

    }
} else {
    $array = array();
    $array['status'] = 500;
    $array['error'] = true;
    $array['data'] = "Error de sesión";
    $array = json_encode($array, UTF8);  
    echo $array;
    die();
}
