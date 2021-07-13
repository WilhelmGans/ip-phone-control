<?php
require $_SERVER['DOCUMENT_ROOT'].'/scriptPHP/phoneConnectAndUpdate/errorInsert.php';
function getStatusIpPhoneCheckPing(){
    global $dbphones;
    $statusIpPhones = $dbphones->query("SELECT `number`, `check_ping`, `ip` FROM phones ORDER BY id ASC");
    return $statusIpPhones;
};
function getActions(){
    global $dbphones;
    $actions = $dbphones->query("SELECT * FROM actions ORDER BY id DESC");
    return $actions;
};
function getFullOptionsPhones(){
    global $dbphones;
    $fullOptionsPhones = $dbphones->query("SELECT * FROM phones ORDER BY `number` ASC");
    return $fullOptionsPhones;
};
function getActionsById($id){
    global $dbphones;
    $actionsId = $dbphones->query("SELECT * FROM actions WHERE id = $id");
    foreach ($actionsId as $actionId) {
        return $actionId;
    };
};
function getUser(){
    global $dbphones;
    $accounts = $dbphones->query("SELECT * FROM accounts ORDER BY id DESC");
    return $accounts;
};
function getAutoMsg(){
    global $dbphones;
    $dataAutoMsg = $dbphones->query("SELECT * FROM automessage ORDER BY `name` ASC");
    return $dataAutoMsg;
};
function getUserById($id){
    global $dbphones;
    $accountsId = $dbphones->query("SELECT `id`, `username`, `name`, `type_user`, `colorinterface` FROM `accounts` WHERE id = $id");
    $accountId = mysqli_fetch_assoc($accountsId);
    return $accountId;
};
function getPhoneById($id){
    global $dbphones;
    $phonesId = $dbphones->query("SELECT * FROM `phones` WHERE id = $id");
    $phoneId = mysqli_fetch_assoc($phonesId);
    return $phoneId;
};
function getDataBot(){
    global $dbphones;
    $bot1 = $dbphones->query("SELECT `botToken1`, `botChatID1`, `botToken2`, `botChatID2`, `botCheck` ,`botToken3`FROM `customization` WHERE id = '1'");
    $bot1 = mysqli_fetch_assoc($bot1);
    return $bot1;
};
function getDataPhones(){
    global $dbphones;
    $dataPhones = $dbphones->query("SELECT `passwordPhones`, `loginPhones` FROM `customization` WHERE id = '1'");
    $dataPhones = mysqli_fetch_assoc($dataPhones);
    return $dataPhones;
};
function updateDataPhones($LoginPhones, $passwordPhones){
    global $dbphones;
    $dbphones->query("UPDATE `customization` SET `loginPhones`= '$LoginPhones', `passwordPhones` = '$passwordPhones'  WHERE `id` = '1'");
};
function getIpPhone($ipPhoneFn){
    global $dbphones;
    $ipPhoneSetting = $dbphones->query("SELECT `ip` FROM `phones` WHERE ip = '$ipPhoneFn'");
    $ipPhoneSetting = mysqli_fetch_assoc($ipPhoneSetting);
    return $ipPhoneSetting;
};
function updateBot($botToken1, $botChatID1, $botToken2, $botChatID2, $botToken3){
    global $dbphones;
    $dbphones->query("UPDATE `customization` SET `botToken1`= '$botToken1', `botChatID1` = '$botChatID1', `botToken2` = '$botToken2', `botChatID2` = '$botChatID2',  `botToken3` = '$botToken3'  WHERE `id` = '1'");
};
function countDataIDTable($nameTable){
    global $dbphones;
    $idCount = $dbphones->query("SELECT COUNT(`id`) as 'id' FROM `$nameTable`");
    $idCount = mysqli_fetch_assoc($idCount);
    $idCount = $idCount['id'];
    return $idCount;
}
function insertDDOSIP($ip,$loginUser){
    global $dbphones;
    $stmt = $dbphones->prepare('SELECT `id`,`timeStart` FROM `stoplist` WHERE `ipStop` = ?');
    $stmt->bind_param('i', $ip);
    $stmt->execute();
    $stmt->bind_result($idCheck, $timeStart);
    $stmt->fetch();
    $stmt->close();
    if (empty($idCheck)) {
        $stmt = $dbphones->prepare("INSERT INTO ddoscheck (`ipRem`) VALUES (?)");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $stmt->close();

        $stmt = $dbphones->prepare('SELECT COUNT(`ipRem`) FROM ddoscheck WHERE `ipRem` = ?');
        $stmt->bind_param('i', $ip);
        $stmt->execute();
        $stmt->bind_result($ipRemCount);
        $stmt->fetch();
        $stmt->close();
        if($ipRemCount > "5"){
            $oldTime = date('H:i:s');
            $newTime = date("H:i:s", strtotime("$oldTime +30 minutes" ));
            $stmt = $dbphones->prepare("INSERT INTO `stoplist` (`ipStop`, `timeStop`, `timeStart`) VALUES (?,?,?)");
            $stmt->bind_param("sss", $ip, $oldTime, $newTime);
            $stmt->execute();
            $stmt->close();
            insertAction(0, 'setting', $loginUser, 'admin', 'Блокировка доступа', "IP : $ip заблокирован с $oldTime  до $newTime. Попытка авторизации по логину $loginUser", $linkRegistration, $namePhoneDelete, $today);
        }
    }else{
        $now = date('H:i:s');
        if($now >= $timeStart){
            $stmt = $dbphones->prepare("DELETE FROM `ddoscheck` WHERE `ipRem` = ?");
            $stmt->bind_param("s", $ip);
            $stmt->execute();
            $stmt->close();
            $stmt = $dbphones->prepare("DELETE FROM `stoplist` WHERE `ipStop` = ?");
            $stmt->bind_param("s", $ip);
            $stmt->execute();
            $stmt->close();
            //DELETE FROM `ddoscheck` WHERE `ddoscheck`.`id` = 4"
        }
    }    
    return $ipRemCount;
};
function checkStopList($ip){
    global $dbphones;
    $stmt = $dbphones->prepare('SELECT `id`,`timeStart` FROM `stoplist` WHERE `ipStop` = ?');
    $stmt->bind_param('i', $ip);
    $stmt->execute();
    $stmt->bind_result($idCheck, $timeStart);
    $stmt->fetch();
    $stmt->close();
    if(empty($idCheck)){
        return "good";
    }else{
        $oldTime = date('H:i:s');
        if($oldTime >= $timeStart){
            $stmt = $dbphones->prepare("DELETE FROM `ddoscheck` WHERE `ipRem` = ?");
            $stmt->bind_param("s", $ip);
            $stmt->execute();
            $stmt->close();
            $stmt = $dbphones->prepare("DELETE FROM `stoplist` WHERE `ipStop` = ?");
            $stmt->bind_param("s", $ip);
            $stmt->execute();
            $stmt->close();
            return "good";
        }
        return "stop";
    }
};
function getTimeStopList($ip){
    global $dbphones;
    $stmt = $dbphones->prepare('SELECT `timeStart` FROM `stoplist` WHERE `ipStop` = ?');
    $stmt->bind_param('i', $ip);
    $stmt->execute();
    $stmt->bind_result($timeStart);
    $stmt->fetch();
    $stmt->close();
    return $timeStart;
}
function insertAction($typeInsert, $type, $user, $user_level, $theme, $text, $linkRegistr, $subject, $date){
    global $dbphones;
    // typeInsert = 0 -error phone dataBase
    //echo $typeInsert." asd++ ".$type." asd++ ".$user." asd++ ".$user_level." asd++ ".$theme." asd++ ".$text." asd++ ".$linkRegistr." asd++ ".$subject." asd++ ".$date;
    switch ($typeInsert) {
        case '0':
            if ($stmt = $dbphones->prepare("INSERT INTO actions (`type`, `user`, `user_level`, `theme`, `text`, `linkRegistr`, `subject`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("ssssssss", $type, $user, $user_level, $theme, $text, $linkRegistr, $subject, $date);
                $stmt->execute();
                $stmt->close();
                $text = "Тип события: ". $type . ". Тема события: " . $theme . ". Текст события: ". $text;
                botAction($text);
                errorInsertAction($text);
            }else {
                $message = 'Ошибка отправки формы';
                $color = 'alert-danger';
            }
            break;
        case '1':
            if ($stmt = $dbphones->prepare("INSERT INTO actions (`type`, `user`, `user_level`, `theme`, `text`, `linkRegistr`, `subject`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("ssssssss", $type, $user, $user_level, $theme, $text, $linkRegistr, $subject, $date);
                $stmt->execute();
                $stmt->close();
                $text = "Тип события: ". $type . ". Тема события: " . $theme . ". Текст события: ". $text;
                botDND($text);
                errorInsertAction($text);
            }else {
                $message = 'Ошибка отправки формы';
                $color = 'alert-danger';
            }
            break;
        case '2':
            if ($stmt = $dbphones->prepare("INSERT INTO actions (`type`, `user`, `user_level`, `theme`, `text`, `linkRegistr`, `subject`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("ssssssss", $type, $user, $user_level, $theme, $text, $linkRegistr, $subject, $date);
                $stmt->execute();
                $stmt->close();
                $text = "Тип события: ". $type . ". Тема события: " . $theme . ". Текст события: ". $text;
                botDND($text);
                errorInsertAction($text);
            }else {
                $message = 'Ошибка отправки формы';
                $color = 'alert-danger';
            }
            break;
        default:

            break;
    }
    return $typeInsert;
};
function botAction($text){
    global $dbphones;
    $bot1 = getDataBot();
    if($bot1['botCheck'] == "1"){
        $bot1Tocken = $bot1['botToken1'];
        $bot1ChatID = $bot1['botChatID1'];
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $bot1Tocken . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $bot1ChatID,
                'text' => $text,
            ),
        )
        );
        curl_exec($ch);
    }
    
};
function botDND($text){
    global $dbphones;
    $bot1 = getDataBot();
    if($bot1['botCheck'] == "1"){
        $bot2Tocken = $bot1['botToken2'];
        $bot2ChatID = $bot1['botChatID2'];
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $bot2Tocken . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $bot2ChatID,
                'text' => $text,
            ),
        )
        );
        curl_exec($ch);
    }
    
};
function botMessage($text, $chatID){
    global $dbphones;
    $bot1 = getDataBot();
    if($bot1['botCheck'] == "1"){
        $bot3Tocken = $bot1['botToken3'];
        $bot3ChatID = $chatID;
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . $bot3Tocken . '/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $bot3ChatID,
                'text' => $text,
            ),
        )
        );
        curl_exec($ch);
    }
};
?>