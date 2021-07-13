<?php
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/dbphonesFunctions.php';
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: /index.php');
        exit;
    };
    require $_SERVER['DOCUMENT_ROOT'].'/generate/pieChar.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/array.php';
    require $_SERVER['DOCUMENT_ROOT'].'/generate/head.php';
    //require $_SERVER['DOCUMENT_ROOT'].'/scriptPHP/phoneConnectAndUpdate/bot.php';
    $stmt = $dbphones->prepare('SELECT `name`, `colorinterface`, `typeStatusPhone` ,`img_url` FROM accounts WHERE `id` = ?');
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($name, $colorinterface, $typeStatusPhone, $urlImg);
    $stmt->fetch();
    $stmt->close();
    $today = date("F j, Y, g:i a");
    $typeUserRU = "";
    switch ($_SESSION['access']) {
        case '1':
            $_SESSION['access'] = "admin";
            $typeUserRU = "Администратор";
            break;
        case '0':
            $_SESSION['access'] = "user";
            $typeUserRU = "Пользователь";
            break;
    }
    switch ($_SESSION['access']) {
        case "admin":
            $typeUserRU = "Администратор";
            break;
        case "user":
            $typeUserRU = "Пользователь";
            break;
    }
    $deleteMessageAuto = $dbphones->query("SELECT `id` FROM `message` ORDER BY `id` DESC");
    $deleteMessageRowAuto = mysqli_fetch_assoc($deleteMessageAuto);
    $idMessageAuto = $deleteMessageRowAuto['id'];
    if( $idMessageAuto >= '10000'){
        $dbphones->query('TRUNCATE TABLE `message`');
        $dbphones->query("INSERT INTO `message` (`id`) VALUES(NULL)");
        insertAction(0, 'setting base', 'auto', 'admin', 'Очистка таблицы', 'Таблица message удаленна успешно',$userMsg, $linkRegistration, "Table message", $today);
        //$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('setting base', 'auto', 'admin', 'Очистка таблицы', 'Таблица message удаленна успешно', 'Table message','$today')");
    };
    $deleteActionAuto = $dbphones->query("SELECT `id` FROM `actions` ORDER BY `id` DESC");
    $deleteActionRowAuto = mysqli_fetch_assoc($deleteActionAuto);
    $idActionAuto = $deleteActionRowAuto['id'];
    if( $idActionAuto >= '10000'){
        $dbphones->query('TRUNCATE TABLE `actions`');
        insertAction(0, 'setting base', 'auto', 'admin', 'Очистка таблицы', 'Таблица actions удаленна успешно',$userMsg, $linkRegistration, "Table message", $today);
        //$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('setting base', 'auto', 'admin', 'Очистка таблицы', 'Таблица actions удаленна успешно', 'Table message','$today')");
    };
    $linkNavigate = $_SERVER['REQUEST_URI'];
    $linkNavigate = explode('.', $linkNavigate);
    $linkNavigate = $linkNavigate[0];
    if ($colorinterface == "dark") {
        $bgColor = "unique-color-dark";
        $bgColorNavBar = "navbar-dark mdb-color darken-3";
        $bgColorCard = "mdb-color darken-3";//#2e3951
        $foterColor = "mdb-color darken-3";
        $orangColor = "orange darken-3";
        $orangColorBorder = 'style="border-color: #ef6c00 !important"';
        $btnColor ="btn-deep-orange";
        $logoColorText = "orange-text";
        $colorTextContant = "text-light";
        $leftNavBarColor = 'style="background-color: #1c2a48 !important"';
        $btnOutlineColor = "btn-outline-orange";
        $ColorPieChart = "white";
    }elseif ($colorinterface == "white") {
        $bgColor = "grey";
        $bgColorNavBar = "navbar-light";
        $logoColorText = "indigo-text";
        $orangColorBorder = '';
        $btnColor ="btn-indigo";
        $btnOutlineColor = "btn-outline-indigo";
        $colorTextContant = "text-muted";
        $foterColor = "indigo";
        $orangColor = "indigo";
        $ColorPieChart = "black";
    }
    //unique-color-dark 
