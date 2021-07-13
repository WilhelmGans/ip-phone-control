<?php
    $phonesScoreForPieCart = getStatusIpPhoneCheckPing();
    foreach ($phonesScoreForPieCart as $phoneScoreForPieCart) {
        $checkPing = $phoneScoreForPieCart['check_ping'];
        if ($checkPing === "0"){
            $phonesError += 1;
        }else{
            $phonesGood += 1;   
        };
    };
?>