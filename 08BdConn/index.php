<?php

define("UTF8",JSON_UNESCAPED_UNICODE);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cms1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
$sql = "SELECT * FROM perfiles";

$result = $conn->query($sql);
$row = $result->fetch_all();
// $row = json_encode(value: $row, UTF8);




