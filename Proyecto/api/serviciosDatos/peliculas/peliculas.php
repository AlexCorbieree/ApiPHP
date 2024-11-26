<?php
    function obtenerPeliculas($conn){
        
        $sql        = "SELECT * FROM peliculas";
        $result     =   $conn->query($sql);
        $row        =   $result->fetch_all();
        $row        =  json_encode($row,UTF8);
        return $row;
        
    }
    function insertarPelicula($conn, $nombre, $year, $portada, $estado){
        $stmt = $conn->prepare("INSERT INTO peliculas (nombre, year, portada, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $year, $portada,$estado);  // "sis" significa string, integer, string
        
        if ($stmt->execute()) {    
            $respuesta = array(
                'nombre' => $nombre,
                'year' => $year,
                'portada'=> $portada,
                'id'=>$conn->insert_id
            );
            return json_encode($respuesta,UTF8);
        } else {
            // Error en la ejecución
            echo "Error: ".$stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

    }
    function modificarPelicula($conn, $id, $nombre, $year, $portada){
        $stmt = $conn->prepare("UPDATE peliculas SET nombre=?, year=?, portada=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $year, $portada, $id);
        if ($stmt->execute()) {
            $respuesta = array(
                'nombre' => $nombre,
                'year' => $year,
                'portada'=> $portada,
                'id'=>$id
            );
            return json_encode($respuesta,UTF8);
            
        }else{
            
            echo "Error: ".$stmt->error;
        }
        $stmt->close();
        
    }
    function eliminarPelicula($conn , $id){
        $estado = "inactivo";
        $stmt = $conn->prepare("UPDATE peliculas SET estado = ? WHERE id = ?");
        $stmt->bind_param("si",$estado,$id);
        if ($stmt->execute()) {
            $array = array(
                'estatus' => 200,
                'mensaje' => 'Pelicula  eliminada'
            );
            return json_encode($array,UTF8);
        }else{
            
            echo json_encode("Error: ".$stmt->error,UTF8);
        }
        $stmt->close();
    }