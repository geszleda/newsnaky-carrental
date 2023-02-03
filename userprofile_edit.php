<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';
        include_once 'model/user.php';

if (!isExistSession("user")){
    directToPage('index.php');
}

$user = getUserObject($_SESSION["user"]);
$drivingLicense = $user->drivingLicense;?>

<div class="container">
<div class="row justify-content-center">
    <div class="col-10"></div>
        <div class="col-6 borderedWithoutHoverOpacity">
            <form action="userprofile_edit.php" method="post">
                <input type="hidden" name="edited" value="edited">
                <div class="alert alert-secondary lead my-3" role="alert">
                    Személyes adatok:
                </div>

                <?php displayUserForm($user) ?>

                <div class="alert alert-secondary lead my-3" role="alert">
                    Jogosítvány adatok:
                </div>

                <?php displayDrivingLicenseForm($drivingLicense); ?>

                <br><br>
                <input type="submit" value="FELÜLÍR" class="fs-4 btn btn-primary"><br><br>
            </form>
        </div>
    </div>
</div>

<?php
function displayUserForm($user){
    echo '
        <label for="name" class="lead my-3">Teljes név:</label><br>
        <input type="text" name="name" value="' . $user->name . '"><br>

        <label for="username" class="lead my-3">Felhasználónév:</label><br>
        <input type="text" name="username" disabled="disabled" value="' . $user->username . '"><br>

        <label for="password" class="lead my-3">Jelszó:</label><br>
        <input type="password" name="password"><br>

        <label for="password2" class="lead my-3">Jelszó ismétlés:</label><br>
        <input type="password" name="password2"><br>

        <label for="email" class="lead my-3">Email-cím:</label><br>
        <input type="text" name="email"  value="' . $user->email . '"><br>';
}

function displayDrivingLicenseForm($drivingLicense){
    echo '
        <label for="cardnumber" class="lead my-3">Azonosítószám:</label><br>
        <input type="text" name="cardnumber"  value="' . $drivingLicense->cardnumber . '"><br>
        
        <label for="category" class="lead my-3">Kategória:</label><br>
        <select name="category">
            <option value="M"' . isSelected("M", $drivingLicense->category) . '>M</option>
            <option value="A"' . isSelected("A", $drivingLicense->category) . '>A</option>
            <option value="B1"' . isSelected("B1", $drivingLicense->category) . '>B1</option>
            <option value="B"' . isSelected("B", $drivingLicense->category) . '>B</option>
            <option value="C1"' . isSelected("C1", $drivingLicense->category) . '>C1</option>
            <option value="C"' . isSelected("C", $drivingLicense->category) . '>C</option>
            <option value="D1"' . isSelected("D1", $drivingLicense->category) . '>D1</option>
            <option value="D"' . isSelected("D", $drivingLicense->category) . '>D</option>
        </select><br>
        
        <input type="radio" name="isAutomaticShifter" value="true" ' . getCheckedAttributeIfApplicable($drivingLicense->isAutomaticShifter, true) . '>
        <label for="isAutomaticShifter" class="lead my-3">automataváltós</label><br>
        <input type="radio" name="isAutomaticShifter" value="false" ' . getCheckedAttributeIfApplicable($drivingLicense->isAutomaticShifter, false) .'>
        <label for="isAutomaticShifter" class="lead my-3">manuális váltó</label><br>
        
        <label for="date" class="lead my-3">Kiállítás dátuma:</label><br>
        <input type="date" name="date">';
}

function isSelected($actualCategory, $expectedCategory){
    if ($expectedCategory == $actualCategory){
        return 'selected="selected"';
    }
}

function getCheckedAttributeIfApplicable($actualValue, $expectedValue){
    if ($actualValue == $expectedValue){
        return 'checked';
    }

}