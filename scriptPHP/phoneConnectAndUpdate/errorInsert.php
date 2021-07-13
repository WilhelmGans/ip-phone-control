<?php
function errorInsertAction($text){
    global $dbphones;
    $bot1 = getDataBot();
    if($bot1['botCheck'] == "1"){
    $token = '1659515063:AAGdEicJ2CLY-yUV1y4njxna5Lf9zg5_rfM';
    $chatID = '-1001438413003';
    $ch = curl_init();
    curl_setopt_array($ch,array(
        CURLOPT_URL => 'https://api.telegram.org/bot' . $token . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_POSTFIELDS => array(
            'chat_id' => $chatID,
            'text' => $text,
        ),
    )
    );
    curl_exec($ch);
    }
}