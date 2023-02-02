<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
        include_once 'model/user.php';
        include_once 'model/drivinglicense.php';

if (!isExistSession("user")){
    directToPage('index.php');
}

$user = getUserObject($_SESSION["user"]);
$drivingLicense = $user->drivingLicense;?>

<div class="container">
<div class="row justify-content-center">
    <div class="col-10"></div>
        <div class="col-6 borderedWithoutHoverOpacity">
            <div class="alert alert-secondary lead my-3" role="alert">
                Személyes adatok:
            </div>

            <?php displayUserData($user) ?>

            <div class="alert alert-secondary lead my-3" role="alert">
            Jogosítvány adatok:
            </div>

            <?php displayDrivingLicenseData($drivingLicense); ?>
        </div>
    </div>
</div>

<?php

function displayUserData($user){
    echo '
        <ul>
            <li>' . $user->username . '</li>
            <li>' . $user->name     . '</li>
            <li>' . $user->email    . '</li>
        </ul>    
    ';
}

function displayDrivingLicenseData($drivingLicense){
    echo '
        <ul>
            <li>' . $drivingLicense->cardnumber. '</li>
            <li>' . $drivingLicense->category     . '</li>
            <li>' . $drivingLicense->isAutomaticShifter   . '</li>
            <li>' . $drivingLicense->date   . '</li>
        </ul>    
    ';
}