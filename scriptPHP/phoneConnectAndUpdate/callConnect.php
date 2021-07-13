<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
$today = date("F j, Y, g:i a");
$numberPhoneGET = $_GET['numberPhone'];
$ipGET = $_GET['ip'];
$macGET = $_GET['mac'];
$rec=$_GET['call'];
$numberCall = $_GET['call_id'];
$numberPhoneGETErrors = $dbphones->query("SELECT `number`,`name` FROM `phones` WHERE `number`='$numberPhoneGET'");
$numberPhoneGETErrors = mysqli_fetch_assoc($numberPhoneGETErrors);
$numberPhoneGETError = $numberPhoneGETErrors['number'];
$namePhoneGETError = $numberPhoneGETErrors['name'];
//echo $numberPhoneGETError;
if($numberPhoneGETError == ""){
	$numberPhoneGETErrors = $dbphones->query("SELECT `ip`,`name`  FROM `phones` WHERE `ip`='$ipGET'");
	$numberPhoneGETErrors = mysqli_fetch_assoc($numberPhoneGETErrors);
	$numberPhoneGETError = $numberPhoneGETErrors['ip'];
	$namePhoneGETError = $numberPhoneGETErrors['name'];
	if($numberPhoneGETError == ""){
		$linkOptions = "number=$numberPhoneGET&ip=$ipGET&mac=$macGET";
		$linkHref = 'href="/page/formRegistrationPhoneWithError.php?';
		$linkquotes = '"';
		$linkRegistration="<a $linkHref$linkOptions$linkquotes>Зарегистрировать телефон</a>";
		insertAction(0, 'setting phone', 'Phone', 'admin', 'Ошибка телефон не найден в базе',"Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET <br>", $linkRegistration, $numberPhoneGET, $today);
		$dbphones->query("UPDATE `customization` SET `properies` = '$numberPhoneGETError' WHERE `id`='2'");
	}else{
		$dbphones->query("UPDATE `customization` SET `properies` = 'success' WHERE `id`='2'");
		if ($_GET['call'] == "up"){
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '2', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
			insertAction(0, 'setting phone', 'phone', 'admin', 'Call on', "Телефон c номером: $numberPhoneGET установил вызов с $numberCall <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
			$message = "Телефон c номером: " . $numberPhoneGET . " установил вызов с $numberCall. Телефон расположен у " . $namePhoneGETError;
		}elseif($_GET['call'] == "down"){
			//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
			insertAction(0, 'setting phone', 'phone', 'admin', 'call off', "Телефон c номером: $numberPhoneGET завершил вызов с $numberCall <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
			$message = "Телефон c номером: " . $numberPhoneGET . " озавершил вызов с $numberCall. Телефон расположен у " . $namePhoneGETError;
		}
	}
}else{
	//echo $numberPhoneGETError +11;
	//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
	if ($_GET['call'] == "up"){
		//echo $numberPhoneGETError +11;
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '2', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
    insertAction(0, 'setting phone', 'phone', 'admin', 'Call on', "Телефон c номером: $numberPhoneGET установил вызов с $numberCall <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
    $message = "Телефон c номером: " . $numberPhoneGET . " установил вызов с $numberCall. Телефон расположен у " . $namePhoneGETError;
	}elseif($_GET['call'] == "down"){
		//echo $numberPhoneGETError + 6500;
		//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
    insertAction(0, 'setting phone', 'phone', 'admin', 'call off', "Телефон c номером: $numberPhoneGET завершил вызов с $numberCall <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
    $message = "Телефон c номером: " . $numberPhoneGET . " озавершил вызов с $numberCall. Телефон расположен у " . $namePhoneGETError;
	}
}
echo $rec;
//http://192.168.44.2/scriptPHP/phoneConnectAndUpdate/callConnect.php?ip=$ip&mac=$mac&numberPhone=$active_user&call_id=$call_id&call=up
//https://192.168.44.2/scriptPHP/phoneConnectAndUpdate/callConnect.php?ip=$ip&mac=$mac&numberPhone=$active_user&call_id=$call_id&call=down
?>