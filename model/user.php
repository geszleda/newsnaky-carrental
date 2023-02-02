<?php include_once 'drivinglicense.php';

class User{
    
    public int $id;
    public string $username;
    public string $name;
    public string $password;
    public string $email;

    public DrivingLicense $drivingLicense;

    function set_id($id) {
        $this->id = $id;
    }

    function set_username($username){
        $this->username = $username;
    }

    function set_name($name){
        $this->name = $name;
    }

    function set_password($password){
        $this->password = $password;
    }

    function set_email($email){
        $this->email = $email;
    }

    function set_drivingLicense($drivingLicense){
        $this->drivingLicense = $drivingLicense;
    }
}


function getUserObject($username){
    $query="SELECT * FROM ugyfel where felhasznalonev='" . $username . "';";
    $db = getConnectedDb();
    $result=pg_query($db, $query);
    $columnCount=pg_num_fields($result);

    $user = new User();

    for($j=0; $j<$columnCount; $j++){
        $rowColumnResult = pg_fetch_result($result, 0, $j);
        switch ($j) {
            case 0:
                $user->set_id((int)$rowColumnResult);
                break;
            case 1:
                $user->set_name($rowColumnResult);
                break;
            case 2:
                $user->set_username($rowColumnResult);
                break;
            case 3:
                $user->set_password($rowColumnResult);
                break;
            case 4:
                $user->set_email($rowColumnResult);
                break;
        }
    }

    $user->set_drivingLicense(getDrivingLicenseObject($user->id));

    return $user;
}
?>