<?php 

class Auto{
    
    public int $id;
    public string $brand;
    public string $type;
    public bool $isAutomaticShifter;
    public int $dailyFee;
    public string $imagePath;

    function set_imagePath($imagePath){
        $this->imagePath = $imagePath;
    }

    function set_dailyFee($dailyFee){
        $this->dailyFee = $dailyFee;
    }

    function set_isAutomaticShifter($isAutomaticShifter){
        if ($isAutomaticShifter == "t"){
            $this->isAutomaticShifter = true;
        }else{
            $this->isAutomaticShifter = false;
        }
    }

    function set_type($type){
        $this->type = $type;
    }


    function set_brand($brand){
        $this->brand = $brand;
    }

    function set_id($id) {
        $this->id = $id;;
      }
}


function getAutoObject($autoId){
    $query='SELECT * FROM auto where id=' . $autoId .';';
    $db = getConnectedDb();
    $result=pg_query($db, $query);
    $columnCount=pg_num_fields($result);

    $auto = new Auto();

    for($j=0; $j<$columnCount; $j++){
        $rowColumnResult = pg_fetch_result($result, 0, $j);
        switch ($j) {
            case 0:
                $auto->set_id((int)$rowColumnResult);
                break;
            case 1:
                $auto->set_brand($rowColumnResult);
                break;
            case 2:
                $auto->set_type($rowColumnResult);
                break;
            case 3:
                $auto->set_isAutomaticShifter($rowColumnResult);
                break;
            case 4:
                $auto->set_dailyFee((int)$rowColumnResult);
                break;
            case 5;
                $auto->set_imagePath($rowColumnResult);
                break;
        }
    }

    return $auto;
}
?>