<?php   include_once 'generalfunctions.php';
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
            if(!(isExistSession("user") && $_SESSION["user"]!="admin")){
                echo 
                    '<li><a href="#" class="nav-link px-2 text-white">Feltöltés</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Kimutatások</a></li>';
            }?>
                    </ul>

                    <div class="text-end">
                    <button type="button" class="btn btn-outline-light me-2">Bejelentkezés</button>
                    <button type="button" class="btn btn-info">Regisztráció</button>
                    </div>
                </div>
            </div>
            </header>
        </div>
    </div>