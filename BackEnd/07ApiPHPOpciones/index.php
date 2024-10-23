<?php

$op = $_GET['opcion'];
    if($op == "json"){
        header("Location: JSONAPI/index.php");
    }
    elseif($op == "php"){
        header("Location: JSONPHPAPI/index.php");
    }
    elseif($op == "db"){
        header("Location: DBAPI/index.php");
    }
    else{
        return 0;
    }


