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


$sql = "SELECT * FROM `animals`";
$result = mysqli_query($conn, $sql);
$layout = "";

if (mysqli_num_rows($result) == 0) {
    $layout .= "No result found";
} else {
    while ($row = mysqli_fetch_assoc($result)) {   
        $layout .= "
        <div>
        <div class='card' style='width: 18rem;'>
        <img src='../images/{$row["picture"]}' class='card-img-top' alt='...'>
        <div class='card-body'>
          <h5 class='card-title'>{$row["name"]}</h5>
          <p class='card-text'>{$row["gender"]}</p>
          <a href='../animals/details.php?id={$row["id"]}' class='btn btn-success'>Details</a>
          <a href='../animals/update.php?id={$row["id"]}' class='btn btn-warning'>Update</a>
          <a href='../animals/delete.php?id={$row["id"]}' class='btn btn-danger'>Delete</a>
        </div>
      </div>
      </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: rgb(189, 228, 191);" >
    <?php require_once "../components/navbar.php"; ?>
    <div class="container p-3 mt-3">
        <a class="btn btn-primary" href="../animals/create.php">Create a pet</a>
        <h4 class="mt-5">Pets In the shelter:</h4>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1 mt-5">
            <?= $layout ?>
        </div>
    </div>


</body>

</html>