<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); # access or create session

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: pages/login.php");
    exit();
}

if (isset($_SESSION["adm"])) {
    header("Location: pages/dashboard.php");
    exit();
}

require_once "db_connect.php";

$id = $_SESSION["user"];
$sql = "SELECT * FROM users WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$ageFilter = isset($_GET['age']) ? intval($_GET['age']) : 0;
$sqlanimals = "SELECT * FROM `animals`";
if ($ageFilter > 8) {
    $sqlanimals .= " WHERE age > {$ageFilter}";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["adopt"])) {
    $petId = $_POST["pet_id"];
    $adoptionDate = date("Y-m-d H:i:s"); // Current timestamp
    
    // Update the pet status to 'Adopted'
    $updateStatusSql = "UPDATE animals SET status='Adopted' WHERE id = {$petId}";
    mysqli_query($conn, $updateStatusSql);
    
    // Insert into the pet_adoption table
    $insertAdoptionSql = "INSERT INTO pet_adoption (user_id, pet_id, adoption_date) VALUES ({$id}, {$petId}, '{$adoptionDate}')";
    
    if (mysqli_query($conn, $insertAdoptionSql)) {
        echo "<div class='alert alert-success' role='alert'>Congrats! Pet has been adopted</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Something went wrong, please try again later!</div>";
    }
}

$sqlanimals = "SELECT * FROM animals WHERE status = 'Available'";
$pResult = mysqli_query($conn, $sqlanimals);

$layout = "";

if (mysqli_num_rows($pResult) == 0) {
    $layout .= "No result found";
} else {
    while ($prow = mysqli_fetch_assoc($pResult)) {
        $layout .= "
        <div>
        <div class='card' style='width: 18rem;'>
        <img src='images/{$prow["picture"]}' class='card-img-top' alt='...'>
        <div class='card-body'>
          <h5 class='card-title'>Name: {$prow["name"]}</h5>
          <p class='card-text'><b>Gender: </b>{$prow["gender"]}</p>
           <p class='card-text'><b>Breed: </b>{$prow["breed"]}</p>
            <p class='card-text'><b>Size: </b>{$prow["size"]}</p>
             <p class='card-text'><b>Age: </b>{$prow["age"]}</p>
          <a href='animals/details.php?id={$prow["id"]}' class='btn btn-success'>Details</a>
          <form method='post' action=''>
            <input type='hidden' name='pet_id' value='{$prow["id"]}'>
            <input name='adopt' type='submit' class='btn btn-danger' value='Take me home'>
          </form>
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
    <title>Hello <?= $row["first_name"] ?></title>
    <link href="/style/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: rgb(189, 228, 191);">
    <?php require_once "components/navbar.php"; ?>

    <h1 class="text-center mt-5 mb-5">Welcome <?= $row["first_name"] . " " . $row["last_name"] ?></h1>

    <div class="container">
        <h4>Check out and adopt our pets!</h4>
        <a href="pages/senior.php" class="btn btn-primary">Show Seniors</a>
        <a id="unfiltera" class="btn btn-secondary">Show All</a>
        <div id="petsContainer" class="row row-cols-3 row-gap-3 mt-5">
            <?= $layout ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
</body>
</html>