?>

    <body class="<?php echo $bgColor?> lighten-3">
    <iframe src='/scriptPHP/checkStatusPhoneDB.php' width='0' height='0' frameborder='0'></iframe>
        <header>
            <nav class="navbar fixed-top navbar-expand-lg <?php echo $bgColorNavBar?> scrolling-navbar">
                <div class="container-fluid">
                    <a href="/homePage.php" class="navbar-brand waves-effect <?php echo $logoColorText?>"><strong>IP-Phone-Control</strong></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav mr-auto fo">
                            <?php
                        for ($nav=0; $nav < count($navbar); $nav++) {
                            if ($_SESSION['access'] === "user") {
                                if ($_SESSION['access'] === $navbarAccess[$nav]) {?>
                                <li class="nav-item <active>">
                                    <a href="/<?php echo $navbarLink[$nav]?>" class="nav-link waves-effect">
                                        <?php echo $navbar[$nav]?>
                                    </a>
                                </li>
                                <?php }
                            }elseif($_SESSION['access'] === "admin"){?>
                                <li class="nav-item <active>">
                                    <a href="/<?php echo $navbarLink[$nav]?>" class="nav-link waves-effect">
                                        <?php echo $navbar[$nav]?>
                                    </a>
                                </li>
                                <?php };
                        };?>
                        </ul>
                        <ul class="navbar-nav nav-flex-icons">
                            <li class="nav-item mr-2 dropdown">
                                <a href="#" class="nav-link border-light dropdown-toggle rounded waves-effect" id="navbarDropdownMenuLinkAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-user"></i>
                                    <span class="clearfix d-none d-sm-inline-block"><?php echo $name?></span>
                                </a>
                                <div class="dropdown-menu <?php echo $bgColorCard?>" aria-labelledby="navbarDropdownMenuLinkAccount">
                                    <a href="/profile.php" class="dropdown-item waves-effect waves-light <?php echo $colorTextContant?>">Настройки</a>
                                </div>
                            </li>
                            <li class="nav-item mr-2">
                                <a href="/logout.php" class="nav-link border-light rounded waves-effect">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="sidebar-fixed position-fixed <?php echo $logoColorText?>" <?php echo $leftNavBarColor?>>
                <a href="#" class="logo-wrapper" data-toggle="modal" data-target="#inputImageLogo">
                    <div class="sidenav-header d-flex align-items-center justify-content-center">
                        <!-- User Info-->
                        <div class="sidenav-header-inner text-center <?php echo $logoColorText?>" >
                            <div class="rounded-img mb-3">
                                <img src="<?php echo $urlImg?>" alt="person" class="img-fluid rounded-circle">
                            </div>
                            <div class="h5">
                                <?php echo $name?>
                            </div><span><?php echo $typeUserRU?></span>
                        </div>
                    </div>
                </a>
                <?php
                    $dataAutoMsgHeader = getAutoMsg();
                    foreach ($dataAutoMsgHeader as $dataAutoMsgHeaderFor) {?>
                    <form action="#" class="list-group list-group-flush" id="templateForm<?php echo $dataAutoMsgHeaderFor['id']?>">
                        <input type="text" name="title" class="form-control none" value="<?php echo $dataAutoMsgHeaderFor['textMessage']?>">
                        <button type="submit" name="titleButton" id="templateForm<?php echo $dataAutoMsgHeaderFor['id']?>Button" class="buttonLink list-group-item <?php echo $logoColorText?>">
                            <i class="fas fa-envelope-open-text mr-3"></i><?php echo $dataAutoMsgHeaderFor['name']?>
                        </button>
                    </form>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $("#templateForm<?php echo $dataAutoMsgHeaderFor['id']?>Button").click(
                                function() {
                                    if (jQuery('#templateForm<?php echo $dataAutoMsgHeaderFor['id']?>').length) {
                                        swal({
                                            title: "Сообщения отправлены",
                                            text: "<?php echo $dataAutoMsgHeaderFor['textMessage']?>",
                                            icon: "success",
                                            button: "закрыть",
                                            timer: 1100
                                        });
                                        sendAjaxFormTemplate('result_form', 'templateForm<?php echo $dataAutoMsgHeaderFor['id']?>', '/scriptPHP/sendMessage/templateSendMessage.php');
                                        return false;
                                    } else {
                                        swal({
                                            title: "Сообщения не отправлены",
                                            text: "Нажмите на кнопку закрыть и сообщите о проблеме администратору. Код ошибки 1",
                                            icon: "error",
                                            button: "закрыть"
                                        });
                                    }
                                }
                            );
                        });
                    </script>
                    <hr/>
                <?php }?>
            </div>
            <script type="text/javascript">
                function sendAjaxFormTemplate(result_form, ajax_form, url) {
                    jQuery.ajax({
                        url: url, //url страницы (templateSendMessage.php)
                        type: "POST", //метод отправки
                        dataType: "html", //формат данных
                        data: jQuery("#" + ajax_form).serialize(), // Сеарилизуем объект
                        error: function(response) { // Данные не отправлены
                            swal({
                                title: "Сообщения не отправлены",
                                text: "Нажмите на кнопку закрыть и сообщите о проблеме администратору. Код ошибки 2" + result_form,
                                icon: "error",
                                button: "закрыть"
                            });
                        }
                    });
                };
            </script>
            <script type="text/javascript">
                function updatePhones() {
                    $.get("/scriptPHP/updateErrorPhone.php");
                    alert("Проверка телефонов запущена")
                    return false;
                };
            </script>
        </header>
        <main class="pt-5 max-lg-5">
            <div class="container-fluid mt-5 ">
                <div class="card mb-4 wow zoomIn <?php echo $bgColorCard?>">
                    <div class="card-body d-sm-flex justify-content-between">
                        <h4 class="mb-2 md-sm-0 pt-1 <?php echo $colorTextContant?>">
                            <span><?php echo $linkNavigate ?></span>
                        </h4>
                        <form action="/page/search.php" class="d-flex justify-content-center" method="POST">
                            <input type="search" name="search" class="form-control <?php echo $bgColorCard?> <?php echo $colorTextContant?>" placeholder="Поиск событий по теме">
                            <button type="submit" class="btn <?php echo $btnColor?> btn-sm my-0 p"> <i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>