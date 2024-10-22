<?php
// include 'backend/conn.php';       
// include 'backend/DbManager.php';

// $dbManager = new DbManager($conn);  

echo "<h1>Listado de Perfiles</h1>";

// $dbManager->getPerfiles();

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost/webmoviles/00-Proyecto/01-bdcon/backend/DbManager.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
