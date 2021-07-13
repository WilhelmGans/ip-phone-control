<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
$userFormPhone = $_SESSION['login'];
$userAccessFormPhone = $_SESSION['access'];

$phoneScaningCheck = $dbphones->query("SELECT `properies` FROM `customization` WHERE `id` = '1'");
$phoneScaningCheck = mysqli_fetch_assoc($phoneScaningCheck);
$phoneScaningCheck = $phoneScaningCheck['properies'];

$data = $_POST;

    if( isset($data['phoneRegisterButton']) ){
        $checkPing = '0';
        
        $numberForm = $data['number'];
        $errors = array();
        if( trim($data['number']) == ''){
            $errors[]= 'Введите номер';
        }
        if ($data['typePhone'] == 'secondary' && $data['dependsPhone'] == '') {
            $errors[]= 'Введите номер телефона от которого зависит номер:'. $data['number'];
        }
        if ($data['typePhone'] == 'primary') {
            $data['depends'] = "";
        }
        if( trim($data['floor']) == ''){
            $errors[]= 'Введите этаж';
        }
        if( trim($data['block']) == ''){
            $errors[]= 'Введите корпус';
        }
        if (empty($errors)) {
            if ($stmt = $dbphones->prepare('SELECT `number`, `ip`,`port_pp` FROM phones WHERE `number` = ?')) {
                $stmt->bind_param('s', $data['number']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $message = 'Такой номер уже есть';
                    $color = 'alert-danger';
                }else{
                    if ($stmt = $dbphones->prepare('SELECT `ip` FROM phones WHERE `ip` = ?')) {
                    $stmt->bind_param('s', $data['ip']);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $message = 'Такой ip уже есть';
                        $color = 'alert-danger';
                    }else {
                        if ($data['typePhone'] == 'primary') {
                            if ($stmt = $dbphones->prepare('INSERT INTO phones (`number`, `name`, `ip`, `type_phone`, `port_pp`,`floor`, `block`,`mac`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
                                $stmt->bind_param('ssssssss', $data['number'], $data['namePhone'], $data['ip'], $data['typePhone'], $data['portPatchPanel'], $data['floor'], $data['block'], $data['mac']);
                                $stmt->execute();
                                insertAction(0, 'setting phone', $loginUser,'admin', 'Добавление телефона', "Телефон с номером: $numberForm создан успешно", $linkRegistration, $numberForm, $today);
                                //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$typeUserRU', 'Добавление телефона', 'Телефон с номером: $numberForm создан успешно', '$numberForm','$today')");
                                $message = 'Телефон '.$data['number'].' добавлен!';
                                $color = 'alert-success';
                                $data = "";
                            } else {
                                $message = 'Ошибка отправки формы';
                                $color = 'alert-danger';
                            }
                        }else {
                            if ($stmt = $dbphones->prepare('INSERT INTO phones (`number`, `name`, `ip`, `type_phone`, `depends`, `port_pp`,`floor`,`block`,`mac`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
                                $stmt->bind_param('sssssssss', $data['number'], $data['namePhone'], $data['ip'], $data['typePhone'], $data['dependsPhone'], $data['portPatchPanel'], $data['floor'], $data['block'], $data['mac']);
                                $stmt->execute();
                                insertAction(0, 'setting phone', $loginUser, 'admin', 'Добавление телефона', "Телефон с номером: $numberForm создан успешно", $linkRegistration, $numberForm, $today);
                                //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$typeUserRU', 'Добавление телефона', 'Телефон с номером: $numberForm создан успешно', '$numberForm','$today')");
                                $message = 'Телефон '.$data['number'].' добавлен!';
                                $color = 'alert-success';
                                $data = "";
                            } else {
                                $message = 'Ошибка отправки формы';
                                $color = 'alert-danger';
                            }
                        }
                    }
                    } else {
                        $message = 'Ошибка отправки формы';
                        $color = 'alert-danger';
                    }
                }
            }

        }else {
            $message = array_shift($errors);
            $color = 'alert-danger';
        }
    };
    if( isset($data['delete_phone']) ){
        $namePhoneDelete = $data['delete_phone'];
        $dbphones->query("DELETE FROM `phones` WHERE `number` = '$namePhoneDelete'");
        $dbphones->query("DELETE FROM `phones` WHERE `depends` = '$namePhoneDelete'");
        insertAction(0, 'setting phone', $loginUser, 'admin', 'Удаление телефона', "Телефон с номером: $namePhoneDelete удалён успешно и связанные с ним", $linkRegistration, $namePhoneDelete, $today);
        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$typeUserRU', 'Удаление телефона', 'Телефон с номером: $namePhoneDelete удалён успешно и связанные с ним', '$namePhoneDelete','$today')");
    };
    if( isset($data['deleteAutoMsg']) ){
        $autoMsgDelete = $data['deleteAutoMsg'];
        $dbphones->query("DELETE FROM `automessage` WHERE `id` = '$autoMsgDelete'");
        insertAction(0, 'setting', $userFormPhone, 'admin', 'Удаление кнопки массовой рассылки', 'Кнопка удалёна успешно', $linkRegistration,  'autoMessage', $today);
        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting', '$userFormPhone', '$typeUserRU', 'Удаление кнопки массовой рассылки', 'Кнопка удалёна успешно', 'autoMessage','$today')");
    };
    if( isset($data['updateBot']) ){
        updateBot($data['tokenBotAction'],$data['chatIdBotAction'],$data['tokenBotDND'],$data['chatIdBotDND'], $data['tokenBotMessage']);
        insertAction(0, 'setting', $userFormPhone, 'admin', 'Изменение параметров ботов', 'Изменение параметров ботов выполнено успешно', $linkRegistration,  'Бот', $today);
        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting', '$userFormPhone', '$typeUserRU', 'Удаление кнопки массовой рассылки', 'Кнопка удалёна успешно', 'autoMessage','$today')");
    };
    if( isset($data['updateDataPhone']) ){
        updateDataPhones($data['loginPhones'],$data['passwordPhones']);
        insertAction(0, 'setting', $userFormPhone, 'admin', 'Изменение параметров телефонов', 'Изменение логина или пароля телефонов выполнено успешно', $linkRegistration,  'телефоны', $today);
        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting', '$userFormPhone', '$typeUserRU', 'Удаление кнопки массовой рассылки', 'Кнопка удалёна успешно', 'autoMessage','$today')");
    };
    if( isset($data['newAutoMsg']) ){
        $nameAutoMsg = $data['nameAutoMsg'];
        $textAutoMsg = $data['textAutoMsg'];
        $checkPing = '0';
        $errors = array();
        if( trim($data['nameAutoMsg']) == ''){
            $errors[]= 'Введите имя кнопки';
        }
        if( trim($data['textAutoMsg']) == ''){
            $errors[]= 'Введите текст сообщения кнопки';
        }
        if (empty($errors)) {
            if ($stmt = $dbphones->prepare('SELECT `id` FROM automessage WHERE `name` = ?')) {
                $stmt->bind_param('s', $data['nameAutoMsg']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $message = 'Такая кнопка уже есть';
                    $color = 'alert-danger';
                }else{
                    if ($stmt = $dbphones->prepare('SELECT COUNT(DISTINCT `id`) as countIdAutoMsg FROM automessage')) {
                        $stmt->execute();
                        $stmt->bind_result($countIdAutoMsg);
                        $stmt->fetch();
                        $stmt->close();
                    if ($countIdAutoMsg > 4) {
                        $message = 'Достигнут лимит в 5 кнопок';
                        $color = 'alert-danger';
                    }else {                        
                        if ($stmt = $dbphones->prepare('INSERT INTO automessage (`name`, `textMessage`) VALUES (?, ?)')) {
                            $stmt->bind_param('ss', $data['nameAutoMsg'], $data['textAutoMsg']);
                            $stmt->execute();
                            insertAction(0, 'setting', $userFormPhone, 'admin', 'Добавление кнопки массовой рассылки', "Кнопка с именем: $nameAutoMsg создана успешно. Сообщение отправки $nameAutoMsg.", $linkRegistration,  'autoMessage', $today);
                            //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$typeUserRU', 'Добавление кнопки массовой рассылки', 'Кнопка с именем: $nameAutoMsg создана успешно. Сообщение отправки $nameAutoMsg.', '$numberForm','$today')");
                            $message = 'кнопка'.$data['nameAutoMsg'].$countIdAutoMsg.' добавлена!';
                            $color = 'alert-success';
                            $data = "";
                        } else {
                            $message = 'Ошибка отправки формы';
                            $color = 'alert-danger';
                        }
                    }
                    } else {
                        $message = 'Ошибка отправки формы';
                        $color = 'alert-danger';
                    }
                }
            }

        }else {
            $message = array_shift($errors);
            $color = 'alert-danger';
        }
    };


?>
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-lg-9 mb-4">
            <div class="card wow slideInLeft <?php echo $bgColorCard?>">
            <?php
            if ($_SESSION['access'] === "user") {?>
                <div class="card-body">
                    <h3 class="text-center text-danger">У вас недостаточно прав</h3>
                </div>
                <?php } else{
            ?>
                <div class="card-body <?php echo $colorTextContant?>">
                    <?php
                    if ($_GET['id'] == "1") {?>
                        <form class="pt-2 pl-5 pr-5 pb-5" action="<?php echo $linkHref?>" method="POST">
                        <?php if(!empty($message)) { ?>
                            <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                            <p class="h4 mb-4 text-center <?php echo $colorTextContant?>">Новый номер</p>
                            <label for="numberRegister">Номер телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="number" id="numberRegister" type="text" placeholder="Введите номер телефона" value="<?php echo $numberPhoneGET?>" required>
                            <label for="ipRegister">IP телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="ip" id="ipRegister" type="text" placeholder="Введите ip" value="<?php echo $ipGET?>" pattern="((^|\.)((25[0-5]_*)|(2[0-4]\d_*)|(1\d\d_*)|([1-9]?\d_*))){4}_*$" title="192.168.1.1" require>
                            
                            <label for="macRegister">MAC телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="mac" id="macRegister" type="text" placeholder="Введите MAC" value="<?php echo $macGET ?>">
                            
                            <label for="portRegister">Порт на PatchPanel телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="portPatchPanel" id="portRegister" type="text" placeholder="Введите порт на patch panel" value="<?php echo @$data['portPatchPanel']?>">
                            <label for="floorRegister">Место расположения телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="namePhone" id="nameRegister" type="text" placeholder="Введите место расположения телефона" value="<?php echo @$data['namePhone']?>">
                            
                            <label for="floorRegister">Этаж телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="floor" id=floorRegister type="text" placeholder="Введите этаж" require>

                            <label for="floorRegister">Корпус телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="block" id=blockRegister type="text" placeholder="Введите корпус" require>

                            <input  class="form-control mt-4 mb-4 none <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="dependsPhone" id="dependsRegister" type="text" placeholder="Введите номер телефона, от которого зависит номер" value="<?php echo @$data['dependsPhone']?>">
                            <div class="d-flex justify-content-start">
                                <div class="custom-control custom-radio custom-control-inline <?php echo $colorTextContant?>">
                                    <input type="radio" class="custom-control-input" id="primaryPhone" name="typePhone" value="primary" checked>
                                    <label class="custom-control-label" for="primaryPhone">Основной телефон</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline <?php echo $colorTextContant?>">
                                    <input type="radio" class="custom-control-input" id="secondaryPhone" name="typePhone" value="secondary">
                                    <label class="custom-control-label" for="secondaryPhone">Дополнитьельный телефон</label>
                                </div>
                            </div>
                            <button class="btn <?php echo $btnColor?> btn-block my-4" type="submit" name="phoneRegisterButton">Добавить телефон</button>
                        </form>
                            <script type="text/javascript">
                                $('#secondaryPhone').click(function() {
                                    if ($('#secondaryPhone').is(':checked')) {
                                        $('#dependsRegister').removeClass('none');
                                        $('#dependsRegister').addClass('block');
                                    }
                                });
                                $('#primaryPhone').click(function() {
                                    if ($('#primaryPhone').is(':checked')){
                                        $('#dependsRegister').removeClass('block');
                                        $('#dependsRegister').addClass('none');
                                    }
                                });
                            </script>
                    <?php }
                    if ($_GET['id'] == "2") {?>
                    <p>Основные телефоны</p>
                    <div class="row">
                        <?php
                        $foreachPhonesForm = getFullOptionsPhones();
                        foreach ($foreachPhonesForm as $foreachPhoneForm){
                            $idFormDeletePhone = $foreachPhoneForm['id'];
                            $numberDeletePhone = $foreachPhoneForm['number'];
                            $typePhoneDeletePhone = $foreachPhoneForm['type_phone'];
                            if ($typePhoneDeletePhone == "primary") {?>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                                    <a href="phoneSetting.php?id=<?php echo $idFormDeletePhone?>" class="text-muted">
                                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                            <div class="row">
                                                <div class="col-12 p-2  text-left <?php echo $colorTextContant?>">
                                                    <i class="fas fa-cog"> <?php echo $numberDeletePhone ?></i><br>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                            ?>
                        <?php }; ?>
                    </div>
                    <p>Дополнительные телефоны</p>
                    <div class="row">
                        <?php
                        $foreachPhonesForm = getFullOptionsPhones();
                        foreach ($foreachPhonesForm as $foreachPhoneForm){
                            $idFormDeletePhone = $foreachPhoneForm['id'];
                            $numberDeletePhone = $foreachPhoneForm['number'];
                            $typePhoneDeletePhone = $foreachPhoneForm['type_phone'];
                            if ($typePhoneDeletePhone == "secondary") {?>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                                    <a href="phoneSetting.php?id=<?php echo $idFormDeletePhone?>" class="text-muted">
                                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                            <div class="row">
                                                <div class="col-12 p-2  text-left <?php echo $colorTextContant?>">
                                                    <i class="fas fa-cog"> <?php echo $numberDeletePhone ?></i><br>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                            ?>
                        <?php }; ?>
                    </div>
                    <?php }
                    if ($_GET['id'] == "3") {?>
                    <div class="row">
                        <?php
                        $foreachPhonesForm = getFullOptionsPhones();
                        foreach ($foreachPhonesForm as $foreachPhoneForm){
                            $idFormDeletePhone = $foreachPhoneForm['id'];
                            $numberDeletePhone = $foreachPhoneForm['number'];
                            $typePhoneDeletePhone = $foreachPhoneForm['type_phone'];
                            if ($typePhoneDeletePhone == "primary") {?>
                            <div class="col-12 col-lg-6">
                                <a href="phoneSetting.php?id=<?php echo $idFormDeletePhone?>" class="text-muted">
                                    <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                        <div class="row">
                                            <div class="col-12 col-md-3 p-2 pl-5 text-left <?php echo $colorTextContant?>">
                                                <i class="fas fa-cog"> <?php echo $numberDeletePhone ?></i><br>
                                            </div>
                                            <div class="col-12 col-md-6 p-2 pl-5 text-left <?php echo $colorTextContant?>"> Тип телефона
                                                <?php echo "Основной" ?>
                                            </div>
                                            <div class="col-12 col-md-3 p-2 pl-5 d-flex justify-content-md-end ">
                                                <form action="adminSpecification.php?id=3" method="POST">
                                                    <button class="btn btn-danger z-depth-1 m-0 waves-effect btn-sm" type="submit" value="<?php echo $numberDeletePhone?>" name="delete_phone">удалить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php }
                            ?>
                        <?php }; ?>
                    </div>
                    <?php }
                    if ($_GET['id'] == "4") {?>
                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                            <div class="row">
                                <div class="col-12 col-md-3 p-2 pl-5 text-left">
                                    Очистить базу данных событий
                                </div>
                                <div class="col-12 col-md-6 p-2 pl-5 text-left">
                                    Количество записей: <?php echo $idAction = countDataIDTable("actions") ?>
                                </div>
                                <div class="col-12 col-md-3 p-2 pl-5 d-flex justify-content-md-end ">
                                    <?php
                                    if ($foreachTypeUserForUserSetting === "Пользователь" || $name != $foreachNameForLoginForUserSetting) {?>
                                        <form action="adminSpecification.php?id=4" method="POST">
                                            <button class="btn btn-danger z-depth-1 m-0 waves-effect btn-sm" type="submit" name="delete_dbphone_Actions">удалить</button>
                                        </form>
                                    <?php }; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            if( isset($data['delete_dbphone_Actions'])){
                                $dbphones->query('TRUNCATE TABLE `actions`');
                                insertAction(0, 'setting base', $userFormPhone, 'admin', 'Очистка таблицы', "Таблица actions очищена успешно.", $linkRegistration,  'Table actions', $today);
                                //$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('setting base', '$userFormPhone', '$typeUserRU', 'Очистка таблицы', 'Таблица actions очищена успешно', 'Table actions','$today')");
                            };
                        ?>
                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                            <div class="row">
                                <div class="col-12 col-md-3 p-2 pl-5 text-left">
                                    Очистить базу данных сообщений
                                </div>
                                <div class="col-12 col-md-6 p-2 pl-5 text-left">
                                    Количество записей: <?php echo $idMessage = countDataIDTable("message")?>
                                </div>
                                <div class="col-12 col-md-3 p-2 pl-5 d-flex justify-content-md-end ">
                                    <?php
                                    if ($foreachTypeUserForUserSetting === "Пользователь" || $name != $foreachNameForLoginForUserSetting) {?>
                                        <form action="adminSpecification.php?id=4" method="POST">
                                            <button class="btn btn-danger z-depth-1 m-0 waves-effect btn-sm" type="submit" name="delete_dbphone_Message">удалить</button>
                                        </form>
                                    <?php }; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            if( isset($data['delete_dbphone_Message'])){
                                $dbphones->query('TRUNCATE TABLE `message`');
                                $dbphones->query("INSERT INTO `message` (`id`) VALUES(NULL)");
                                insertAction(0, 'setting base', $userFormPhone, 'admin', 'Очистка таблицы', "Таблица message очищена успешно.", $linkRegistration,  'Table message', $today);
                                //$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('setting base', '$userFormPhone', '$typeUserRU', 'Очистка таблицы', 'Таблица message удаленна успешно', 'Table message','$today')");
                            };
                        ?>
                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                            <div class="row">
                                <div class="col-12 col-md-3 p-2 pl-5 text-left">
                                    Очистить базу данных заблокированных адресов
                                </div>
                                <div class="col-12 col-md-6 p-2 pl-5 text-left">
                                    Количество записей: <?php echo $idStopList = countDataIDTable("stoplist")?>
                                </div>
                                <div class="col-12 col-md-3 p-2 pl-5 d-flex justify-content-md-end ">
                                    <?php
                                    if ($foreachTypeUserForUserSetting === "Пользователь" || $name != $foreachNameForLoginForUserSetting) {?>
                                        <form action="adminSpecification.php?id=4" method="POST">
                                            <button class="btn btn-danger z-depth-1 m-0 waves-effect btn-sm" type="submit" name="delete_dbphone_stopList">удалить</button>
                                        </form>
                                    <?php }; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            if( isset($data['delete_dbphone_stopList'])){
                                $dbphones->query('TRUNCATE TABLE `stoplist`');
                                $dbphones->query('TRUNCATE TABLE `ddoscheck`');
                                insertAction(0, 'setting base', $userFormPhone, 'admin', 'Очистка таблицы', "Таблицы блокировки очищены успешно.", $linkRegistration,  'Table message', $today);
                                //$dbphones->query("INSERT INTO `actions` (`type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES ('setting base', '$userFormPhone', '$typeUserRU', 'Очистка таблицы', 'Таблица message удаленна успешно', 'Table message','$today')");
                            };
                        ?>
                    <?php }
                    if ($_GET['id'] == "6") {?>
                        <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                            <div class="row">
                                <div class="col-12 col-md-6 d-flex align-middle p-0 pl-2 pt-2">
                                    <i class="fas fa-cog"> Автоматический сканер телефонов</i><br>
                                </div>
                                <div class="col-12 col-md-2 d-flex align-middle p-0 pl-2 pt-2">
                                    Статус: <?php if ($phoneScaningCheck == "0"){echo "остановленно";}else{echo "работает";} ?>
                                </div>
                                <div class="col-12 col-md-4 d-flex justify-content-md-end align-middle">
                                    <a href="#" onclick="doSomething();">
                                        <span class="badge badge-success badge-pill p-2 m-1 pull-right">Запустить <i class="fas fa-undo-alt"></i></span>
                                    </a>
                                    <a href="/scriptPHP/stopUpdateDataPhone.php">
                                        <span class="badge badge-danger badge-pill p-2 m-1 pull-right">Остановить <i class="fas fa-undo-alt"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function doSomething() {
                                $.get("/scriptPHP/startUpdateDataPhone.php");
                                $.get("/scriptPHP/updateDataPhone.php");
                                swal({
                                    title: "Проверка телефонов запущена",
                                    text: "Каждые 3 часа",
                                    icon: "success",
                                    button: "закрыть",
                                    timer: 1100
                                });
                                return false;
                            }
                        </script>
                        <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                            <div class="row">
                                <div class="col-12 col-md-6 d-flex align-middle p-0 pl-2 pt-2">
                                    <i class="fas fa-cog"> Бот телеграма</i><br>
                                </div>
                                <div class="col-12 col-md-2 d-flex align-middle p-0 pl-2 pt-2">
                                    Статус: <?php $bot = getDataBot(); if ($bot['botCheck'] == "0"){echo "остановленно";}else{echo "работает";} ?>
                                </div>
                                <div class="col-12 col-md-4 d-flex justify-content-md-end align-middle">
                                    <a href="#" onclick="botTelegramStart();">
                                        <span class="badge badge-success badge-pill p-2 m-1 pull-right">Запустить <i class="fas fa-undo-alt"></i></span>
                                    </a>
                                    <a href="#" onclick="botTelegramStop();">
                                        <span class="badge badge-danger badge-pill p-2 m-1 pull-right">Остановить <i class="fas fa-undo-alt"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="adminSpecification.php?id=8" class="text-muted">
                            <div class="container-fluid mb-1 p-2 pt-3 pb-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fas fa-cog"> Настройки ботов</i><br>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="adminSpecification.php?id=9" class="text-muted">
                            <div class="container-fluid mb-1 p-2 pt-3 pb-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fas fa-cog"> Настройки логина и пароля телефонов</i><br>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="adminSpecification.php?id=7" class="text-muted">
                            <div class="container-fluid mb-1 p-2 pt-3 pb-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fas fa-cog"> Настройка кнопок автоматической рассылки</i><br>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="adminSpecification.php?id=4" class="text-muted">
                            <div class="container-fluid mb-1 p-2 pt-3 pb-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fas fa-cog"> Работа с базой данных</i><br>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="adminSpecification.php?id=10" class="text-muted">
                            <div class="container-fluid mb-1 p-2 pt-3 pb-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fas fa-cog"> Action URl</i><br>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="#centralModalLGInfoDemo">
                            <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                <div class="row">
                                    <div class="col-md-12 col-lg-4 p-2 text-left">
                                        <i class="fas fa-cog"> Сведения о системе</i><br>
                                    </div>
                                    <div class="col-md-12 col-lg-8 p-2 text-right ">
                                        Версия IP Phone Control 2.8.5 от 10.06.2021. Нажмите здесь, чтобы узнать больше.
                                    </div>
                                </div>
                            </div>
                        </a>
                        <script type="text/javascript">
                            function botTelegramStart() {
                                $.get("/scriptPHP/botStartStop/start.php");
                                swal({
                                    title: "Бот телеграма запущен.",
                                    text: "Теперь вы сможете получать уведомления событий в telegram!",
                                    icon: "success",
                                    button: "закрыть",
                                    timer: 2000
                                });
                                return false;
                            }
                            function botTelegramStop() {
                                $.get("/scriptPHP/botStartStop/stop.php");
                                swal({
                                    title: "Бот телеграма остановлен.",
                                    text: "Теперь вы не будете получать уведомления событий в telegram!",
                                    icon: "success",
                                    button: "закрыть",
                                    timer: 2000
                                });
                                return false;
                            }
                        </script>
                    <?php }if ($_GET['id'] == "7") {?>
                        
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <form class="pl-5 pr-5 pb-2" action="adminSpecification.php?id=7" method="POST">
                                            <?php if(!empty($message)) { ?>
                                                <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                                    <?php echo $message; ?>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                            <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Новая массовая рассылка</p>

                                            <label for="ipRegister">Имя</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="nameAutoMsg" id="nameAutoMsg" type="text" placeholder="Завтрак" title="Имя" required>

                                            <label for="macRegister">Текст сообщения</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="textAutoMsg" id="textAutoMsg" type="text" placeholder="Добро пожаловать на завтрак" title="текст сообщения" required >
                                            <button class="btn <?php echo $btnColor?> btn-block my-4 " type="submit" name="newAutoMsg">Добавить новую массовую рассылку</button>
                                        </form>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Удаление массовых рассылок</p>
                                        <div class="d-flex flex-column justify-content-center m-lg-5">
                                            <?php
                                                $dataAutoMsg = getAutoMsg();
                                                foreach ($dataAutoMsg as $dataAutoMsgFor) {?>
                                                <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 p-2 pl-5 text-left <?php echo $colorTextContant?>">
                                                            <?php echo $dataAutoMsgFor['name'] ?>
                                                        </div>
                                                        <div class="col-12 col-md-6 p-2 pl-5 d-flex justify-content-md-end ">
                                                            <form action="adminSpecification.php?id=7" method="POST">
                                                                <button class="btn btn-danger z-depth-1 m-0 waves-effect btn-sm" type="submit" value="<?php echo $dataAutoMsgFor['id']?>" name="deleteAutoMsg">удалить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                    <?php }if ($_GET['id'] == "8") {?>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <form class="pl-5 pr-5 pb-2" action="adminSpecification.php?id=8" method="POST">
                                    <?php if(!empty($message)) { ?>
                                        <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                            <?php echo $message; ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php }; 
                                    $botDataForm = getDataBot();
                                    
                                    ?>
                                    <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Новая массовая рассылка</p>

                                    <label for="tokenBotAction">Токен бота Actions</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="tokenBotAction" id="tokenBotAction" type="text" value="<?php echo $botDataForm['botToken1']?>" placeholder="xxxxxxxxxxx:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" title="Токен для бота" required>

                                    <label for="chatIdBotAction">Chat ID</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="chatIdBotAction" id="chatIdBotAction" type="text" value="<?php echo $botDataForm['botChatID1']?>" placeholder="-xxxxxxxxxxxxx" title="Chat ID для бота" required >
                                    <label for="tokenBotDND">Токен бота DND</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="tokenBotDND" id="tokenBotDND" type="text" value="<?php echo $botDataForm['botToken2']?>" placeholder="xxxxxxxxxxx:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" title="Токен для бота" required>

                                    <label for="chatIdBotDND">Chat ID</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="chatIdBotDND" id="chatIdBotDND" type="text" value="<?php echo $botDataForm['botChatID2']?>" placeholder="-xxxxxxxxxxxxx" title="Chat ID для бота" required >
                                    
                                    <label for="tokenBotMessage">Токен бота для отправки сообщений в личные чаты.</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="tokenBotMessage" id="tokenBotMessage" type="text" value="<?php echo $botDataForm['botToken3']?>" placeholder="xxxxxxxxxxx:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" title="Токен для бота" required >
                                    
                                    <button class="btn <?php echo $btnColor?> btn-block my-4 " type="submit" name="updateBot">обновить параметры ботов</button>
                                </form>
                                <h6 class="h6 text-left pl-5 <?php echo $colorTextContant?>">
                                    Внимание! Включение ботов может приводить к замедленю работы систамы.
                                </h6>
                            </div>
                        </div>
                    
            <?php }if ($_GET['id'] == "9") {?>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <form class="pl-5 pr-5 pb-2" action="adminSpecification.php?id=9" method="POST">
                                    <?php if(!empty($message)) { ?>
                                        <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                            <?php echo $message; ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php }; 
                                    $dataPhones = getDataPhones();
                                    
                                    ?>
                                    <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Новая массовая рассылка</p>

                                    <label for="loginPhones">Логин телефона</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="loginPhones" id="loginPhones" type="text" value="<?php echo $dataPhones['loginPhones']?>" placeholder="admin" title="Логин для телефона" required>

                                    <label for="passwordPhones">Пароль телефона</label>
                                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="passwordPhones" id="passwordPhones" type="text" value="<?php echo $dataPhones['passwordPhones']?>" placeholder="admin" title="Пароль для телефона " required >
                                    
                                    <button class="btn <?php echo $btnColor?> btn-block my-4 " type="submit" name="updateDataPhone">обновить параметры телефонов</button>
                                </form>
                            </div>
                        </div>
                    
            <?php }if ($_GET['id'] == "10") {?>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="h5 text-center">Action URL</div>
                                <div class="container-fluid p-2 pt-3 border-bottom  border-top border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Настройка завершена: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneRegister.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Зарегистрировано: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneRegister.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Ошибка регистрации: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneRegister.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=down
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Трубка снята: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneReceiverUp.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Трубка повешена: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneReceiverUp.php?ip=$ip&mac=$mac&numberPhone=$active_user&receiver=down
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Вызов установлен: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/callConnect.php?ip=$ip&mac=$mac&numberPhone=$active_user&call_id=$call_id&call=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Вызов завершён: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/callConnect.php?ip=$ip&mac=$mac&numberPhone=$active_user&call_id=$call_id&call=down
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light  pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">DND on: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneFunctionDND.php?ip=$ip&mac=$mac&numberPhone=$active_user&dnd=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">DND off: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/phoneFunctionDND.php?ip=$ip&mac=$mac&numberPhone=$active_user&dnd=down
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Переадресация включена: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/redirectionOnOff.php?ip=$ip&mac=$mac&numberPhone=$active_user&redirection=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Переадресация выключена: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/redirectionOnOff.php?ip=$ip&mac=$mac&numberPhone=$active_user&redirection=down
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Звук выключен: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/soundPhoneOnOff.php?ip=$ip&mac=$mac&numberPhone=$active_user&sound=up
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid p-2 pt-3 border-bottom border-light pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">Звук включен: </div>
                                        <div class="col-12 col-sm-8">
                                            http://<?php echo $_SERVER['SERVER_NAME']?>/scriptPHP/phoneConnectAndUpdate/soundPhoneOnOff.php?ip=$ip&mac=$mac&numberPhone=$active_user&sound=down
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
            <?php } if ($_GET['id'] == "5") {?>
                        <form class="pt-2 pl-5 pr-5 pb-3 <?php echo $colorTextContant?>" action="adminSpecification.php?id=5" method="POST">
                            <?php if(!empty($message)) { ?>
                                <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                    <?php echo $message; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>
                            <p class="h4 mb-4 text-center <?php echo $colorTextContant?>">Сканирование сети</p>
                            <div class="row pt-2 pl-3 pr-3">
                                <input class="form-control mb-4 pr-3 col-12 col-sm-6 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="ipStart" type="text" placeholder="Начальный ip адрес" value="<?php echo @$data['ipStart']?>" required maxlength="15">
                                <input class="form-control mb-4 col-12 col-sm-6 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="ipEnd" type="text" placeholder="Конечный ip адрес" value="<?php echo @$data['ipEnd']?>" required maxlength="15">
                            </div>
                            <div class="row pt-2 pl-3 pr-3">
                                <input class="form-control mb-4 col-12 col-sm-6 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="portStart" type="text" placeholder="Начальный порт" value="<?php echo @$data['portStart']?>" required maxlength="8">
                                <input class="form-control mb-4 col-12 col-sm-6 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="portEnd" type="text" placeholder="Конечный порт" value="<?php echo @$data['portEnd']?>" required maxlength="8">
                            </div>
                            <button class="btn <?php echo $btnColor?> btn-block my-4" type="submit" name="ipScanButton" value='Scann'>Начать сканирование</button>
                        </form>
                        <?php
                            if( isset($data['ipScanButton']) ){
                                $errors = array();
                                if( trim($data['ipStart']) == ''){
                                    $errors[]= 'Введите начальный ip';
                                }
                                if( trim($data['ipEnd']) == ''){
                                    $errors[]= 'Введите конечный ip';
                                }
                                if( trim($data['portStart'] == '')){
                                    $errors[]= 'Введите начальный порт';
                                }
                                if( trim($data['portEnd'] == '')){
                                    $errors[]= 'Введите конечный порт';
                                }
                                if (empty($errors)) {
                                    
                                    error_reporting(0);
                                    $from = $_POST['ipStart'];
                                    $to = $_POST['ipEnd'];
                                    $port1=$_POST['portStart'];
                                    $port2=$_POST['portEnd'];
                                    $arry1 = explode(".",$from);
                                    $arry2 = explode(".",$to);
                                    $a1 = $arry1[0]; $b1 = $arry1[1]; $c1 = $arry1[2]; $d1 = $arry1[3];
                                    $a2 = $arry2[0]; $b2 = $arry2[1]; $c2 = $arry2[2]; $d2 = $arry2[3];
                                    insertAction(0, 'setting', $userFormPhone, 'admin', 'Запуск сканера сети', "Сканер запущен успешно. Сканирование запущено от $a1.$b1.$c1.$d1 до  $a2.$b2.$c2.$d2", $linkRegistration,  'Scanner', $today);
                                    while( $d2 >= $d1 || $c2 > $c1 || $b2 > $b1 || $a2 > $a1){
                                        if($d1 > 255){
                                            $d1 = 1;
                                            $c1 ++;
                                        }
                                        if($c1 > 255){
                                            $c1 = 1;
                                            $b1 ++;
                                        }
                                        if($b1 > 255){
                                            $b1 = 1;
                                            $a1 ++;
                                        }
                                        $ip = "$a1.$b1.$c1.$d1";
                                        for($i=$port1;$i<(int)$port2+1;$i++) {
                                            $tB = microtime(true);
                                            $fP = fsockopen($ip, $i, $errno, $errstr, 1);
                                            $tA = microtime(true);
                                            ?>
                                            <?php
                                            if (!$fP) {
                                                echo $ip.":".$i." – down";
                                            }else {
                                                echo $ip.":".$i." – ".round((($tA - $tB) * 1000), 0)." ms";
                                            }
                                            echo "<br>";
                                            flush();
                                        }
                                        $d1 ++;
                                    }
                                    insertAction(0, 'setting', $userFormPhone, 'admin', 'Остановка сканера сети', "Сканер закончил сканирование успешно. Сканирование закончено", $linkRegistration,  'Scanner', $today);
                                    }else {
                                        $message = array_shift($errors);
                                        $color = 'alert-danger';
                                    }
                            };
                        ?>
                    <?php }
                    ?>
                </div>
                <?php }?>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
    </div>
    <?php if ($_GET['id'] != "3" && $_GET['id'] != "2") {require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php';}?>
</div>
</main>
<div class="modal fade" id="centralModalLGInfoDemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" data-gtm-vis-first-on-screen-2340190_1302="15224" data-gtm-vis-total-visible-time-2340190_1302="100" data-gtm-vis-has-fired-2340190_1302="1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Информация о системе 2.8.5</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">×</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body <?php echo $bgColorCard?>">
                <div class="text-center <?php echo $colorTextContant?>">
                    <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                    <p>Спасибо, что используете программное обеспечение IP Phone Control.
                    </p>
                    <p>Изменения в версии 2.8.5
                    </p>
                </div>
                <div class="text-left pl-5 <?php echo $colorTextContant?>">
                    <p>1. Добавлен новый ID бота в web - интерфейс. 
                    </p>
                    <p>2. Изменены места расположения ссылок на странице администрирование. Так на станицу "прочее" перемещенны "Настройка кнопок автоматической рассылки", "Работа с базой данных".
                    </p>
                    <p>3. Добавлен параметр для отслеживания состояния "Уровня звонка телефона".
                    </p>
                    <p>4. Добавлен параметр для отслеживания состояния "Переадресации".
                    </p>
                    <p>5. Улучшена информативность сообщений от бота.
                    </p>
                    <p>6. Добавлена блокировка компьютера после 5 неудачных попыток авторизации по ip.
                    </p>
                    <p>7. Добавлена очистка базы данных заблокированных адресов.
                    </p>
                    <p>8. Добавлен список поддерживаемых ссылок Action URL.
                    </p>
                    <p>9. Исправление ошибок.
                    </p>
                </div>
            </div>
            <?php 
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
            ?>
            <!--Footer-->
            <div class="modal-footer <?php echo $bgColorCard?>">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="options text-left mt-1 <?php echo $colorTextContant?> ">
                                <p>
                                    IP адрес сервера <?php echo $_SERVER['SERVER_ADDR'];?>
                                </p>
                                <p>
                                    IP адрес клиента <?php echo $ip;;?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 text-right pt-3">
                            <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Закрыть</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>
</body>

</html>