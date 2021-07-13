<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
$numberPhoneGET = $_GET['numberPhone'];
$ipGET = $_GET['ip'];
$macGET = $_GET['mac'];
$rec=$_GET['receiver'];
$numberPhoneGETError = $dbphones->query("SELECT `number` FROM `phones` WHERE `number`='$numberPhoneGET'");
$numberPhoneGETError = mysqli_fetch_assoc($numberPhoneGETError);
$numberPhoneGETError = $numberPhoneGETError['number'];
echo $numberPhoneGETError;
if($numberPhoneGETError == ""){
	$numberPhoneGETError = $dbphones->query("SELECT `ip` FROM `phones` WHERE `ip`='$ipGET'");
	$numberPhoneGETError = mysqli_fetch_assoc($numberPhoneGETError);
	$numberPhoneGETError = $numberPhoneGETError['ip'];
	if($numberPhoneGETError == ""){
		$linkOptions = "number=$numberPhoneGET&ip=$ipGET&mac=$macGET";
		$linkHref = 'href="/page/formRegistrationPhoneWithError.php?';
		$linkquotes = '"';
		$linkRegistration="<a $linkHref$linkOptions$linkquotes>Зарегистрировать телефон</a>";
		$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `linkRegistr` ,`subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Ошибка телефон не найден в базе', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET <br>', '$linkRegistration', '$numberPhoneGET', '$today')");
		$dbphones->query("UPDATE `customization` SET `properies` = '$numberPhoneGETError' WHERE `id`='2'");
	}else{
		$dbphones->query("UPDATE `customization` SET `properies` = 'success' WHERE `id`='2'");
		if ($_GET['receiver'] == "up"){
			//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '2', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
		}elseif($_GET['receiver'] == "down"){
			//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
			$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `ip` = '$ipGET'");
		}
	}
}else{
	//echo $numberPhoneGETError +11;
	//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
	if ($_GET['receiver'] == "up"){
		//echo $numberPhoneGETError +11;
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '2', `ip` = '$ipGET', `mac` = '$macGET' WHERE `number` = '$numberPhoneGET'");
	}elseif($_GET['receiver'] == "down"){
		//echo $numberPhoneGETError + 6500;
		//$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', 'Phone', 'admin', 'Успешная авторизации телефона', 'Телефон c номером: $numberPhoneGET <br> mac: $macGET; <br> ip: $ipGET', '$numberPhoneGET', '$today')");
		$dbphones->query("UPDATE `phones` SET `timestamp` = '1', `check_ping` = '1', `ip` = '$ipGET', `mac` = '$macGET' WHERE `number` = '$numberPhoneGET'");
	}
}
echo $rec;