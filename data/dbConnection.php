<?php

$db = null;

function getConnectedDb(){
    global $db;

    if ($db == null)
    {
        include 'connectiondata.php';

        error_reporting(E_ALL); ini_set('display_errors', '1');
        $dbDatas = "host=" . $host . " port=" . $port . " dbname=" . $dbname . " user=" . $user . " password=" . $password;
    
        $db = pg_connect($dbDatas) or die('Belépés nem sikerült. Hiba: ' . pg_last_error());;
    }


    return $db;
}

function kapcsolatLezar($db){
    pg_close(($db));
}


?>