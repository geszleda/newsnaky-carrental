<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';

if (!isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('index.php');
} ?>

<h1 class="display-4 fst-italic">Kölcsönzések</h1><br>

<?php
if(isExistGet('id')){
    $resultOfRents = getAllAutoRents($_GET['id']);
    drawtable($resultOfRents);
}

function getAllAutoRents($autoId){
    $query='
        SELECT kolcsonzes.id, kolcsonzes.kezdete, kolcsonzes.vege, kolcsonzes.kedvezmeny, ugyfel.nev, ugyfel.felhasznalonev, ugyfel.email
        FROM kolcsonzes
        JOIN ugyfel ON kolcsonzes.ugyfel_id=ugyfel.id
        WHERE auto_id=' . $autoId .'
        ORDER BY kolcsonzes.kezdete;';

    $db = getConnectedDb();
    
    return pg_query($db, $query);
}

function drawtable($resultOfRents){
    $columnCount = pg_num_fields($resultOfRents);
    $rowCount = pg_num_rows($resultOfRents);

    echo '
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Kölcsönzés azonosító</th>
                    <th scope="col">Kezdete</th>
                    <th scope="col">Vége</th>
                    <th scope="col">Kedvezmény (%)</th>
                    <th scope="col">Ügyfél név</th>
                    <th scope="col">Ügyfél felhasználónév</th>
                    <th scope="col">Ügyfél elérhetőség</th>
                    <th scope="col">Végösszeg</th>
                </tr>
            </thead>
        <tbody>';
        for ($i = 0; $i < $rowCount; $i++) {
        echo '
            <tr>';
            $startDate = '';
            $endDate = '';
            $discount = 0;
            for ($j = 0; $j <= $columnCount; $j++) {
                if ($j<$columnCount){
                    $rowColumnResult = pg_fetch_result($resultOfRents, $i, $j);
                    echo '<td>' . $rowColumnResult . '</td>';
                    $columnname = pg_field_name($resultOfRents, $j);
                    switch ($columnname) {
                        case "kezdete":
                            $startDate = $rowColumnResult;
                            break;
                        case "vege":
                            $endDate = $rowColumnResult;
                            break;
                        case "kedvezmeny":
                            $discount = $rowColumnResult;
                            break;
                    }
                }else{
                    echo '<td>' . calculatePrice($startDate, $endDate, $discount, $_GET['id']) . ' Ft </td>';
                }

            }
        echo '
            </tr>';
        }
    echo '
        </table>
    ';
}

function calculatePrice($startDate, $endDate, $discount, $autoId){
    $differencesInDays = getDifferencesInDate($startDate, $endDate);
    $dailyFee = getDailyFee($autoId);

    $price =  $dailyFee * (int)$differencesInDays * ((100 - $discount)/100);

    return $price;
}

function getDifferencesInDate($startDate, $endDate){
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $differenceInSecond  = $endDate - $startDate;
    $differenceInDays = round($differenceInSecond / (60*60*24));

    return $differenceInDays + 1;
}

function getDailyFee($autoId){
    $db = getConnectedDb();
    $query="
        SELECT napidij FROM auto where id=" . $autoId . ";";

    $result=pg_query($db, $query);

    $dailyFee = (int)pg_fetch_result($result, 0, 0);

    return $dailyFee;
}