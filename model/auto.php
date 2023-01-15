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
        $this->isAutomaticShifter = $isAutomaticShifter;
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
?>