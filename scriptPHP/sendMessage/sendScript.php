<?php
require $_SERVER['DOCUMENT_ROOT'] .'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'] .'/generate/dbphonesFunctions.php';
session_start();
$form         = $_POST;
$title        = $form['title'];   //заголовок сообщения
$content      = $form['content']; // текст сообщения
$login        = $_SESSION['login'];
$access       = $_SESSION['access'];
$phones       = $_POST['numberPhones']; // массив checkbox с ip адресами phone.php
$today        = date("F j, Y, g:i a");
session_write_close();
$minPhone = $phones[0];
$maxPhone = end($phones);

$countPhone = $minPhone . "-" . $maxPhone;
insertAction(0, 'message', $login, $access, $title, $content, $linkRegistration, $countPhone, $today);
function push2phone($server, $phone, $data) //функция D-lik смотреть документацию http://www.dlink.ru/up//support/FAQ/VoIP/D-Link_VoIP-Phone_PushXML.pdf
{
    $xml  = $data;
    $post = "POST /xmlService? HTTP/1.1\r\n";
    $post .= "Host: $phone\r\n";
    $post .= "Referer: $server\r\n";
    $post .= "Connection: Keep-Alive\r\n";
    $post .= "Content-Type: text/xml\r\n";
    $post .= "Content-Length: " . strlen($xml) . "\r\n\r\n";
    $fp = @fsockopen($phone, 80, $errno, $errstr, 5);
    if ($fp) {
        fputs($fp, $post . $xml);
        flush();
        fclose($fp);
    }
}
// конец
    for ($phoneNumber=0; $phoneNumber < count($phones); $phoneNumber++) {
        //echo " главный",$phones[$phoneNumber], "     ";
        $phoneOption = $dbphones->query("SELECT `ip`, `botStatus`,`chatID` FROM `phones` WHERE `number` = '$phones[$phoneNumber]'");
        $row = mysqli_fetch_assoc($phoneOption);
        $ip = $row['ip'];
        $dbphones->query("INSERT INTO message(`ip`, `number`, `title`, `textmessage`) VALUES ('$ip', '$phones[$phoneNumber]' ,'$title', '$content')");
        $text = "Номер телефона: " .$phones[$phoneNumber]. ". Тема сообщения " . $title. ". Текст сообщения: " . $content;
        
        if ($row['botStatus'] == '1') {
            botMessage($text, $row['chatID']);
        }
        //делаем отправку на телефон полученный из формы
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<FanvilIPPhoneText beep=\"yes\">\n";
        $xml .= "<Title> $title </Title>\n";
        $xml .= "<Text> $content </Text>\n";
        $xml .= "</FanvilIPPhoneText>\n";
        push2phone("127.0.0.1", "$ip", $xml);
        $dependsPhones = $dbphones->query("SELECT `ip`,`number`,`depends` FROM `phones` WHERE depends = '$phones[$phoneNumber]'");
        foreach ($dependsPhones as $dependsPhone) {

            $nubmerPhone = $dependsPhone['number'];
            $depends = $dependsPhone['depends'];
            $ipPhone = $dependsPhone['ip'];
            //echo " второй ",$nubmerPhone, "    ";
            if ($depends == $phones[$phoneNumber]) {
                //echo " второй из условия",$nubmerPhone, "    ";
                $dbphones->query("INSERT INTO message(`ip`, `number`, `title`, `textmessage`) VALUES ('$ipPhone', '$nubmerPhone' ,'$title', '$content')");
                //делаем отправку на телефон найденный в базе данных, который зависит от выбранного в форме
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                $xml .= "<FanvilIPPhoneText beep=\"yes\">\n";
                $xml .= "<Title> $title </Title>\n";
                $xml .= "<Text> $content </Text>\n";
                $xml .= "</FanvilIPPhoneText>\n";
                push2phone("127.0.0.1", "$ipPhone", $xml);
            }
        }
    }
?>