<?php
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
session_start();
$login        = $_SESSION['login'];
$access       = $_SESSION['access'];
$today        = date("F j, Y, g:i a");
session_write_close();
$botStart = $dbphones->query("UPDATE `customization` SET `botCheck`= '1' WHERE `id` = '1'  ");
insertAction(0, 'setting', $login, $access, 'Бот', "Бот успешно запущен", $linkRegistr, $login, $today);
insertAction(1, 'setting', $login, $access, 'Бот', "Бот успешно запущен", $linkRegistr, $login, $today);
?>