<?php


function getPeliculas($conn){

    $sql = "SELECT * FROM pelicula";
    $result = $conn->query($sql);
    $row    = $result->fetch_all();
    $row    = json_encode($row,UTF8);
    return $row;

}

function postPeliculas($conn){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['nombre']) && !empty($data['publicado']) && !empty($data['director']) && !empty($data['portada'])) {

            
            $nombre = $conn->real_escape_string($data['nombre']);
            $publicado = $conn->real_escape_string($data['publicado']); 
            $director = $conn->real_escape_string($data['director']);
            $portada = $conn->real_escape_string($data['portada']);

            $sql = "INSERT INTO pelicula (nombre, publicado, director, portada) 
                    VALUES ('$nombre', '$publicado', '$director', '$portada')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Película insertada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al insertar la película: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Datos incompletos. Faltan campos requeridos."]);
        }
    }
}
