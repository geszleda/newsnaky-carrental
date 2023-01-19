<?php   include_once 'header.php';
        include_once 'generalmainpage.php';
        include_once 'generalfunctions.php';
        include_once 'data/dbConnection.php';

handleLoginAttempt();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2"></div>
            <div class="col-3">
                <?php 
                    if (isExistSession('error'))
                    {
                        echo "<p class=\"red\">" . $_SESSION['error'] . "</p>";
                        unset($_SESSION['error']);
                    }
                ?>
                <form   action="login.php"
                        method="POST">
                    <label class="lead my-3">
                        Felhasználónév: &emsp;
                        <input type="text" name="user"/>
                    </label>
                    <br>
                    <label class="lead my-3">
                        Jelszó: &emsp;&emsp;&emsp;&emsp;&emsp;
                        <input type="password" name="password" />
                    </label>
                    <br>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input type="submit" value="BEJELENTKEZÉS" class="btn btn-primary">
                </form>
            </div>
        <div class="col-2"></div>
    </div>
</div>

<?php


function handleLoginAttempt(){
    if (isExistPost('user') && isExistPost('password'))
    {
         $user = $_POST['user'];
         $password = $_POST['password'];
        if (checkIfUserAndPasswordIsCorrect($user, $password))
        {
            $_SESSION['user'] = $user;
            $_SESSION['name'] = getFullNameOfUser($user);
            
            directToPage('index.php');
        }else
        {
            $_SESSION['error'] = "Felhasználónév vagy jelszó hibás";
        }
    }
}

function checkIfUserAndPasswordIsCorrect($user, $password)
{
    $db = getConnectedDb();
    $query="
            SELECT count(*) FROM ugyfel where felhasznalonev='" . $user . "' and jelszo='" . $password . "';";

    $result=pg_query($db, $query);

    $isCorrect = false;
    if ((int)pg_fetch_result($result, 0, 0) == 1)
    {
        $isCorrect = true;
    }

    return $isCorrect;
}

function getFullNameOfUser($user)
{
    $db = getConnectedDb();
    $query="
            SELECT nev FROM ugyfel where felhasznalonev='" . $user . "';";

    $result=pg_query($db, $query);

    return pg_fetch_result($result, 0, 0);
}
?>