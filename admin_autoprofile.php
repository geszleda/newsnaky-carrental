<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';

if (!isExistGet('id') || !isExistGet('requestType') || !isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('adminview.php');
}

$auto = getAutoObject($_GET['id']);

if ($_GET['requestType'] == "edit"){?>
    <div class="p-8 item borderedWithoutHoverOpacity">
        <form action="admin_autoprofile.php" method="post">

            <label for="id">Azonosító:</label>
            <input type="text" disabled="disabled" name="id" value="<?= $auto->id?>"><br><br>

            <label for="id">Márka:</label>
            <input type="text" name="id" value="<?= $auto->brand?>"><br><br>

            <label for="id">Típus:</label>
            <input type="text" name="id" value="<?= $auto->type?>"><br><br>

            <input type="radio" name="isAutomaticShifter" value="true" <?= getCheckedAttributeIfApplicable($auto->isAutomaticShifter, true) ?>>
            <label for="html">automataváltós</label><br>
            <input type="radio" name="isAutomaticShifter" value="false" <?= getCheckedAttributeIfApplicable($auto->isAutomaticShifter, false) ?>>
            <label for="css">manuális váltó</label><br><br>

            <label for="quantity">Napidíj:</label>
            <input type="number" name="quantity" min="10000" max="99999999" step="1000" value="<?= $auto->dailyFee?>"><br><br>

            <label for="myfile">Képhivatkozás:</label>
            <input type="file" name="imagePah" value="<?= $auto->imagePath?>">
        </form>
    </div>
<?php
}

function getCheckedAttributeIfApplicable($actualValue, $expectedValue){
    if ($actualValue == $expectedValue){
        return 'checked';
    }

    return '';
}
?>