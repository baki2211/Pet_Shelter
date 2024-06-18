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
$supplierOptions = "";

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $picture = fileUpload($_FILES["picture"], "pet");
    $breed = $_POST["breed"];
    $size = $_POST["size"];
    $age = $_POST["age"];
    $vaccine = $_POST["vaccine"];
    $address = $_POST["address"];
    $description = $_POST["description"];
   

    $sql = "INSERT INTO `animals`(`name`, `gender`, `picture`, `breed`, `size`, `age`, `vaccine`,`address`,`description`) VALUES ('{$name}','{$gender}','{$picture[0]}', '{$breed}', '{$size}', '{$age}', '{$vaccine}','{$address}','{$description}')"; 

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
                pet has been created, {$picture[1]}
            </div>";

        header("refresh: 2; url= ../pages/dashboard.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                something is wrong, please try again later
            </div>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
<?php require_once "../components/navbar.php"; ?>
    <div class="container">

    <h1 class="text-center mb-5 mt-5">Add a pet in the shelter!</h1>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Pet name" name="name">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" placeholder="Pet gender" name="gender">
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" placeholder="Breed" name="breed">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" placeholder="Pet picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" placeholder="Size" name="size">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age"  name="age">
            </div>
            <div class="mb-3">
                <label for="vaccine" class="form-label">Is vaccinated?</label>
                <input type="text" class="form-control" id="vaccine" placeholder="Is vaccinated?" name="vaccine">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Address" name="address">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Description" name="description">
            </div>
            <input name="create" type="submit" class="btn btn-primary" value="Add a pet">
            <a class="btn btn-warning" href="../pages/dashboard.php">Back to home page</a>
        </form>
    </div>

</body>

</html>