<?php   include_once 'header.php';
        include_once 'data/dbConnection.php';
?>
<br>
<div class="carprint"></div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">Bérlemények</h1>
                <p class="lead my-3">Válassza ki az Önnek legmegfelelőbb járművet!</p>
                <?php
                    echo '<h3>Auto tábla kiírása</h3>';
                    $kerdes='select * from auto';
                    $db = getConnectedDb();
                    $eredmeny=pg_query($db,$kerdes);
                    if (!$eredmeny){
                        print 'hibas lekerdezes.';echo pg_last_error($db).'<br>';echo pg_errormessage($db).'<br>';
                    }

                    $sor=pg_num_rows($eredmeny);
                    $oszlop=pg_num_fields($eredmeny);
                    echo "Sorok szama: " .$sor  . "<br />";
                    echo "Oszlopok szama: " . $oszlop . "<br />";

                    $adatTomb[$sor][$oszlop] = null;

                    echo '<table border="2">';
                    for($j=0; $j<$oszlop; $j++){
                        echo "<th>Mező neve: " . pg_field_name($eredmeny, $j) . "</th>";
                        echo "<th>Mező adattípusa:</th>";
                        echo "<th>Mező tárolási mérete:</th>";
                    }
                    for($i=0; $i<$sor; $i++){
                        echo '<tr>';
                        for($j=0; $j<$oszlop; $j++){
                            echo "<td>" . pg_fetch_result($eredmeny, $i, $j) . "</td>";
                            echo "<td>"  . pg_field_type($eredmeny, $j) . "</td>";
                            echo "<td>"  . pg_field_size($eredmeny, $j) . "</td>";
                            $adatTomb[$sor][$oszlop] = pg_fetch_result($eredmeny, $i, $j);
                        }
                    echo '</tr>';
                    }
                    echo '</table>';

                ?>
                <p class="lead mb-0"></a></p>
            </div>
        </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>