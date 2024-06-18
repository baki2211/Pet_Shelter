<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
session_start();
require "../db_connect.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit();
}
$id = isset($_SESSION["adm"]) ? $_SESSION["adm"] : $_SESSION["user"];
$sql = "SELECT * FROM users WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello <?= $row["first_name"] ?> Profile</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg">
<?php require_once "../components/navbar.php"; ?>
<div class="container mt-5 p-3">
    <div class="center">
    <div class="card mb-3 shadow" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="../images/<?= $row["picture"] ?>" class="img-fluid rounded-start p-2" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h3 class="card-title">User Details:</h3>
        <p class="card-text"><b>Full Name: </b><?= $row["first_name"] . " " . $row["last_name"] ?></p>
        <p class="card-text"><b>Email: </b><?= $row["email"] ?></p>
        <p class="card-text"><b>Phone Number: </b> <?= $row["number"] ?></p>
        <p class="card-text"><b>Address: </b> <?= $row["address"] ?></p>
        <div class="row">
            <div class="col">
            <a href="edit_profile.php?id=<?= $row["id"] ?>" class="btn btn-primary">Edit Profile</a>
            </div>
            <div class="col">
            <a href="reset_password.php?id=<?= $row["id"] ?>" class="btn btn-warning">Edit Password</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
    </div>
</div>
</body>
</html>