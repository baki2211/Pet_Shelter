<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit();
}
require_once "../db_connect.php";
require_once "file_upload.php";

$id = isset($_SESSION["adm"]) ? $_SESSION["adm"] : $_SESSION["user"];
$backLink = isset($_SESSION["adm"]) ? "dashboard.php" : "../home.php";
$sql = "SELECT * FROM users WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$fnameError = $lnameError = $numberError = $addressError = "";
$error = false;


if (isset($_POST["update"])) {
    $first_name = cleanInputs($_POST["first_name"]);
    $last_name = cleanInputs($_POST["last_name"]);
    $number = cleanInputs($_POST["number"]);
    $address = cleanInputs($_POST["address"]);
    $picture = fileUpload($_FILES["picture"]);

    # simple validation for first name
    if (empty($first_name)) { # if it is empty
        $error = true;
        $fnameError = "Please, type your first name!";
    } elseif (strlen($first_name) < 3) { # length of the first name must be more than 2 letters
        $error = true;
        $fnameError = "First name must have at least 3 chars!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) { # i want to have an error when i pass numbers 
        $error = true;
        $fnameError = "First name must contain only letters and spaces!";
    }


    # simple validation for last name
    if (empty($last_name)) { # if it is empty
        $error = true;
        $lnameError = "Please, type your last name!";
    } elseif (strlen($last_name) < 3) { # length of the last name must be more than 2 letters
        $error = true;
        $lnameError = "last name must have at least 3 chars!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) { # i want to have an error when i pass numbers 
        $error = true;
        $lnameError = "last name must contain only letters and spaces!";
    }

    if (empty($address)) {
        $error = true;
        $addressError = "Address can't be empty!";
    }
    if (empty($number)) {
        $error = true;
        $numberError = "Phone Number can't be empty!";
    }
    if (!$error) {
        if ($_FILES["picture"]["error"] == 4) {
            $sqlUpdate = "UPDATE `users` SET `first_name`='{$first_name}',`last_name`='{$last_name}',`number`='{$number}', `address`='{$address}' WHERE id = {$id}";
        } else {
            $sqlUpdate = "UPDATE `users` SET `first_name`='{$first_name}',`last_name`='{$last_name}', `number`='{$number}', picture = '{$picture[0]}', `address`='{$address}' WHERE id = {$id}";
        }
        if (mysqli_query($conn, $sqlUpdate)) {
            header("Location: " . $backLink);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
<?php require_once "../components/navbar.php"; ?>

<div class="container">
        <h1 class="text-center p-5 mt-3 mb-3">Update user details</h1>
        <div class="center text-center row">
        <form method="post" enctype="multipart/form-data">
        <h5 class="center text-center">Name</h5>
        <input type="text" class="form-control" placeholder="First name" name="first_name" value="<?= $row["first_name"] ?>">
        <p class="text-danger"><?= $fnameError; ?></p>
        <h5 class="center text-center">Surname</h5>
        <input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?= $row["last_name"] ?>">
        <p class="text-danger"><?= $lnameError ?></p>
        <h5 class="center text-center">Load a picture</h5>
        <input type="file" class="form-control" name="picture">
        <h5 class="center text-center">Phone Number</h5>
        <input type="text" class="form-control" name="number" placeholder="Phone Number" value="<?= $row["number"] ?>">
        <p class="text-danger"><?= $numberError ?></p>
        <h5 class="center text-center">Address</h5>
        <input type="text" class="form-control" name="address" placeholder="Address" value="<?= $row["address"] ?>">
        <p class="text-danger"><?= $addressError ?></p>
        <input type="submit" class="btn btn-primary" value="Update" name="update">
        <a class="btn btn-warning" href="<?= $backLink ?>">Back</a>
    </form>
        </div>
         </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

