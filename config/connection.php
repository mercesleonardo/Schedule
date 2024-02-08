<?php

$db_name = "schedule";
$db_host = "localhost";
$db_user = "root";
$db_pass = "";

try {
    $conn = new PDO("mysql:dbname=". $db_name .";host=". $db_host, $db_user, $db_pass);

    //Activate error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
    //Connection error
    $error = $e->getMessage();
    echo "Error: " . $error;
}