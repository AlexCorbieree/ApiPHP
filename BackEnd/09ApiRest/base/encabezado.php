<?php

if(isset($debug)){
    if ($debug) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

    }
}


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();    
$_SESSION["llave_peticion"] = uniqid();

include_once "seguridad.php";
include_once "MySQL.php";
include_once "../../config/".$config;
include_once "../../serviciosDatos/".$datos;





