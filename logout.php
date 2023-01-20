<?php   include_once 'generalfunctions.php';

    session_start();
    session_destroy();
    directToPage('index.php');
?>
