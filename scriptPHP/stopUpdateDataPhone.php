<?php
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
header("location: /page/adminSpecification.php?id=6");
$data = 'stop';
file_put_contents('check.txt', $data);
$dbphones->query("UPDATE customization SET `properies` = '0' WHERE `id` = 1");
session_start();
$login        = $_SESSION['login'];
$access       = $_SESSION['access'];
$today        = date("F j, Y, g:i a");
session_write_close();
insertAction(0, 'setting', $login , $access  , 'Остановка автоматического сканера сети', "Сканер завершил процесс успешно. Сканирование всех телефонов завершено. ", $linkRegistration,  'Scanner', $today);

?>