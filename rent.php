<?php include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';

session_start();

if (isExistSession('user') && isExistPost('auto_id')){
    $userId = getUserId($_SESSION['user']);
    $autoID = $_POST['auto_id'];
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
?>