<?php
// class DbManager {

//     private $conn;

//     public function __construct($conn) {
//         $this->conn = $conn;
//     }

//     public function getPerfiles() {
//         $sql = "SELECT id, nombre, apellido_paterno, apellido_materno, foto, rol, educacion, descripcion, fecha_creacion, fecha_modificacion FROM perfiles";
//         $result = $this->conn->query($sql);

//         if ($result->num_rows > 0) {
//             while($row = $result->fetch_assoc()) {
//                 echo "ID: " . $row["id"] . "<br>";
//                 echo "Nombre: " . $row["nombre"] . " " . $row["apellido_paterno"] . " " . $row["apellido_materno"] . "<br>";
//                 echo "Rol: " . $row["rol"] . "<br>";
//                 echo "Educación: " . $row["educacion"] . "<br>";
//                 echo "Descripción: " . $row["descripcion"] . "<br>";
//                 echo "Foto: " . (is_null($row["foto"]) ? "Sin foto" : $row["foto"]) . "<br>";
//                 echo "Fecha de creación: " . $row["fecha_creacion"] . "<br>";
//                 echo "Fecha de modificación: " . (is_null($row["fecha_modificacion"]) ? "No modificada" : $row["fecha_modificacion"]) . "<br><br>";
//             }
//         } else {
//             echo "No se encontraron resultados.";
//         }
//     }

//     // echo "$sql";
// }

include 'conn.php'; 

$sql = "SELECT id, nombre, apellido_paterno, apellido_materno, foto, rol, educacion, descripcion, fecha_creacion, fecha_modificacion FROM perfiles";
$result = $conn->query($sql);

if ($result) { 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Nombre: " . $row["nombre"] . " " . $row["apellido_paterno"] . " " . $row["apellido_materno"] . "<br>";
            echo "Rol: " . $row["rol"] . "<br>";
            echo "Educación: " . $row["educacion"] . "<br>";
            echo "Descripción: " . $row["descripcion"] . "<br>";
            echo "Foto: " . (is_null($row["foto"]) ? "Sin foto" : $row["foto"]) . "<br>";
            echo "Fecha de creación: " . $row["fecha_creacion"] . "<br>";
            echo "Fecha de modificación: " . (is_null($row["fecha_modificacion"]) ? "No modificada" : $row["fecha_modificacion"]) . "<br><br>";
        }
    } else {
        echo "No se encontraron resultados.";
    }
} else {
    echo "Error en la consulta: " . $conn->error; // Manejo de error en la consulta
}


$conn->close(); 