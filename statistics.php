<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';

if (!isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('index.php');
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2"></div>
            <div class="col-6">
            <p class="lead my-3">Legnagyobb árbevételt generáló jármű: <?php echo getIncomeGenerator(); ?></p> 
            <p class="lead my-3">Járműtípusok, melyeket az elmúlt 6 hónapban senki sem kölcsönzött: <?php echo getUnpopularCarsInLastMonth(); ?></p> 
            </div>
        <div class="col-2"></div>
    </div>
</div>

<?php


    function getIncomeGenerator(){
        $db = getConnectedDb();

        $query="
            SELECT auto.marka, auto.tipus, sum(napidij) FROM kolcsonzes
            join auto on kolcsonzes.auto_id=auto.id group by auto.marka, auto.tipus order by sum desc limit 1;";

        $result=pg_query($db, $query);

        return pg_fetch_result($result, 0, 0) . ' ' . pg_fetch_result($result, 0, 1) . ' (' . pg_fetch_result($result, 0, 2) . ' Ft)';
    }

    function getUnpopularCarsInLastMonth(){
        $db = getConnectedDb();

        $query="
            SELECT marka, tipus from auto
            EXCEPT
            SELECT distinct auto.marka, auto.tipus FROM kolcsonzes
            join auto on kolcsonzes.auto_id=auto.id
            where kolcsonzes.kezdete > (SELECT CURRENT_DATE - 180) and kolcsonzes.kezdete < (SELECT CURRENT_DATE);";

        $result=pg_query($db, $query);
        
        $row=pg_num_rows($result);

        $resultArray = '';
        for ($i=0;$i<$row;$i++){
            $resultArray = $resultArray . pg_fetch_result($result, $i, 0) . ' ' . pg_fetch_result($result, $i, 1) . ',<br>';
        }

        return $resultArray;
    }

?>