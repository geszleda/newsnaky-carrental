<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
?>

<div class="container">
<div class="row justify-content-center">
    <div class="col-10"></div>
        <div class="col-6 borderedWithoutHoverOpacity">
            <?php
            if (isExistPost('registered')) {
                $isValidData = checkValidityOfRegistrationData();

                if ($isValidData)
                    doRegistrate();

                displayErrorMessage();
                displaySuccessMessage();
            }
            displayRegistrationForm(); ?>
            <br>
        </div>
    </div>
</div>

<?php

function checkValidityOfRegistrationData(){
    $_SESSION['error'] = '';
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (!isExistPost('name') || !isExistPost('username') || !isExistPost('password') || !isExistPost('password2') || !isExistPost('email') ||
        !isExistPost('cardnumber') || !isExistPost('category') || !isExistPost('isAutomaticShifter') || !isExistPost('date')){
        $_SESSION['error'] .= "Nem tölött ki minden mezőt. ";
        return false;
    }

    if ($password != $password2){
        $_SESSION['error'] .= "A két jelszó nem egyezik. ";
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] .= "Az e-mail cím nem érvényes. ";
    }

    if (checkIfAlreadyExists('ugyfel', 'felhasznalonev', $_POST['username'])){
        $_SESSION['error'] .= "Már létezik ilyen felhasználónév. ";    
    }

    if (checkIfAlreadyExists('ugyfel', 'email', $_POST['email'])){
        $_SESSION['error'] .= "Már beregisztráltak ezzel az e-mail címmel. ";    
    }

    return !isExistSession('error');
}

function doRegistrate(){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $db = getConnectedDb();

    $query = "
        INSERT INTO ugyfel (id, nev, felhasznalonev, jelszo, email)
        VALUES
        (nextval('ugyfel_sequence'), '" . $name . "', '" . $username . "', '" . $password . "', '" . $email . "');";

    $successUser = pg_query($db, $query);

    $query = "
        SELECT max(id) from ugyfel";
    
    $result =  pg_query($db, $query);
    $userId = (int)pg_fetch_result($result, 0, 0);

    $cardnumber = $_POST['cardnumber'];
    $category = $_POST['category'];
    $isAutomaticShifter = $_POST['isAutomaticShifter'];
    $date = $_POST['date'];

    $query = "
        INSERT INTO jogositvany (id, ugyfel_id, azonositoszam, kategoria, automatavaltos_e, kiallitas_idopontja)
        VALUES
        (nextval('jogositvany_sequence'), " . $userId . ", '" . $cardnumber . "', '" . $category . "', " . $isAutomaticShifter . "
        , '" . $date . "');";

    $successDrivingLicense = pg_query($db, $query);

    if ($successUser && $successDrivingLicense){
        $_SESSION['success'] .= "Sikeres regisztráció. ";
        return;
    }

    $_SESSION['error'] .= "Valami probléma történt, sikertelen regisztráció. ";
}

function displaySuccessMessage(){
    if (isExistSession('success'))
    {
        echo "<p class=\"green\">" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
}

function displayErrorMessage(){
    if (isExistSession('error'))
    {
        echo "<p class=\"red\">" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
}

function displayRegistrationForm(){
    echo '
    <div class="alert alert-secondary lead my-3" role="alert">
        Személyes adatok:
    </div>
    <form action="registration.php" method="post">
        <input type="hidden" name="registered" value="registered">

        <label for="name" class="lead my-3">Teljes név:</label><br>
        <input type="text" name="name"><br><br>

        <label for="username" class="lead my-3">Felhasználónév:</label><br>
        <input type="text" name="username"><br><br>

        <label for="password" class="lead my-3">Jelszó:</label><br>
        <input type="password" name="password"><br><br>

        <label for="password2" class="lead my-3">Jelszó ismétlés:</label><br>
        <input type="password" name="password2"><br><br>

        <label for="email" class="lead my-3">Email-cím:</label><br>
        <input type="text" name="email"><br><br>';

        alertUserAboutDrivingLicenseResponsibility();

        displayDrivingLicenseForm();
    echo '
        <br><br>
        <input type="submit" value="REGISZTRÁCIÓ" class="btn btn-primary alignRight">
    </form>';
}

function alertUserAboutDrivingLicenseResponsibility(){
    echo '
    <div class="alert alert-danger" role="alert">
        Felhívjuk figyelmét, hogy biztonsági okok miatt köteles megadni jogosítványa adatait!<br>
        A kölcsönzés ideje alatt történt baleset vagy károkozás esetén a jogosítvány tulajdonosa kereshető fel, attól függetlenül, hogy
        valójában ki vezette a járművet. Így azt ajánljuk, hogy a kölcsönzött autót csak Ön vezesse, ne adja át másnak!<br>
        NEM kölcsönözhet olyan járművet, melyet a jogosítványa értelmében nem vezethet, azonban lehetősége lesz más, jogosult személy
        adatait megadni, azaz mások javára is kölcsönözhet a másik személy adatainak megadásával.
    </div>';
}

function displayDrivingLicenseForm(){
    echo '
        <div class="alert alert-secondary lead my-3" role="alert">
            Jogosítvány adatok:
        </div>
        <label for="cardnumber" class="lead my-3">Azonosítószám:</label><br>
        <input type="text" name="cardnumber"><br><br>
        
        <label for="category" class="lead my-3">Kategória: (ha többet birtokol, kérjük jelölje be a legmagasabbat)</label><br>
        <select name="category">
            <option value="M">M</option>
            <option value="A">A</option>
            <option value="B1">B1</option>
            <option value="B">B</option>
            <option value="C1">C1</option>
            <option value="C">C</option>
            <option value="D1">D1</option>
            <option value="D">D</option>
        </select><br><br>
        
        <input type="radio" name="isAutomaticShifter" value="true">
        <label for="isAutomaticShifter" class="lead my-3">automataváltós</label>
        <input type="radio" name="isAutomaticShifter" value="false">
        <label for="isAutomaticShifter" class="lead my-3">manuális váltó</label><br><br>
        
        <label for="date" class="lead my-3">Kiállítás dátuma:</label><br>
        <input type="date" name="date">';
}
?>