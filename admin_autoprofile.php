<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';
        include_once 'imagesaver.php';

if (!isExistGet('id') || !isExistGet('requestType') || !isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('adminview.php');
}

$auto = null;

if ($_GET['requestType'] != "addNew"){
    $auto = getAutoObject($_GET['id']);
}

if (isExistPost('edited')){
    doEditExistingAuto($auto->id);

    $auto = getAutoObject($_GET['id']);
}

if (isExistPost('deleted')){
    doDeleteAuto($auto->id);

    directToPage('adminview.php');
}

if (isExistPost('added')){
    doAddAuto();

    directToPage('adminview.php');
}

if ($_GET['requestType'] == "edit" || $_GET['requestType'] == "delete"){?>
    <div class="col-5 px-0">
        <div class="col-10 p-8 item borderedWithoutHoverOpacity maximizedWidth2 justify-content-center">
            <?php
            if ($_GET['requestType'] == "edit"){
            echo '<form action="admin_autoprofile.php?id=' .$auto->id. '&requestType=edit" method="post" enctype="multipart/form-data">
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
                <input type="number" name="dailyFee" min="0" max="99999999" step="1000" value="<?= $auto->dailyFee?>"><br><br>

                <label for="img" class="lead my-3">Képhivatkozás:</label>
                <input type="file" name="img">

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
else if($_GET['requestType'] == "addNew"){?>
        <div class="col-5 px-0">
        <div class="col-10 p-8 item borderedWithoutHoverOpacity maximizedWidth2 justify-content-center">
            <form action="<?= 'admin_autoprofile.php?id=0&requestType=addNew' ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="added" value="added">

                <label for="brand" class="lead my-3">Márka:</label>
                <input type="text" name="brand"><br><br>

                <label for="type" class="lead my-3">Típus:</label>
                <input type="text" name="type"><br><br>

                <input type="radio" name="isAutomaticShifter" value="true">
                <label for="isAutomaticShifter" class="lead my-3">automataváltós</label><br>
                <input type="radio" name="isAutomaticShifter" value="false">
                <label for="isAutomaticShifter" class="lead my-3">manuális váltó</label><br><br>

                <label for="dailyFee" class="lead my-3">Napidíj:</label>
                <input type="number" name="dailyFee" min="10000" max="99999999" step="1000"><br><br>

                <label for="img">Képhivatkozás:</label>
                <input type="file" name="img">

                <p><input type="submit" value="HOZZÁAD" class="fs-4 btn btn-success"></p>
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

    var_dump(isset($_FILES['img']));
    if (isset($_FILES['img'])){
        $imagePath = uploadNewCarImage();
        var_dump($imagePath);

        $query = "
        UPDATE auto
        SET kephivatkozas = '" . $imagePath . "'  
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

function doAddAuto(){
    $db = getConnectedDb();

    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $isAutomaticShifter = $_POST['isAutomaticShifter'];
    $dailyFee = $_POST['dailyFee'];

    $imagePath = '';
    if (isset($_FILES['img'])){
        $imagePath = uploadNewCarImage();
    }

    $query = "
    INSERT INTO auto (id, marka, tipus, automatavaltos_e, napidij, kepHivatkozas)
    VALUES
      (nextval('auto_sequence'), '" . $brand . "', '" . $type . "', " . $isAutomaticShifter . ", " . $dailyFee . ", '" . $imagePath . "');";

    pg_query($db, $query);
}

function uploadNewCarImage(){
    $db = getConnectedDb();

    $imageId = uniqid();

    $imagePath = generateImagePath($imageId, $_FILES['img']);
    saveImage($imagePath, $_FILES['img']);

    return $imagePath;
}
?>