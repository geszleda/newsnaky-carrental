<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';

if (!isExistGet('id') || !isExistGet('requestType') || !isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('adminview.php');
}

$auto = getAutoObject($_GET['id']);

if (isExistPost('edited')){
    doEditExistingAuto($auto->id);

    $auto = getAutoObject($_GET['id']);
}

if (isExistPost('deleted')){
    doDeleteAuto($auto->id);

    ///directToPage('adminview.php');
}

if ($_GET['requestType'] == "edit" || $_GET['requestType'] == "delete"){?>
    <div class="col-5 px-0">
        <div class="col-10 p-8 item borderedWithoutHoverOpacity maximizedWidth2 justify-content-center">
            <?php
            if ($_GET['requestType'] == "edit"){
            echo '<form action="admin_autoprofile.php?id=' .$auto->id. '&requestType=edit" method="post">
                <input type="hidden" name="edited" value="edited">';}
            else if ($_GET['requestType'] == "delete"){
            echo '<form action="admin_autoprofile.php?id=' .$auto->id. '&requestType=delete" method="post">
                <input type="hidden" name="deleted" value="deleted">';}?>

                <label for="id" class="lead my-3">Azonosító:</label>
                <input type="text" disabled="disabled" name="id" value="<?= $auto->id?>"><br><br>

                <label for="brand" class="lead my-3">Márka:</label>
                <input type="text" name="brand" value="<?= $auto->brand?>"><br><br>

                <label for="type" class="lead my-3">Típus:</label>
                <input type="text" name="type" value="<?= $auto->type?>"><br><br>

                <input type="radio" name="isAutomaticShifter" value="true" <?= getCheckedAttributeIfApplicable($auto->isAutomaticShifter, true) ?>>
                <label for="isAutomaticShifter" class="lead my-3">automataváltós</label><br>
                <input type="radio" name="isAutomaticShifter" value="false" <?= getCheckedAttributeIfApplicable($auto->isAutomaticShifter, false) ?>>
                <label for="isAutomaticShifter" class="lead my-3">manuális váltó</label><br><br>

                <label for="dailyFee" class="lead my-3">Napidíj:</label>
                <input type="number" name="dailyFee" min="10000" max="99999999" step="1000" value="<?= $auto->dailyFee?>"><br><br>

                <label for="img" class="lead my-3">Képhivatkozás:</label>
                <input type="file" name="img" value="<?= $auto->imagePath?>">

        <?php  if ($_GET['requestType'] == "edit"){
            echo '<p><input type="submit" value="FELÜLÍR" class="fs-4 btn btn-outline-primary"></p>';
        }else if($_GET['requestType'] == "delete"){
            echo '<p><input type="submit" value="TÖRÖL" class="fs-4 btn btn-outline-danger"></p>';
        }?>
            </form>
        </div>
    </div>
<?php
}


function getCheckedAttributeIfApplicable($actualValue, $expectedValue){
    if ($actualValue == $expectedValue){
        return 'checked';
    }

    return '';
}

function doEditExistingAuto($autoId){
    $db = getConnectedDb();

    $query = "
        UPDATE auto
        SET marka ='" . $_POST['brand'] . "', tipus ='" . $_POST['type'] . "', automatavaltos_e =" . $_POST['isAutomaticShifter'] . ",
            napidij =" . (int)$_POST['dailyFee'] . "  
        WHERE id=" . $autoId;

    pg_query($db, $query);

    if (isExistPost('img')){
        $query = "
        UPDATE auto
        SET kephivatkozas = '" . $_POST['img'] . "'  
        WHERE id=" . $autoId;

        pg_query($db, $query);
    }
}

function doDeleteAuto($autoId){
    $db = getConnectedDb();

    $query = "
        BEGIN;
        DELETE FROM kolcsonzes  
        WHERE auto_id=" . $autoId . ";
        DELETE FROM auto  
        WHERE id=" . $autoId . ";
        COMMIT;";


    pg_query($db, $query);
}
?>