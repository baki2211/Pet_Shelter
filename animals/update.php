<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}

require "../db_connect.php";
require "../pages/file_upload.php";


$sqlanimals = "SELECT * FROM animals";
$resultanimals = mysqli_query($conn, $sqlanimals);
$rows = mysqli_fetch_all($resultanimals, MYSQLI_ASSOC);


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM `animals` WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $picture = fileUpload($_FILES["picture"], "pet");
    $breed = $_POST["breed"];
    $size = $_POST["size"];
    $age = $_POST["age"];
    $vaccine = $_POST["vaccine"];
    $address = $_POST["address"];
    $description = $_POST["description"];

    if ($_FILES["picture"]["error"] == 0) {
        # if it is not the default picture (REMOVE IT) 
        if ($row["picture"] != "pet.jpg") {
            unlink("../images/{$row["picture"]}");
        }
        $sql = "UPDATE `animals` SET `name`='{$name}',`gender`='{$gender}',`picture`='{$picture[0]}', `breed`='{$breed}', `size`='{$size}', `age`='{$age}', `vaccine`='{$vaccine}' ,`address`='{$address}' ,`description`='{$description}' WHERE id = {$id}";
    } else {
        $sql = "UPDATE `animals` SET `name`='{$name}',`gender`='{$gender}', `breed`='{$breed}', `size`='{$size}', `age`='{$age}', `vaccine`='{$vaccine}' ,`address`='{$address}' ,`description`='{$description}' WHERE id = {$id}";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
                pet has been updated
            </div>";
        header("refresh: 2; url= ../pages/dashboard.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        Something went wrong, please try again later!
    </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pet Details</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
    <div class="container mt-3">

    <h2>Update Pet Info</h2>

        <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Pet name" name="name" value="<?= $row["name"] ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" placeholder="Pet gender" name="gender" value="<?= $row["gender"] ?>">
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" placeholder="Breed" name="breed" value="<?= $row["breed"] ?>">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" placeholder="Pet picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" placeholder="Size" name="size" value="<?= $row["size"] ?>">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age"  name="age" value="<?= $row["age"] ?>">
            </div>
            <div class="mb-3">
                <label for="vaccine" class="form-label">Is vaccinated?</label>
                <input type="text" class="form-control" id="vaccine" placeholder="Is vaccinated?" name="vaccine" value="<?= $row["vaccine"] ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Description" name="description" value="<?= $row["description"] ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Address" name="address" value="<?= $row["address"] ?>">
            </div>
            <input name="update" type="submit" class="btn btn-primary" value="Update a pet">
            <a class="btn btn-warning" href="../pages/dashboard.php">Back to home page</a>
        </form>
    </div>

</body>

</html>