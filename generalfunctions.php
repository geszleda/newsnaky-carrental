<?php include_once 'data/dbConnection.php';

function isExistGet($string){
    return isset($_GET[$string]) && strlen(trim($_GET[$string])) != 0;
}

function isExistPost($string){
    return isset($_POST[$string]) && strlen(trim($_POST[$string])) != 0;
}


function isExistSession($string){
    return isset($_SESSION[$string]) && strlen(trim($_SESSION[$string])) != 0;
}

function isExistSessionArray($string){
    return isset($_SESSION[$string]) && count($_SESSION[$string])>0;
}

function directToPage($page){
    header('Location: ' .$page);
    die;
}

function checkIfAlreadyExists($table, $columnname, $data){
    $db = getConnectedDb();
    $query="
            SELECT count(*) FROM " . $table . " where " . $columnname . "='" . $data . "';";

    $result=pg_query($db, $query);

    if ((int)pg_fetch_result($result, 0, 0) == 0)
    {
        return false;
    }

    return true;
}

?>