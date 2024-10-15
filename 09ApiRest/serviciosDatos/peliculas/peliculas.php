<?php


function getPeliculas($conn){

    $sql = "SELECT * FROM pelicula";
    $result = $conn->query($sql);
    $row    = $result->fetch_all();
    $row    = json_encode($row,UTF8);
    return $row;

}

function postPeliculas($conn){



}