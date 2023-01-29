<?php   include_once 'generalfunctions.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewSnaky CarRental</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
</head>
<body>
    <script type="module" src="script.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <header class="p-3 text-bg-dark">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2 text-secondary">Kezdőoldal</a></li>
                    <li><a href="offers.php" class="nav-link px-2 text-white">Kínálat</a></li>
            <?php
            if(isExistSession("user") && $_SESSION["user"]=="admin"){
                echo 
                    '<li><a href="adminview.php" class="nav-link px-2 text-white">Admin-kezelőfelület</a></li>
                    <li><a href="statistics.php" class="nav-link px-2 text-white">Kimutatások</a></li>';
            }?>
                    </ul>

            <?php
            if(!isExistSession("user")){ ?>
                <div class="text-end">
                <a href="login.php"><button type="button" class="btn btn-outline-light me-2">Bejelentkezés</button></a>
                <a href="registration.php"><button type="button" class="btn btn-info">Regisztráció</button></a>
                </div>
            <?php
            }else{ ?>
                <div class="text-end">
                Üdvözöllek, <?php echo $_SESSION['name']; ?>!
                <a href="logout.php"><button type="button" class="btn btn-outline-light me-2">Kijelentkezés</button></a>
                </div>         
            <?php
            } ?>
                </div>
            </div>
            </header>
        </div>
    </div>