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

function getAutoObject($autoId){
    $query='SELECT * FROM auto where id=' . $autoId .';';
    $db = getConnectedDb();
    $result=pg_query($db, $query);
    $columnCount=pg_num_fields($result);

    $auto = new Auto();

    for($j=0; $j<$columnCount; $j++){
        $rowColumnResult = pg_fetch_result($result, 0, $j);
        switch ($j) {
            case 0:
                $auto->set_id((int)$rowColumnResult);
                break;
            case 1:
                $auto->set_brand($rowColumnResult);
                break;
            case 2:
                $auto->set_type($rowColumnResult);
                break;
            case 3:
                $auto->set_isAutomaticShifter($rowColumnResult);
                break;
            case 4:
                $auto->set_dailyFee((int)$rowColumnResult);
                break;
            case 5;
                $auto->set_imagePath($rowColumnResult);
                break;
        }
    }

    return $auto;
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