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
                    <li><a href="index.php" class="nav-link px-2 text-white">Kezdőoldal</a></li>
                    <li><a href="offers.php" class="nav-link px-2 text-white">Kínálat</a></li>
            <?php
            if(isExistSession("user")){
                if($_SESSION["user"]=="admin"){
                    echo '
                        <li><a href="adminview.php" class="nav-link px-2 text-white">Admin-kezelőfelület</a></li>
                        <li><a href="admin_allrents.php" class="nav-link px-2 text-white">Összes kölcsönzés</a></li>
                        <li><a href="statistics.php" class="nav-link px-2 text-white">Kimutatások</a></li>';
                }else{
                    echo '
                        <li>' . getUserPicture() . '
                        <a href="userprofile.php" class="nav-link px-2 text-white">Profil</a></li>
                        <a href="user_rents.php" class="nav-link px-2 text-white">Foglalásaim</a></li>';
                }
            } ?>
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

<?php

function getUserPicture(){
    echo '
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
    </svg>';
}

?>