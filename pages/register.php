<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit();
}

if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "../db_connect.php";
require_once "file_upload.php";

$error = false;
$fnameError = $emailError = $numbError = $lnameError = $passError = $addressError = $first_name = $last_name = $email = $number = $address = "";

if (isset($_POST["register"])) {
    $first_name = cleanInputs($_POST["first_name"]);
    $last_name = cleanInputs($_POST["last_name"]);
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);
    $number = cleanInputs($_POST["number"]);
    $picture = fileUpload($_FILES["picture"]);
    $address = cleanInputs($_POST["address"]);

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


    # simple validation for the password
    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "Password must be at least 6 chars!";
    }

    # simple validation for email
    if (empty($email)) {
        $error = true;
        $emailError = "Email can't be empty!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address!";
    } else {
        $query = "SELECT email FROM `users` WHERE email = '{$email}'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Email already in use!";
        }
    }

    # simple validation for number
    if (empty($number)) {
        $error = true;
        $numbError = "Phone number can't be empty!";
    }

    if (!$error) {
        $password = hash("sha256", $password); # hashing the password to random text and numbers

        $sql = "INSERT INTO `users`(`first_name`, `last_name`, `password`, `number`, `email`, `picture`, `address`) VALUES ('{$first_name}', '{$last_name}', '{$password}', '{$number}', '{$email}', '{$picture[0]}', '{$address}')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<div class='alert alert-success'>
               <p>New account has been created, $picture[1]</p>
           </div>";
            $first_name = $last_name = $email = $number = $address = "";
            header("refresh: 2; url= login.php");
        } else {
            echo "<div class='alert alert-danger'>
               <p>Something went wrong, please try again later!</p>
           </div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
    <div class="container">
        <h1 class="text-center p-5 mt-3 mb-3">Register form</h1>
        <div class="center text-center row">
        <form method="post" enctype="multipart/form-data" autocomplete="off" class="">
            <input type="text" class="form-control" placeholder="First name" name="first_name" value="<?= $first_name ?>">
            <p class="text-danger"><?= $fnameError; ?></p>
            <input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?= $last_name ?>">
            <p class="text-danger"><?= $lnameError ?></p>
            <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email ?>">
            <p class="text-danger"><?= $emailError ?></p>
            <input type="password" class="form-control" placeholder="Password" name="password">
            <p class="text-danger"><?= $passError ?></p>
            <input type="text" class="form-control" name="number" placeholder="Phone Number" value="<?= $number ?>">
            <p class="text-danger"><?= $numbError ?></p>
            <input type="text" class="form-control" name="address" placeholder="Address" value="<?= $address ?>">
            <p class="text-danger"><?= $addressError ?></p>
            <h5 class="center text-center">Load a picture</h5>
            <input type="file" class="form-control mb-3" name="picture">
            <input type="submit" class="btn btn-primary" value="Register" name="register">
            <a href="login.php" class="btn btn-danger">Back to Login</a>
        </form>
        </div>
        
    </div>
</body>

</html>