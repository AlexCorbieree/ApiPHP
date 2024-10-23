<?php


function getCalificaciones($conn){

    $sql    = "SELECT * FROM kardex WHERE estado = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    $row = json_encode($row,UTF8);
    return $row;

}

function postCalificaciones($conn){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['estudiante_id']) && !empty($data['materia']) && !empty($data['calificacion'])) {

            
            $estudianteId = $conn->real_escape_string($data['estudiante_id']);
            $materia      = $conn->real_escape_string($data['materia']);
            $calificacion = $conn->real_escape_string($data['calificacion']);

            $sql = "INSERT INTO kardex (estudiante_id, materia, calificacion) 
                    VALUES ('$estudianteId', '$materia', '$calificacion')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Calificacion insertada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al insertar la calificacion: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Datos incompletos. Faltan campos requeridos."]);
        }
    }
}


function patchCalificaciones($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['id'])) {
            $id = $conn->real_escape_string($data['id']); 
            $fields = [];
            if (!empty($data['estudiante_id'])) {
                $estudianteId = $conn->real_escape_string($data['estudiante_id']);
                $fields[] = "estudiante_id = '$estudianteId'";
            }
            if (!empty($data['materia'])) {
                $materia = $conn->real_escape_string($data['materia']);
                $fields[] = "materia = '$materia'";
            }
            if (!empty($data['calificacion'])) {
                $calificacion = $conn->real_escape_string($data['calificacion']);
                $fields[] = "calificacion = '$calificacion'";
            }
            $fecha_modificacion = date('Y-m-d H:i:s'); 
            $fields[] = "fecha_modificacion = '$fecha_modificacion'";
            if (count($fields) > 0) {
                $sql = "UPDATE kardex SET " . implode(", ", $fields) . " WHERE id = $id";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "Calificacion modificada correctamente"]);
                } else {
                    echo json_encode(["error" => "Error al modificar la calificación: " . $conn->error]);
                }
            } else {
                echo json_encode(["error" => "No se enviaron datos para actualizar."]);
            }
        } else {
            echo json_encode(["error" => "ID de calificación no proporcionado."]);
        }
    }
}

function deleteCalificaciones($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id'])) {
            $id = $conn->real_escape_string($data['id']); 

            $sql = "UPDATE kardex SET estado = 0 WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "Calificacion eliminada correctamente"]);
            } else {
                echo json_encode(["error" => "Error al eliminar la calificacion: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "ID de calificaicon no proporcionado."]);
        }
    }
}

