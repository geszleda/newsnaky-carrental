<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
?>
<br>
<div class="carprint"></div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
            <div class="col-12 px-0">
                <h1 class="display-4 fst-italic">Bérlemények</h1>
                <p class="lead my-3">Válassza ki az Önnek legmegfelelőbb járművet!</p>
                <?php
                    $query='select * from auto';
                    $db = getConnectedDb();
                    $result=pg_query($db, $query);
                    if (!$result){
                        print 'hibas lekerdezes.';echo pg_last_error($db).'<br>';echo pg_errormessage($db).'<br>';
                    }

                    $row=pg_num_rows($result);
                    $column=pg_num_fields($result);

                    ?>
                    <div class="d-flex flex-wrap justify-content-center">
                    <?php
                    for($i=0; $i<$row; $i++){
                        ?>
                        <div class="p-2 item bordered">
                    <?php
                        $auto = new Auto();
                        
                        for($j=0; $j<$column; $j++){
                            $rowColumnResult = pg_fetch_result($result, $i, $j);
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
                                    $auto->set_isAutomaticShifter((bool)$rowColumnResult);
                                    break;
                                case 4:
                                    $auto->set_dailyFee((int)$rowColumnResult);
                                    break;
                                case 5:
                                    $auto->set_imagePath($rowColumnResult);
                                    break;
                            }
                        }
                        ?>
                        <p>Auto id: <?php echo $auto->id ?> </p>
                        <p>Auto márka: <?php echo $auto->brand ?> </p>
                        <p>Auto típus: <?php echo $auto->type ?> </p>
                        <p>Auto automataváltós: <?php echo $auto->isAutomaticShifter ?> </p>
                        <p>Auto napidíj: <?php echo $auto->dailyFee ?> </p>
                        </div>
                    <?php
                    }
                ?>
                </div>
                <p class="lead mb-0"></a></p>
            </div>
        </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>