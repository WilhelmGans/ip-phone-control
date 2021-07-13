<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';

    $ipPhone = array();
    
        $ip = $_POST['status'];
        $res = mysqli_query($dbphones, "SELECT `ip` FROM `phones` WHERE `type_phone` = 'primary' ORDER BY `number` ASC");
        while ($row = mysqli_fetch_assoc($res)){
            $allStatusPhone[] = $row;
        }
    
    echo json_encode($allStatusPhone);
?>