<?php   include_once 'header.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
        include_once 'generalmainpage.php';

if (isExistGet('brand') && isExistGet('type')){
    $brand = $_GET['brand'];
    $type = $_GET['type'];

    $countOfAvailableCars = countHowManyAvailable($brand, $type);

    if($countOfAvailableCars == 0) {
        echo 'Sajnáljuk, jelenleg egy autó sem elérhető ebből a típusból.';
    }else{
        echo 'Jelenleg ' . $countOfAvailableCars . ' darab elérhető ebből a típusból.';
    }
}

function countHowManyAvailable($brand, $type){
    $db = getConnectedDb();
    $query="
        SELECT COUNT(*) FROM
            (SELECT id FROM auto where marka='" . $brand . "' and tipus='" . $type . "' 
            EXCEPT
            SELECT auto_id FROM kolcsonzes where kezdete <= CURRENT_DATE and vege >= CURRENT_DATE) t;";

    $result=pg_query($db, $query);

    return (int)pg_fetch_result($result, 0, 0);
}

include_once 'footer.php';
?>