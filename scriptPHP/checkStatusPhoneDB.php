<?
$id = $_COOKIE["id"];
require $_SERVER['DOCUMENT_ROOT']."/generate/connect.php";

$query = $dbphones->query("SELECT `timestamp` FROM `phones` ORDER BY `timestamp` DESC LIMIT 1");
$numrows = mysqli_fetch_assoc($query);
$numrows = $numrows['timestamp'];
if($numrows > 0){
    setcookie("DataChanged", "Y", time()+40,"/");
    //$dbphones->query("UPDATE `phones` SET `timestamp` = '0' WHERE `timestamp` = '1'");
}else {
    setcookie("DataChanged", "N", time()+40,"/");
}

?>
<html>
    <head>
        <meta http-equiv='refresh' content='20'>
    </head>
    <body>
    </body>
</html>