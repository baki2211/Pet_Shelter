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

$error = false;
$passError = $email = $emailError = "";

if (isset($_POST["login"])) {
    $email = cleanInputs($_POST["email"]);
    $password = cleanInputs($_POST["password"]);


    # simple validation for email
    if (empty($email)) {
        $error = true;
        $emailError = "this input can't be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email";
    }


    # simple validation for password
    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty";
    }

    if (!$error) {
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM `users` WHERE email = '{$email}' AND password = '{$password}'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            if ($row["status"] == "adm") {
                # send you to the dashboard page
                $_SESSION["adm"] = $row["id"];
                header("Location: dashboard.php");
                exit();
            } else {
                # send you to the home page
                $_SESSION["user"] = $row["id"];
                header("Location: ../home.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
   
    <div class="container">
    <div class="center">
        <div class="row text-center">
            <div class="col">
                <div class="container p-5 login shadow">
                <h3>Login</h3>
            <form method="post">
            <input type="email" class="form-control mt-2" placeholder="Email" name="email" value="<?= $email ?>">
            <p class="text-danger"><?= $emailError ?></p>
            <input type="password" class="form-control mt-2" placeholder="Password" name="password">
            <p class="text-danger"><?= $passError ?></p>
            <input type="submit" class="btn btn-primary mt-2" name="login">
        </form>
        <p class="mt-2">Don't have an account? <a href="register.php">Register here</a></p>
            </div>
                </div>
            <div class="col">
                <div class="container">
                    <div class="center text-center p-2 mt-5">
                        <h1>Welcome to our Pet Shop!</h1>
                    <img src="https://cdn.pixabay.com/photo/2018/08/25/09/27/shop-3629607_1280.png" class="img-fluid" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>