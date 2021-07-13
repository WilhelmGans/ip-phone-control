<?php
$dsn = 'mysql:host=127.0.0.1;dbname=phones; charset=utf8';
$user = 'root';
$password = 'root';


try {
    $dbphones = new PDO($dsn, $user, $password);
    $dbphones->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (empty(($_POST['name'])));

}
catch (PDOException $e) {
  echo 'Подключение не удалось: ' . $e->getMessage();

}

/*global $data;
$data = array(); // в этот массив запишем то, что выберем из базы

$ta = $dbphones->query("SELECT `id`, `ip`, `port_pp` FROM `phones`.phone"); // сделаем запрос в БД
while($row = mysqli_fetch_assoc($ta)){ // оформим каждую строку результата                           // как ассоциативный массив
    $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
    //echo $data;

}
json_encode($data);*/



//получение данных из таблицы phone
function get_numberph_all () {
global $dbphones;
$phones2 = $dbphones->query("SELECT * FROM `phones`.phone ORDER BY id ASC");
return $phones2;
};



?>