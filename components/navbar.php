<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 


$id = isset($_SESSION["adm"]) ? $_SESSION["adm"] : $_SESSION["user"];
$sql = "SELECT * FROM users WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<?php if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {?>
    <div class="div"></div>
    <?php } else{?>
<nav class="navbar navbar-expand-lg" style="background-color: #6f42c1;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Animal Shelter</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <?php if($_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/home.php'){ ?>
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a> <?php }else{ ?>
                        <a class="nav-link active" aria-current="page" href="../home.php">Home</a>   <?php }?>
                </li>
                <?php
                if (isset($_SESSION["user"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/user_profile.php">User Profile</a>
                    </li>
                    
                <?php  }else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/user_profile.php">User Profile</a>
                    </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../animals/index.php">Animals</a>
                </li> -->
               <?php } ?>
            </ul>
            <?php
            if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
            ?> 
                <div class="d-flex"> <p class="mt-1 p-1">Welcome :     </p>
                <?php if($_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/pages/user_profile.php'){ ?>
                <a class="navbar-brand" href="#">
                    <?php  } elseif ($_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/pages/edit_profile.php' || $_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/pages/dashboard.php') { ?>
                    <a class="navbar-brand" href="user_profile.php"><?php } else { ?>
                        <a class="navbar-brand" href="pages/user_profile.php"> <?php } ?>  
                    <?php if($_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/home.php'){ ?>
                        <img src="images/<?= $row["picture"] ?>" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> <?php }else{ ?>
                     <img src="../images/<?= $row["picture"] ?>" alt="Logo" width="30" height="24" class="d-inline-block align-text-top"> <?php } ?>
                        <?= $row["email"]?> </a>
                        <?php if($_SERVER['REQUEST_URI'] == '/EBEWD2_CR5_AngeloPane/home.php'){ ?>
                            <a class="btn btn-danger" href="pages/logout.php?logout">Logout</a><?php }else{ ?>
                    <a class="btn btn-danger" href="../pages/logout.php?logout">Logout</a><?php } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</nav> <?php } ?>