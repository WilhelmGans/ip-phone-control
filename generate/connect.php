<?php
set_time_limit(700);
$user = 'root';
$password = 'root';
$dbphones = mysqli_connect("127.0.0.1", "$user" , "$password", "phones-2");

If (!$dbphones){
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
};


?>