<?php

function isExitsGet($string){
    return isset($_GET[$string]) && strlen(trim($_GET[$string])) != 0;
}

function isExistPost($string){
    return isset($_POST[$string]) && strlen(trim($_POST[$string])) != 0;
}


function isExistSession($string){
    return isset($_SESSION[$string]) && strlen(trim($_SESSION[$string])) != 0;
}

function isExistSessionArray($string){
    return isset($_SESSION[$string]) && count($_SESSION[$string])>0;
}

function directToPage($page){
    header('Location: ' .$page.'.php');
    die;
}

?>