<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../login.php");
    exit();
}


require "../db_connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM animals WHERE animals.id = {$id}";
    $result = mysqli_query($conn, $sql); # result will be one always

    $row = mysqli_fetch_assoc($result);
} else {
    header("Location: ../pages/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
    
    <div class="container mt-3">
        <div class="center text-center">
            <h1 class="mb-5 mt-5"><?= $row["name"] ?> In details: </h1>
        </div>
    </div>
    <div class="container">
    <div class='card' style='width: 25rem; margin: 0 auto'>
        <img src='../images/<?= $row["picture"] ?>' class='card-img-top' alt='...'>
        <div class='card-body'>
            <h5 class='card-title'><b>Name: </b><?= $row["name"] ?></h5>
            <h5 class='card-title'><b>Age: </b><?= $row["age"] ?></h5>
            <h5 class='card-text'><b>Gender: </b><?= $row["gender"] ?></h5>
            <h5 class='card-text'><b>Breed: </b><?= $row["breed"] ?></h5>
            <h5 class='card-text'><b>Size: </b><?= $row["size"] ?></h5>
            <h5 class='card-text'><b>Is Vaccinated?: </b><?= $row["vaccine"] ?></h5>
            <h5 class='card-text'><b>Living Address: </b><?= $row["address"] ?></h5>
            <h5 class='card-text'><b>Description: </b><?= $row["description"] ?></h5>

            <a href="../pages/dashboard.php" class="btn btn-warning">Back</a>
        </div>
    </div> 
    </div>
    
</body>

</html>