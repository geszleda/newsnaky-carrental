<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
        include_once 'model/auto.php';
        include_once 'generalfunctions.php';
        include_once 'generalmainpage.php';

if (!isExistSession("user") || $_SESSION["user"]!="admin"){
    directToPage('index.php');
}
?>
                <h1 class="display-4 fst-italic">Szerkeszthető járművek (admin nézet)</h1><br>
                <?php getNewButton(); ?>
                <p class="lead my-3">Válassza ki a szerkeszteni vagy törölni kívánt járműveket!</p>
                <?php
                    $query='SELECT * FROM auto order by id desc';
                    $db = getConnectedDb();
                    $result=pg_query($db, $query);

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
                        ?>
                        <p><img src="<?php echo $auto->imagePath ?>" class="preview"></p>
                        <h3> Azonosító: <?php echo $auto->id ?> </h3><br>
                        <h4><?php echo $auto->brand ?> <?php echo $auto->type ?> </h4>
                        <p> 
                        <?php
                            getEditButton($auto->id);
                            getDeleteButton($auto->id);
                            if (isCurrentlyRented($auto->id)){
                                echo '<p class="green">Jelenleg kölcsönzés alatt áll.</p>';
                            }else{
                                echo '<p class="red">Jelenleg nem kölcsönzik.</p>';
                            }
                        ?></p>
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

<?php

function isCurrentlyRented($autoId){
    $db = getConnectedDb();
    $query="
        SELECT COUNT(*) FROM
            (SELECT * FROM kolcsonzes where auto_id=" .$autoId. " and kezdete <= CURRENT_DATE and vege >= CURRENT_DATE) t;";

    $result=pg_query($db, $query);

    $isCurrentlyRented = (int)pg_fetch_result($result, 0, 0);

    return $isCurrentlyRented > 0;
}

function getDeleteButton($autoId){
    echo '
        <a href="admin_autoprofile.php?id=' .$autoId. '&requestType=delete">
            <button type="button" class="btn btn-outline-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                </svg>
                Töröl
            </button>
        </a>';
}

function getEditButton($autoId){
    echo '
        <a href="admin_autoprofile.php?id=' .$autoId. '&requestType=edit">
            <button type="submit" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                </svg>
                    Szerkeszt
            </button>
        </a>';
}

function getNewButton(){
    echo '
    <a href="admin_autoprofile.php?id=0&requestType=addNew">
        <button type="button" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
            </svg>
                Új autó hozzáadása
        </button>
    </a>';
}

include_once 'footer.php'; ?>