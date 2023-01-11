<?php

$db = null;

function getConnectedDb(){
    global $db;

    if ($db == null)
    {
        include 'connectiondata.php';

        echo '<h3>belépés az adatbázisba</h3> az első sor csak a hibaüzenet láthatóságáról gondoskodik<br>';
        error_reporting(E_ALL); ini_set('display_errors', '1');
        $dbDatas = "host=" . $host . " port=" . $port . " dbname=" . $dbname . " user=" . $user . " password=" . $password;
    
        $db = pg_connect($dbDatas) or die('Belépés nem sikerült. Hiba: ' . pg_last_error());;
        echo 'Kapcsolódás sikeres.';
        echo "<h3>Kapcsolati Informaciok</h3>\n";
        echo 'Adatbázis neve: ' . pg_dbname($db) . "<br />\n";
        echo 'Gép neve: ' . pg_host($db) . "<br />\n";
        echo 'Port: ' . pg_port($db) . "<br />\n";
    }


    return $db;
}

function kapcsolatLezar($db){
    pg_close(($db));
}


?>