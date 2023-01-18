<?php   include_once 'header.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
        include_once 'generalmainpage.php';

if (isExistGet('brand') && isExistGet('type')){
    $brand = $_GET['brand'];
    $type = $_GET['type'];

    $countOfAvailableCars = countHowManyAvailable($brand, $type);

    if($countOfAvailableCars == 0) {
        echo    '<p class="lead my-3"><b>
                    Sajnáljuk, jelenleg egy autó sem elérhető ebből a típusból. <br><br>
                    Legközelebbi dátum, amikor felszabadul az autó: ' . checkNextAvailability($brand, $type) . 
                '</b></p>';
    }else{
        echo    '<p class="lead my-3">
                    Jelenleg <b>' . $countOfAvailableCars . ' darab</b> elérhető ebből a típusból.
                </p>';
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

function checkNextAvailability($brand, $type){
    $db = getConnectedDb();
    $query="
        SELECT vege + 1 FROM auto
        JOIN kolcsonzes ON auto.id = kolcsonzes.auto_id
        WHERE marka='" . $brand . "' and tipus='" . $type . "' and vege>CURRENT_DATE
        ORDER BY vege;";

    $result=pg_query($db, $query);

    return pg_fetch_result($result, 0, 0);
}

include_once 'footer.php';
?>