<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';
?>
                <h1 class="display-4 fst-italic">Bérlemények</h1>
                <p class="lead my-3">Válassza ki az Önnek legmegfelelőbb járművet!</p>
                <?php
                    $query='SELECT distinct marka, tipus, kepHivatkozas FROM auto';
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
                        <div class="p-2 item bordered gap-3">
                    <?php
                        $auto = new Auto();
                        
                        for($j=0; $j<$column; $j++){
                            $rowColumnResult = pg_fetch_result($result, $i, $j);
                            switch ($j) {
                                case 0:
                                    $auto->set_brand($rowColumnResult);
                                    break;
                                case 1:
                                    $auto->set_type($rowColumnResult);
                                    break;
                                case 2:
                                    $auto->set_imagePath($rowColumnResult);
                                    break;
                            }
                        }
                        ?>
                        <p><img src="<?php echo $auto->imagePath ?>" class="preview"></p>
                        <h4><?php echo $auto->brand ?> <?php echo $auto->type ?> </h4>
                        <?php echo
                        "<p><a href=\"autoprofile.php?brand=" . $auto->brand . "&type=" . $auto->type . "\">Tovább az autó profiljára:</a></p>"; ?>
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