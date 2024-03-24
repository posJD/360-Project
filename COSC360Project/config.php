<?php

$host = "localhost"; 
$username = "86043593"; 
$password = "86043593"; 
$database = "db_86043593"; 

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
