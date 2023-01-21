<?php include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';

session_start();

if (isExistSession('user') && isExistPost('auto_id')){
    $userId = getUserId($_SESSION['user']);
    $autoId = $_POST['auto_id'];
    $discount = $_POST['discount'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if (!isUserEntitledToRentThisCar($userId, $autoId)){
        $_SESSION['unsuccesfulRentFeedback'] = "Önnek csak automataváltós jogosítványa van, ezért nem jogosult vezetni
        ezt az autót.";

        directToPage('autoprofile.php?brand=' . $_POST["brand"] . '&type=' . $_POST["type"] . '&img=' . $_POST["img"]);
    }else{
        $success = insertNewRent($userId, $autoId, $discount, $startDate, $endDate);

        if ($success){
            $_SESSION['succesfulRentFeedback'] = "Sikeres foglalás.";
        }else{
            $_SESSION['unsuccesfulRentFeedback'] = "Sikertelen foglalás, kérem próbálja újra.";
        }
    
        directToPage('autoprofile.php?brand=' . $_POST["brand"] . '&type=' . $_POST["type"] . '&img=' . $_POST["img"]);
    }
}else{
    $_SESSION['loginRequiredErrorMessage'] = "A foglaláshoz be kell jelentkezni";
    directToPage('autoprofile.php?brand=' . $_POST["brand"] . '&type=' . $_POST["type"] . '&img=' . $_POST["img"]);
}

function getUserId($user){
    $db = getConnectedDb();
    $query="
            SELECT id FROM ugyfel where felhasznalonev='" . $user . "';";

    $result=pg_query($db, $query);

    return (int)pg_fetch_result($result, 0, 0);
}

function insertNewRent($userId, $autoId, $discount, $startDate, $endDate){
    $db = getConnectedDb();
    $query="
        INSERT INTO kolcsonzes (id, ugyfel_id, auto_id, kedvezmeny, kezdete, vege)
        VALUES
            (nextval('kolcsonzes_sequence'), " .
            $userId . ", " .
            $autoId . ", " . 
            $discount . ",  DATE '" .
            $startDate . "', DATE '" . 
            $endDate . "');";

    $result=pg_query($db, $query);

    return $result;
}

function isUserEntitledToRentThisCar($userId, $autoId){
    $db = getConnectedDb();
    $query1="
        SELECT automatavaltos_e from jogositvany where ugyfel_id=" .$userId.";";

    $result1=pg_query($db, $query1);

    $isDriverHasOnlyAutomaticShifterDrivingLicense = pg_fetch_result($result1, 0, 0) == "t";

    $query2="
        SELECT automatavaltos_e from auto where id=" .$autoId.";";

    $result2=pg_query($db, $query2);

    $isAutomaticShifterCar = pg_fetch_result($result2, 0, 0) == "t";

    if ($isDriverHasOnlyAutomaticShifterDrivingLicense && !$isAutomaticShifterCar){
        return false;
    }

    return true;
}
?>