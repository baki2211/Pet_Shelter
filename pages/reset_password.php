<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    // header("refresh: 3;url= login.php");
    exit();
}

$id = isset($_SESSION["adm"]) ? $_SESSION["adm"] : $_SESSION["user"];

require_once "../db_connect.php";

$error = false;
$opassError = $npassError = $rpassError = "";
$backLink = isset($_SESSION["adm"]) ? "dashboard.php" : "../home.php";

if (isset($_POST["reset"])) {
    $opass = cleanInputs($_POST["opass"]);
    $npass = cleanInputs($_POST["npass"]);
    $rpass = cleanInputs($_POST["rpass"]);

    # simple validation for old password

    if (empty($opass)) {
        $error = true;
        $opassError = "This input is required!";
    }

    # simple validation for new password

    if (empty($npass)) {
        $error = true;
        $npassError = "This input is required!";
    } elseif (strlen($npass) < 6) {
        $error = true;
        $npassError = "Password must be at least 6 chars!";
    }

    # simple validation for repeat password

    if (empty($rpass)) {
        $error = true;
        $rpassError = "This input is required";
    } elseif ($npass != $rpass) {
        $error = true;
        $npassError = "New password and repeat password not matched!";
    }


    if (!$error) {
        $opass = hash("sha256", $opass);
        $npass = hash("sha256", $npass);
        // i need to bring the current password from the database
        $sqlFind = "SELECT password FROM users WHERE id = {$id}";
        $result = mysqli_query($conn, $sqlFind);
        $row = mysqli_fetch_assoc($result);
        if ($row["password"] == $opass) {
            # update
            $sqlUpdate = "UPDATE `users` SET `password`='{$npass}' WHERE id = {$id}";
            if (mysqli_query($conn, $sqlUpdate)) {
                echo "<div class='alert alert-success'>
               <p>Password has been changed!</p>
           </div>";
            }
        } else {
            # the old password from the input is not matching the password from the database
            echo "<div class='alert alert-danger'>
               <p>The old password is not correct!</p>
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
    <title>Reset Password</title>
    <link href="../style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg">
    <?php require_once "../components/navbar.php" ?>

    <div class="container">
        <h1 class="text-center">Reset password</h1>
        <form method="post">
            <div class="d-flex">
                <input type="password" class="form-control mt-3" placeholder="Old password" name="opass" id="opass"><span class="btn btn-warning" onclick="showPassword()">&#128065;</span>
            </div>

            <p class="text-danger"><?= $opassError ?></p>
            <input type="password" class="form-control mt-3" placeholder="New password" name="npass">
            <p class="text-danger"><?= $npassError ?></p>
            <input type="password" class="form-control mt-3" placeholder="Repeat password" name="rpass">
            <p class="text-danger"><?= $rpassError ?></p>
            <input type="submit" class="btn btn-primary mt-3" name="reset" value="Reset password">
            <a class="btn btn-warning mt-3" href="<?= $backLink ?>">Back</a>
        </form>
    </div>


    <script>
        function showPassword() {
            let statusOfPassword = document.getElementById("opass").getAttribute("type");

            if (statusOfPassword == "password") {
                document.getElementById("opass").setAttribute("type", "text");
            } else {
                document.getElementById("opass").setAttribute("type", "password");
            }
        }
    </script>
</body>

</html>