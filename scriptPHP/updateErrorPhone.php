<?php
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
    error_reporting(0);
    $today = date("F j, Y, g:i a");
    $phonesCheckIPStatus = $dbphones->query("SELECT `id`, `ip`,`number`,`name`, `mac` FROM phones ORDER BY `check_ping` ASC");
    foreach ($phonesCheckIPStatus as $phoneCheckIPStatus) {
        $numberCheckPing = $phoneCheckIPStatus['number'];
        $ipForCheckPing = $phoneCheckIPStatus['ip'];
        $idForCheckPing = $phoneCheckIPStatus['id'];
        $macForCheckPing = $phoneCheckIPStatus['mac'];
        $nameForCheckPing = $phoneCheckIPStatus['name'];
        $portForCheckPing = "80";
        $tB = microtime(true);
        $fP = fsockopen($ipForCheckPing, $portForCheckPing, $errno, $errstr, 1);
        $tA = microtime(true);
        if (!$fP) {
            $dbphones->query("UPDATE `phones` SET `check_ping` = '0' WHERE `id` = $idForCheckPing");
            insertAction(0, 'setting phone', $numberCheckPing, 'admin', 'Телефон не в сети', "При ручном сканировании телефон $numberCheckPing не в сети. <br> mac: $macForCheckPing; <br> ip: $ipForCheckPing <br> Телефон расположен у  $nameForCheckPing <br>", $linkRegistration,  'Scanner', $today);
        }else {
            $dbphones->query("UPDATE `phones` SET `check_ping` = '1' WHERE `id` = $idForCheckPing");
        }
    };
    $checkFind = "0";
    $urlRef = $_SERVER['HTTP_REFERER'];
    header("location: $urlRef");
?>