<?php
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';

$allStatusPhone = array();

    $status = $_POST['status'];
    $res = mysqli_query($dbphones, "SELECT `number`,`check_ping`,`block`, `floor` FROM `phones` ");
    while ($row = mysqli_fetch_assoc($res)){
        $allStatusPhone[] = $row;
    }

echo json_encode($allStatusPhone);
?>