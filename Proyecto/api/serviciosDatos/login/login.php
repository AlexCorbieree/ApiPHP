<?php
function login($conn, $correo, $clave) {
    $clave = md5($clave); 
    $stmt  = $conn->prepare("SELECT * FROM usuarios WHERE correo=? AND password=?");
    $stmt->bind_param("ss", $correo, $clave); 

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $response = [
                "status" => 200,
                "usuario" => $correo,
                "nombre" => $row["nombre"] ?? null 
            ];
        } else {
            $response = [
                "status" => 400,
                "message" => "Correo o contraseña incorrectos"
            ];
        }
    } else {
        $response = [
            "status" => false,
            "message" => "Error al procesar la solicitud"
        ];
    }

    return json_encode($response, JSON_UNESCAPED_UNICODE);
}

