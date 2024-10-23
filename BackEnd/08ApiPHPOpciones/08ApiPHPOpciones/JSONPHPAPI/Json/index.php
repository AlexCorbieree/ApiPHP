<?php
define("UTF8", JSON_UNESCAPED_UNICODE);

$personas = array();
$persona1 = array(
    "Nombre"=>"Alejandro",
    "Apellido"=> "Alonso",
    "Edad" => 23,
);
$persona2 = array(
    "Nombre"=>"María",
    "Apellido"=> "Lopez",
    "Edad" => 20,
);
array_push($personas, $persona1);
array_push($personas, $persona2);
$personas = json_encode($personas,UTF8);
echo $personas;

