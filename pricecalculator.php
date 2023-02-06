<?php 

function calculatePrice2($startDate, $endDate, $discount, $dailyFee){
    $differencesInDays = getDifferencesInDate($startDate, $endDate);

    $price =  $dailyFee * (int)$differencesInDays * ((100 - $discount)/100);

    return $price;
}

function calculatePrice($startDate, $endDate, $discount, $autoId){
    $dailyFee = getDailyFee($autoId);

    return calculatePrice2($startDate, $endDate, $discount, $dailyFee);
}

function getDifferencesInDate($startDate, $endDate){
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $differenceInSecond  = $endDate - $startDate;
    $differenceInDays = round($differenceInSecond / (60*60*24));

    return $differenceInDays + 1;
}

function getDailyFee($autoId){
    $db = getConnectedDb();
    $query="
        SELECT napidij FROM auto where id=" . $autoId . ";";

    $result=pg_query($db, $query);

    $dailyFee = (int)pg_fetch_result($result, 0, 0);

    return $dailyFee;
}