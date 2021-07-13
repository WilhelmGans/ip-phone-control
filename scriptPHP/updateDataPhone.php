<?php
session_start();
session_start();
$login        = $_SESSION['login'];
$access       = $_SESSION['access'];
$today        = date("F j, Y, g:i a");
session_write_close();

$checkFind = "1";
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
if ($checkFind = "1") {
    $dbphones->query("UPDATE `customization` SET `properies` = '1' WHERE `id` = 1");
};
$myFile = "dataScanningPhone.txt";
$trus ="";
//$dd= $_GET['modal'];
while (true) {
    $stopWhile = $dbphones->query("SELECT `properies` FROM `customization` WHERE `id` = 1");
    $row = mysqli_fetch_assoc($stopWhile);
    $checkPhone = $row['checkPhone'];
    //$checkPhone = "0";
    file_put_contents('check.txt', "$checkPhone");
    if($checkPhone == "0"){
        $true = "9";
        fclose($fh);
        break 1;
    };
    $fh = fopen($myFile, 'w');
    error_reporting(0);
    $today = date("F j, Y, g:i a");
    fwrite($fh,$today."\r\n");
    fwrite($fh,"---------------"." Сканирование начато в: ".$today." "."----------------"."\r\n");
    $phonesCheckIPStatus = $dbphones->query("SELECT `id`, `ip`,`number`,`name`, `mac` FROM phones ORDER BY `number` ASC");
    insertAction(0, 'setting', $login , $access  , 'Запуск автоматического сканера сети', "Сканер запущен успешно. Сканирование всех телефонов запущено ", $linkRegistration,  'Scanner', $today);
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
            $errPhones = "error";
            insertAction(0, 'setting phone', $numberCheckPing, 'admin', 'Телефон не в сети', "При автоматическом сканировании телефон $numberCheckPing не в сети. <br> mac: $macForCheckPing; <br> ip: $ipForCheckPing <br> Телефон расположен у  $nameForCheckPing <br>", $linkRegistration,  'Scanner', $today);
            fwrite($fh,"--------------------".$numberCheckPing."---------".$ipForCheckPing."---------".$errPhones."--------------------"."\r\n");
        }else {
            $dbphones->query("UPDATE `phones` SET `check_ping` = '1' WHERE `id` = $idForCheckPing");
            $errPhones = "good";
            fwrite($fh,"--------------------".$numberCheckPing."---------".$ipForCheckPing."---------".$errPhones."--------------------"."\r\n");
        }
        //flush();
    };
    if($checkPhone == "0"){
        $true = "9";
        fclose($fh);
        break 1;
    };
    $checkFind = "0";
    fwrite($fh,"---------------"." Сканирование завершено в: ".$today." "."---------------"."\r\n");
    fclose($fh);
    sleep(10800); // 10800 3 часа спать
};

file_put_contents('check.txt', "stop");
?>