<?php
require $_SERVER['DOCUMENT_ROOT'] .'/generate/connect.php';
require $_SERVER['DOCUMENT_ROOT'] .'/generate/dbphonesFunctions.php';

session_start();

$form         = $_POST;
$content      = $form['title'];   //заголовок сообщения
$login        = $_SESSION['login'];
$access       = $_SESSION['access'];

session_write_close();

$today = date("F j, Y, g:i a");
$phones = "401-541";
insertAction(0, 'message', $login, $access, $content, $content, $linkRegistration, $phones , $today);
//$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('message', '$login', '$access', '$content', '$content', '$phones','$today')");
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
    $phoneOption = getFullOptionsPhones();
    foreach ($phoneOption as $phoneIp) {
        $phone = $phoneIp['number'];
        $ip = $phoneIp['ip'];
        $dbphones->query("INSERT INTO message(`ip`, `number`, `title`, `textmessage`) VALUES ('$ip', '$phone' ,'$content', '$content')");
        
        //делаем отправку на телефон полученный из формы
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<FanvilIPPhoneText beep=\"yes\">\n";
        $xml .= "<Title> $content </Title>\n";
        $xml .= "<Text> $content </Text>\n";
        $xml .= "</FanvilIPPhoneText>\n";
        push2phone("127.0.0.1", "$ip", $xml);
    }
?>