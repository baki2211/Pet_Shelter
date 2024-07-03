<?php

$hostname = "";
$username = ""; 
$password = "";
$dbname = "shelter"; 

$conn = new mysqli($hostname, $username, $password, $dbname);

if(!$conn) {
   die( "Connection failed: " . mysqli_connect_error() );
}

//function to clean imput. 

function cleanInputs($value)
{
    $data = trim($value);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
