<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
$today = date("F j, Y, g:i a");
$numberPhoneGET = $_GET['numberPhone'];
$ipGET = $_GET['ip'];
$macGET = $_GET['mac'];
$rec=$_GET['dnd'];
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
		if ($_GET['dnd'] == "up"){
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '3', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
			insertAction(1, 'setting phone', 'phone', 'admin', 'DND on', "Телефон c номером: $numberPhoneGET включил режим не беспокоить <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
			$message = "Телефон c номером: " . $numberPhoneGET . " включил режим не беспокоить. Телефон расположен у " . $namePhoneGETError;
		}elseif($_GET['dnd'] == "down"){
			//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
			insertAction(1, 'setting phone', 'phone', 'admin', 'DND off', "Телефон c номером: $numberPhoneGET выключил режим не беспокоить <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
			$message = "Телефон c номером: " . $numberPhoneGET . " отключил режим не беспокоить. Телефон расположен у " . $namePhoneGETError;
		}
	}
}else{
	//echo $numberPhoneGETError +11;
	//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
	if ($_GET['dnd'] == "up"){
		//echo $numberPhoneGETError +11;
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '3', `ip` = '$ipGET', `mac` = '$macGET' WHERE `number` = '$numberPhoneGET'");
		insertAction(1, 'setting phone', 'phone', 'admin', 'DND on', "Телефон c номером: $numberPhoneGET включил режим не беспокоить <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
		$message = "Телефон c номером: " . $numberPhoneGET . " включил режим не беспокоить. Телефон расположен у " . $namePhoneGETError;
	}elseif($_GET['dnd'] == "down"){
		//echo $numberPhoneGETError + 6500;
		//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `number` = '$numberPhoneGET'");
		insertAction(1, 'setting phone', 'phone', 'admin', 'DND off', "Телефон c номером: $numberPhoneGET выключил режим не беспокоить <br> mac: $macGET; <br> ip: $ipGET <br> Телефон расположен у  $namePhoneGETError <br>", $linkRegistration, $numberPhoneGET, $today);
		$message = "Телефон c номером: " . $numberPhoneGET . " отключил режим не беспокоить. Телефон расположен у " . $namePhoneGETError;
	}
}
echo $rec;
//https://192.168.44.2/scriptPHP/phoneConnectAndUpdate/phoneReceiverUp.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=up
//https://192.168.44.2/scriptPHP/phoneConnectAndUpdate/phoneReceiverUp.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=down
//http://phone.local/scriptPHP/phoneConnectAndUpdate/phoneFunctionDND.php?ip=$ip&mac=$mac&numberPhone=$active_user&dnd=up
//http://phone.local/scriptPHP/phoneConnectAndUpdate/phoneFunctionDND.php?ip=$ip&mac=$mac&numberPhone=$active_user&dnd=down
//http://phoneb.ru/scriptPHP/phoneConnectAndUpdate/phoneFunctionDND.php?ip=$ip&mac=$mac&numberPhone=$active_user&dnd=down

?>