<?php include_once 'generalfunctions.php';

if (isExistSession('user')){
    echo 'Ide jön majd a foglalás';
}else{
    echo 'User nincs bejelentkezve';
}
?>