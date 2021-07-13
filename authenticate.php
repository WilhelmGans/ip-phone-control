<?php
    session_start();
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];

    if( filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif( filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else {
        $ip = $remote;
    }

    $today = date("F j, Y, g:i a");
    if (!isset($_POST['username'], $_POST['password'])) {
        exit('Пожалуйста, заполните поля для имени пользователя и пароля!');
    };
    $checkDDoS = checkStopList($ip);
    if($checkDDoS == "good"){
        if ($stmt = $dbphones->prepare('SELECT `id`, `password`, `type_user` FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $password, $type_user);
                $stmt->fetch();
                if (password_verify($_POST['password'], $password)) {
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['login'] = $_POST['username'];
                    switch ($type_user) {
                        case "1":
                            $_SESSION['access'] = "admin";
                            break;
                        case "0":
                            $_SESSION['access'] = "user";
                            break;
                    }
                    $_SESSION['id'] = $id;
                    $userMsg = "Пользователь ".$_POST['username']." прошёл авторизацию успешно c ip адреса: ".$ip;
                    insertAction(0, 'Sign in', $_POST['username'], 'admin', 'Авторизация успешно',$userMsg, $linkRegistration, "admin", $today);
                    $userMsg = "";
                    header('Location: homePage.php');
                } else {
                    // Incorrect password
                    //echo '<div style="color:red;">'."Пароль введен не верный".'</div><hr>';
                    $userMsg = "Пользователь ".$_POST['username']." не прошёл авторизацию. Пароль не верный";
                    insertAction(0, 'Sign in', $_POST['username'], 'admin', 'Авторизация провал',$userMsg, $linkRegistration, "admin", $today);
                    //echo $ip;
                    $countIPDDOS = insertDDOSIP($ip, $_POST['username']);
                    $userMsg = "";
                    $errorName = "пароль";
                }
            } else {
                // Incorrect username
                //echo '<div style="color:red;">'."Логин введен не верный".'</div><hr>';
                $userMsg = "Пользователь ".$_POST['username']." не прошёл авторизацию. Логин не найден";
                insertAction(0, 'Sign in', $_POST['username'], 'admin', 'Авторизация провал',$userMsg, $linkRegistration, "admin", $today);
                $countIPDDOS = insertDDOSIP($ip,$_POST['username']);
                $userMsg = "";
                $errorName = "логин";
            }
            $stmt->close();
        };
    }elseif($checkDDoS == "stop"){
        $newTime = getTimeStopList($ip);
        $muteText = "За многократное введение неверных учётных данных вы заблокированны до: ". $newTime ;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!--<meta http-equiv="refresh" content="20">-->
        <title>IP Phone Control</title>
        <!-- icon -->
        <link rel="icon" href="/resources/images/icon.ico" type="image/x-icon">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/libs/css/use.fontawesome.com.css">
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="/libs/css/fonts.googleapis.com.css">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/libs/css/bootstrap.min.css">
        <!-- Material Design Bootstrap -->
        <link rel="stylesheet" href="/libs/css/mdb.min.css">

        <!-- jQuery -->
        <script type="text/javascript" src="/libs/js/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="/libs/js/popper.min.js" defer></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="/libs/js/bootstrap.min.js" defer></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="/libs/js/mdb.min.js" defer></script>

        <script type="text/javascript" src="/libs/js/sweetAlert.min.js" defer></script>

        <script type="text/javascript" src="/libs/src/js/vendor/free/chart.js"></script>
        <style>
            .fa-exclamation-triangle{

                text-align: center;
                font-size: 7em;
                color: red;
            }
            .btn{
                border-radius: 5px;
            }
        </style>
    </head>
    <body class="grey lighten-3">
        <div class="container border rounded shadow-sm text-center p-3 mt-5 white">
            <i class="fas fa-exclamation-triangle pb-2"></i>
            <h3 class="text-center text-muted text-uppercase ">Ошибка авторизации</h3>
            <?php if(empty($muteText)){?>
                <h4>Вы ввели неверный <?php echo $errorName ?>.</h4> 
            <?php }else{?>
                <h4><?php echo $muteText?></h4>
            <?php } ?>
            <div class="container-fluid">
                <h6><a href="index.php" class="btn btn-danger">Вернуться на страницу авторизации</a></h6>
            </div>
            
        </div>
        <script type="text/javascript">
            setTimeout(function(){
                window.location.href = 'index.php';
            }, 5000);
        </script>
    </body>
</html>