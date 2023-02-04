<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';
        include_once 'model/user.php';

if (!isExistSession("user")){
    directToPage('index.php');
}

$user = getUserObject($_SESSION["user"]);
$drivingLicense = $user->drivingLicense;

if (isExistPost("edited")){
    handleEditAttempt($user, $drivingLicense);
    displayErrorMessage();
    displaySuccessMessage();

    $user = getUserObject($_SESSION["user"]);
    $drivingLicense = $user->drivingLicense;
}

?>

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
        <input type="date" name="date" value="' . $drivingLicense->date . '">';
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

function handleEditAttempt($user, $drivingLicense){
    $_SESSION['error'] = '';
    $_SESSION['success'] = '';

    $isValid = checkValidityOfUserAndDrivingLicenseData($user);

    if ($isValid){
        $editedUser = overwriteUserObject($user);
        $editedDrivingLicense = overwriteDrivingLicenseObject($drivingLicense);
        if ($editedUser){
            doEditUser($editedUser);
        }
        if ($editedDrivingLicense){
            doEditDrivingLicense($editedDrivingLicense);
        }
    }
}

function doEditUser($editedUser)
{
    $db = getConnectedDb();

    $query = "
        UPDATE ugyfel
        SET nev ='" . $editedUser->name . "', jelszo ='" . $editedUser->password . "', email ='" . $editedUser->email . "'  
        WHERE id=" . $editedUser->id;

    $isSuccess = pg_query($db, $query);

    if ($isSuccess) {
        $_SESSION['success'] .= 'A személyes adatok sikeresen frissültek.';
    } else {
        $_SESSION['error'] .= 'Hiba történt, a személyes adatok nem kerültek frissítésre.';
    }
}

function doEditDrivingLicense($editedDrivingLicense){
    $db = getConnectedDb();

    $query = "
        UPDATE jogositvany
        SET kategoria ='" . $editedDrivingLicense->category . "', azonositoszam ='" .  $editedDrivingLicense->cardnumber . "', 
        automatavaltos_e =" . convertBoolToString($editedDrivingLicense->isAutomaticShifter) . ", kiallitas_idopontja='" . $editedDrivingLicense->date ."'   
        WHERE id=" . $editedDrivingLicense->id;

    $isSuccess = pg_query($db, $query);
    if ($isSuccess){
        $_SESSION['success'] .= 'A jogosítvány adatok sikeresen frissültek.';
    }
    else{
        $_SESSION['error'] .= 'Hiba történt, a jogosítvány adatok nem kerültek frissítésre.';
    }
}

function overwriteUserObject($originalUserObject){
    $isAnythingEdited = false;
    $editedUser = new User();
    $editedUser->set_id($originalUserObject->id);
    $editedUser->set_username($originalUserObject->username);

    if (isExistPost("password") && $originalUserObject->password!=$_POST["password"])
    {
        $editedUser->set_password($_POST["password"]);
        $isAnythingEdited = true;
    }else{
        $editedUser->set_password($originalUserObject->password);
    }

    if (isExistPost("name") && $originalUserObject->name!=$_POST["name"])
    {
        $editedUser->set_name($_POST["name"]);
        $isAnythingEdited = true;
    }else{
        $editedUser->set_name($originalUserObject->name);
    }

    if (isExistPost("email") && $originalUserObject->email!=$_POST["email"])
    {
        $editedUser->set_email($_POST["email"]);
        $isAnythingEdited = true;
    }else{
        $editedUser->set_email($originalUserObject->email);
    }

    if ($isAnythingEdited){
        return $editedUser;
    }
    $_SESSION['error'] .= "Nincsenek új személyes adatok megadva.";
    return false;
}

function overwriteDrivingLicenseObject($originalDrivingLicenseObject){
    $isAnythingEdited = false;
    $editedDrivingLicense = new DrivingLicense();
    $editedDrivingLicense->set_id($originalDrivingLicenseObject->id);

    if (isExistPost("category") && $originalDrivingLicenseObject->category!=$_POST["category"])
    {
        $editedDrivingLicense->set_category($_POST["category"]);
        $isAnythingEdited = true;
    }else{
        $editedDrivingLicense->set_category($originalDrivingLicenseObject->category);
    }

    if (isExistPost("cardnumber") && $originalDrivingLicenseObject->cardnumber!=$_POST["cardnumber"])
    {
        $editedDrivingLicense->set_cardnumber($_POST["cardnumber"]);
        $isAnythingEdited = true;
    }else{
        $editedDrivingLicense->set_cardnumber($originalDrivingLicenseObject->cardnumber);
    }

    if (isExistPost("isAutomaticShifter") && convertBoolToString($originalDrivingLicenseObject->isAutomaticShifter)!=$_POST["isAutomaticShifter"])
    {
        $editedDrivingLicense->set_isAutomaticShifter($_POST["isAutomaticShifter"]);
        $isAnythingEdited = true;
    }else{
        $editedDrivingLicense->set_isAutomaticShifter($originalDrivingLicenseObject->isAutomaticShifter);
    }

    if (isExistPost("date") && $originalDrivingLicenseObject->date!=$_POST["date"])
    {
        $editedDrivingLicense->set_date($_POST["date"]);
        $isAnythingEdited = true;
    }else{
        $editedDrivingLicense->set_date($originalDrivingLicenseObject->date);
    }

    if ($isAnythingEdited){
        return $editedDrivingLicense;
    }
    $_SESSION['error'] .= "Nincsenek új jogosítvány adatok megadva.";
    return false;
}

function checkValidityOfUserAndDrivingLicenseData($user){
    if (isExistPost('password') && isExistPost('password2')){
        if ($_POST['password'] != $_POST['password2']){
            $_SESSION['error'] .= "A két jelszó nem egyezik. ";
        }
    }

    if ($user->email != $_POST['email']){
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] .= "Az e-mail cím nem érvényes. ";
        }
    
        if (checkIfAlreadyExists('ugyfel', 'email', $_POST['email'])){
            $_SESSION['error'] .= "Már beregisztráltak ezzel az e-mail címmel. ";    
        }
    }

    return !isExistSession('error');
}