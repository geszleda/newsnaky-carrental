<?php   include_once 'header.php';
        include_once 'generalfunctions.php';

    if (isExitsGet('brand')){
        echo 'Márka ' . $_GET['brand'];
    }
?>