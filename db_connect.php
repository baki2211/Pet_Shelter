<?php

$hostname = "127.0.0.1";
$username = "root"; 
$password = "";
$dbname = "EBEWD2_CR5_animal_adoption_angelopane"; 

$conn = new mysqli($hostname, $username, $password, $dbname);

if(!$conn) {
   die( "Connection failed: " . mysqli_connect_error() );
}
function cleanInputs($value)
{
    $data = trim($value);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
