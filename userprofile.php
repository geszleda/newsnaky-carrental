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
        <div class="col-6"></div>
        <div class="col-2">
            <br><?php getEditButton() ?>
        </div>
    </div>
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
        <ul class="lead my-3">
            <li>' . $user->username . '</li>
            <li>' . $user->name     . '</li>
            <li>' . $user->email    . '</li>
        </ul>    
    ';
}

function displayDrivingLicenseData($drivingLicense){
    echo '
        <ul class="lead my-3">
            <li>' . $drivingLicense->cardnumber. '</li>
            <li>' . $drivingLicense->category     . '</li>
            <li>' . $drivingLicense->isAutomaticShifter   . '</li>
            <li>' . $drivingLicense->date   . '</li>
        </ul>    
    ';
}

function getEditButton(){
    echo '
        <a href="userprofile_edit.php">
            <button type="submit" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                </svg>
                    Szerkeszt
            </button>
        </a>';
}