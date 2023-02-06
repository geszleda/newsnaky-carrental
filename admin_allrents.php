<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
        include_once 'pricecalculator.php';

if (!isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('index.php');
} ?>

<h1 class="display-4 fst-italic">Összes kölcsönzés</h1><br>

<?php
$resultOfRents = getAllAutoRents();
drawtable($resultOfRents);

function getAllAutoRents(){
    $query='
        SELECT t.id, t.kezdete, t.vege, t.nev, t.felhasznalonev, t.email, auto.marka, auto.tipus, auto.napidij, t.kedvezmeny 
        FROM      
        (SELECT kolcsonzes.id, kolcsonzes.auto_id, kolcsonzes.kezdete, kolcsonzes.vege, ugyfel.nev, ugyfel.felhasznalonev, ugyfel.email, kolcsonzes.kedvezmeny
            FROM kolcsonzes
            JOIN ugyfel ON kolcsonzes.ugyfel_id=ugyfel.id) t
        JOIN auto ON t.auto_id=auto.id
        ORDER BY t.kezdete;';

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
                    <th scope="col">Ügyfél név</th>
                    <th scope="col">Ügyfél felhasználónév</th>
                    <th scope="col">Ügyfél elérhetőség</th>
                    <th scope="col">Márka</th>
                    <th scope="col">Típus</th>
                    <th scope="col">Napidíj</th>
                    <th scope="col">Kedvezmény (%)</th>
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
            $dailyFee = 0;
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
                        case "napidij":
                            $dailyFee = $rowColumnResult;
                            break;
                    }
                }else{
                    echo '<td>' . calculatePrice2($startDate, $endDate, $discount, $dailyFee) . ' Ft </td>';
                }

            }
        echo '
            </tr>';
        }
    echo '
        </table>
    ';
}