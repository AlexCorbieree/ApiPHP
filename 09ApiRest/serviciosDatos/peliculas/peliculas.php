<?php


function getPeliculas($conn){

    $sql = "SELECT * FROM pelicula WHERE estado = 1";
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


function patchPeliculas($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['id'])) {
            $id = $conn->real_escape_string($data['id']); 
            $fields = [];
            if (!empty($data['nombre'])) {
                $nombre = $conn->real_escape_string($data['nombre']);
                $fields[] = "nombre = '$nombre'";
            }
            if (!empty($data['publicado'])) {
                $publicado = $conn->real_escape_string($data['publicado']);
                $fields[] = "publicado = '$publicado'";
            }
            if (!empty($data['director'])) {
                $director = $conn->real_escape_string($data['director']);
                $fields[] = "director = '$director'";
            }
            if (!empty($data['portada'])) {
                $portada = $conn->real_escape_string($data['portada']);
                $fields[] = "portada = '$portada'";
            }
            $fecha_modificacion = date('Y-m-d H:i:s'); 
            $fields[] = "fecha_modificacion = '$fecha_modificacion'";
            if (count($fields) > 0) {
                $sql = "UPDATE pelicula SET " . implode(", ", $fields) . " WHERE id = $id";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "Película modificada correctamente"]);
                } else {
                    echo json_encode(["error" => "Error al modificar la película: " . $conn->error]);
                }
            } else {
                echo json_encode(["error" => "No se enviaron datos para actualizar."]);
            }
        } else {
            echo json_encode(["error" => "ID de película no proporcionado."]);
        }
    }
}

function deletePeliculas($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $id = $conn->real_escape_string($data['id']); 

            $sql = "UPDATE pelicula SET estado = 0 WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Película eliminada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al eliminar la película: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "ID de película no proporcionado."]);
        }
    }
}

