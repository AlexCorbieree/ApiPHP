<?php


function getCanciones($conn){

    $sql    = "SELECT * FROM canciones WHERE estado = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    $row = json_encode($row,UTF8);
    return $row;

}

function postCanciones($conn){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['nombre']) && !empty($data['publicado']) && !empty($data['artista'])) {

            
            $nombre = $conn->real_escape_string($data['nombre']);
            $publicado = $conn->real_escape_string($data['publicado']); 
            $artista = $conn->real_escape_string($data['artista']);

            $sql = "INSERT INTO canciones (nombre, publicado, artista) 
                    VALUES ('$nombre', '$publicado', '$artista')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Cancion insertada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al insertar la cancion: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Datos incompletos. Faltan campos requeridos."]);
        }
    }
}


function patchCanciones($conn) {
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
            if (!empty($data['artista'])) {
                $artista = $conn->real_escape_string($data['artista']);
                $fields[] = "artista = '$artista'";
            }
            $fecha_modificacion = date('Y-m-d H:i:s'); 
            $fields[] = "fecha_modificacion = '$fecha_modificacion'";
            if (count($fields) > 0) {
                $sql = "UPDATE canciones SET " . implode(", ", $fields) . " WHERE id = $id";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "Cancion modificada correctamente"]);
                } else {
                    echo json_encode(["error" => "Error al modificar la cancion: " . $conn->error]);
                }
            } else {
                echo json_encode(["error" => "No se enviaron datos para actualizar."]);
            }
        } else {
            echo json_encode(["error" => "ID de cancion no proporcionado."]);
        }
    }
}

function deleteCanciones($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $id = $conn->real_escape_string($data['id']); 

            $sql = "UPDATE canciones SET estado = 0 WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Cancion eliminada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al eliminar la cancion: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "ID de cancion no proporcionado."]);
        }
    }
}

