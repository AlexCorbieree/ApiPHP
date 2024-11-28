<?php
    function obtenerPerfiles($conn){
        
        $sql        = "SELECT * FROM perfiles where estado = 1";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function crearPerfil($conn, $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones){
        $stmt = $conn->prepare("INSERT INTO perfiles (nombre_perf, puesto, edad, educacion,locacion,foto,biografia,metas,motivaciones,preocupaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssssss", $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones);  // "sis" significa string, integer, string

        if ($stmt->execute()) {    
            $respuesta = array(
                'nombre' => $nombre,
                'puesto' => $puesto,
                'edad'=> $edad,
                'educacion'=> $educacion,
                'locacion'=> $locacion,
                'foto'=> $foto,
                'biografia'=> $biografia,
                'metas'=> $metas,
                'motivaciones'=> $motivaciones,
                'preocupaciones'=> $preocupaciones,
                'id'=>$conn->insert_id
            );
            return json_encode($respuesta,UTF8);
        } else {
            echo "Error: ".$stmt->error;
        }

        $stmt->close();

    }
    function modificarPerfil($conn, $id, $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones){
        $stmt = $conn->prepare("UPDATE perfiles SET nombre_perf=?, puesto=?, edad=?, educacion=?, locacion=?, foto=?, biografia=?, metas=?, motivaciones=?, preocupaciones=? WHERE id=?");
        $stmt->bind_param("ssisssssssi", $nombre, $puesto, $edad, $educacion, $locacion, $foto, $biografia, $metas, $motivaciones, $preocupaciones,$id);
        if ($stmt->execute()) {
            $respuesta = array( 
                'id'=>$id,
                'nombre' => $nombre,
                'puesto' => $puesto,
                'edad'=> $edad,
                'educacion'=> $educacion,
                'locacion'=> $locacion,
                'foto'=> $foto,
                'biografia'=> $biografia,
                'metas'=> $metas,
                'motivaciones'=> $motivaciones,
                'preocupaciones'=> $preocupaciones
            );
            return json_encode($respuesta,UTF8);
            
        }else{
            
            echo "Error: ".$stmt->error;
        }
        $stmt->close();
        
    }

    function eliminarPerfil($conn) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!empty($data['id'])) {
                $id = $conn->real_escape_string($data['id']); 
                
                $sql = "UPDATE perfiles SET estado = 0 WHERE id = $id";
                
                if ($conn->query($sql) === TRUE) {
                    $array = array();
                    $array['status'] = 200;
                    $array['error'] = false;
                    $array['data'] = "Perfil eliminado correctamente";
                    return json_encode($array);  
                } else {
                    $array = array();
                    $array['status'] = 400;
                    $array['error'] = true;
                    $array['data'] = "Error al eliminar perfil";
                    return json_encode($array);  
                }
            } else {
                $array = array();
                $array['status'] = 400;
                $array['error'] = true;
                $array['data'] = "ID del perfil no proporcionado.";
                return json_encode($array);  
            }
        }
    }
    