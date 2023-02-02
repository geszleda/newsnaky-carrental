<?php 

class DrivingLicense{

    
    public int $id;
    public string $category;
    public string $cardnumber;
    public bool $isAutomaticShifter;
    public string $date;

    function set_date($date){
        $this->date = $date;
    }

    function set_cardnumber($cardnumber){
        $this->cardnumber = $cardnumber;
    }

    function set_isAutomaticShifter($isAutomaticShifter){
        if ($isAutomaticShifter == "t"){
            $this->isAutomaticShifter = true;
        }else{
            $this->isAutomaticShifter = false;
        }
    }

    function set_category($category){
        $this->category = $category;
    }

    function set_id($id) {
        $this->id = $id;
    }
}

function getDrivingLicenseObject($userId){
    $query="SELECT * FROM jogositvany where ugyfel_id=" . $userId . ";";
    $db = getConnectedDb();
    $result=pg_query($db, $query);
    $columnCount=pg_num_fields($result);

    $drivingLicense = new DrivingLicense();

    for($j=0; $j<$columnCount; $j++){
        $rowColumnResult = pg_fetch_result($result, 0, $j);
        switch ($j) {
            case 0:
                $drivingLicense->set_id((int)$rowColumnResult);
                break;
            case 2:
                $drivingLicense->set_category($rowColumnResult);
                break;
            case 3:
                $drivingLicense->set_cardnumber($rowColumnResult);
                break;
            case 4:
                $drivingLicense->set_isAutomaticShifter($rowColumnResult);
                break;
            case 5:
                $drivingLicense->set_date($rowColumnResult);
                break;
        }
    }

    return $drivingLicense;
}

?>