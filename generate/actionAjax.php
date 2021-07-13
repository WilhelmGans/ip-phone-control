<?php
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';

$allActions = array();
if (isset($_POST['start']) && is_numeric($_POST['start'])){
    $start = $_POST['start'];
    $res = mysqli_query($dbphones, "SELECT * FROM `actions` ORDER BY `id` DESC LIMIT {$start}, 10");
    while ($row = mysqli_fetch_assoc($res)){
        $allActions[] = $row;
    }
}
echo json_encode($allActions);
?>

