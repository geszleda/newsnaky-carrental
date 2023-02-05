<?php   include_once 'header.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';
        include_once 'generalmainpage.php';

if (isExistSession('loginRequiredErrorMessage'))
{
    echo "<p class=\"red lead my-3\">" . $_SESSION['loginRequiredErrorMessage'] . "</p>";
    unset($_SESSION['loginRequiredErrorMessage']);
}else if (isExistSession('succesfulRentFeedback')){
    echo "<p class=\"green lead my-3\">" . $_SESSION['succesfulRentFeedback'] . "</p>";
    unset($_SESSION['succesfulRentFeedback']);
}else if (isExistSession('unsuccesfulRentFeedback')){
    echo "<p class=\"red lead my-3\">" . $_SESSION['unsuccesfulRentFeedback'] . "</p>";
    unset($_SESSION['unsuccesfulRentFeedback']); 
}

if (isExistGet('brand') && isExistGet('type') && isExistGet('img')){
    $brand = $_GET['brand'];
    $type = $_GET['type'];
    $img = $_GET['img'];

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
    } ?>

    <div class="d-flex flex-wrap justify-content-center">
        <div class="p-8 item borderedWithoutHoverOpacity">
            <p><img src="<?php echo $img ?>" class="maximizedWidth"></p>
            <p lead my-3>
                <form   action="autoprofile.php#priceCalculator"
                        method="GET">
                    <input type="hidden" name="brand" value="<?php echo $brand;?>">
                    <input type="hidden" name="type" value="<?php echo $type;?>">
                    <input type="hidden" name="img" value="<?php echo $img;?>">
                    <label class="lead my-3">
                        Kölcsönzés kezdete:
                        <input type="date" name="startDate" value="<?php echo $_GET['startDate'];?>"/>
                    </label>
                                                       
                    <label class="lead my-3">
                        Kölcsönzés vége:
                        <input type="date" name="endDate" value="<?php echo $_GET['endDate'];?>"/>
                    </label>
                    <p id='priceCalculator'><input type="submit" value="Árkalkuláció" class="btn btn-primary"></p>
                </form>
                <?php $price = calculatePrice($brand, $type) ?>
                <p class="lead my-3">Kölcsönzési díj: <?php echo $price ?> Ft</p>
                <form   action="rent.php"
                        method="POST">
                    <input type="hidden" name="auto_id" value="<?php echo getIdOfAvailableCar($brand, $type);?>">
                    <input type="hidden" name="discount" value="<?php echo getDiscountDependingOnDate();?>">
                    <input type="hidden" name="startDate" value="<?php echo $_GET['startDate'];?>">
                    <input type="hidden" name="endDate" value="<?php echo $_GET['endDate'];?>">
                    <input type="hidden" name="brand" value="<?php echo $brand;?>">
                    <input type="hidden" name="type" value="<?php echo $type;?>">
                    <input type="hidden" name="img" value="<?php echo $img;?>">
                    <p><input type="submit" value="--->FOGLALÁS<---" class="fs-4 btn btn-outline-primary"></p>
                </form>
            </p>
        </div>
    </div>
<?php
}

function getDailyFee($brand, $type){
    if (isExistGet('startDate') && isExistGet('endDate')){
        $db = getConnectedDb();
        $query="
            SELECT napidij FROM auto where marka='" . $brand . "' and tipus='" . $type . "';";
    
        $result=pg_query($db, $query);

        $dailyFee = (int)pg_fetch_result($result, 0, 0);
    
        return $dailyFee;
    }

    return 0;
}


function calculatePrice($brand, $type){
    if (isExistGet('startDate') && isExistGet('endDate')){
        $differencesInDays = getDifferencesInDate();
        $discountByDate = getDiscountDependingOnDate();
        $dailyFee = getDailyFee($brand, $type);

        $price =  $dailyFee * (int)$differencesInDays * ((100 - $discountByDate)/100);
    
        return $price;
    }

    return '-';
}

function getDifferencesInDate(){
    if (isExistGet('startDate') && isExistGet('endDate')){
        $startDate = strtotime($_GET['startDate']);
        $endDate = strtotime($_GET['endDate']);

        $differenceInSecond  = $endDate - $startDate;
        $differenceInDays = round($differenceInSecond / (60*60*24));

        return $differenceInDays + 1;
    }

    return 0;
}

function getDiscountDependingOnDate(){
    $differenceInDays = getDifferencesInDate();

    if ($differenceInDays > 7){
        return 10;
    }
    else if($differenceInDays > 5)
    {
        return 5;
    }

    return 0;
}

function getIdOfAvailableCar($brand, $type){
    $db = getConnectedDb();
    $query="
            SELECT id FROM auto where marka='" . $brand . "' and tipus='" . $type . "' 
            EXCEPT
            SELECT auto_id FROM kolcsonzes where kezdete <= CURRENT_DATE and vege >= CURRENT_DATE;";

    $result=pg_query($db, $query);

    return (int)pg_fetch_result($result, 0, 0);
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