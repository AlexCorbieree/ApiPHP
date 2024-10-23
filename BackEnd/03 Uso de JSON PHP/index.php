<?php
define("UTF8", JSON_UNESCAPED_UNICODE);
    $var = array(
        "Nombre" => "Alejandro",
        // "Nombre" => "María",
    );

$var = json_encode($var,UTF8);
var_dump($var);

echo "<br>";


$var = array();
$nombre1 = array("Nombre"=>"Alejandro");
array_push($var, $nombre1);
$nombre2 = array("Nombre"=>"Alejandro");
array_push($var, $nombre2);

$var = json_encode($var,UTF8);
var_dump($var);
$var = json_decode($var, UTF8);
var_dump($var);
echo "<br>";


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
var_dump($personas);
echo "<br>";

$personas = json_decode($personas, UTF8);
print_r($personas);
echo "<br> <br>";


$path = "ejemplo.json";
$json = file_get_contents($path);
$jsonData = json_decode($json, UTF8);
var_dump($jsonData);

echo "<br> <br>";
print_r($jsonData);
