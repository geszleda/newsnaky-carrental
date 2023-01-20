<?php include_once 'generalfunctions.php';

session_start();

if (isExistSession('user')){
    echo 'Ide jön majd a foglalás';
}else{
    $_SESSION['loginRequiredErrorMessage'] = "A foglaláshoz be kell jelentkezni";
    directToPage('autoprofile.php?brand=' . $_POST["brand"] . '&type=' . $_POST["type"] . '&img=' . $_POST["img"]);
}
?>