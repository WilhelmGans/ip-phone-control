<?php
    require  $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
    $action = getPhoneById($_GET['id']);
    
    $idPhonePage = $action['id'];
    $numberPhonePage = $action['number'];
    $namePhonePage = $action['name'];
    $ipPhonePage = $action['ip'];
    $macPhonePage = $action['mac'];
    $typePhonePhonePage = $action['type_phone'];
    $dependsPhonePage = $action['depends'];
    $checkPingPhonePage = $action['check_ping'];
    $floorPhonePage = $action['floor'];
    $blockPhonePage = $action['block'];
    $chatID = $action['chatID'];
    $botStatus = $action['botStatus'];
    $portPatchPhonePage = $action['port_pp'];
    $url = $_SERVER['REQUEST_URI'];
    $loginUser = $_SESSION['login'];
    $data = $_POST;
    if( isset($data['phoneUpdateButton']) ){
        $action = getPhoneById($_GET['id']);
        $namePhoneForm = $data['namePhone'];
        $ipForm = $data['ip'];
        $blockForm = $data['blockPhone'];
        $floorForm = $data['floorPhone'];
        $dependForm = $data['numberForDepend'];
        $portPanelForm = $data['portPatchPanel'];

        $chatIDPhone = $data['IDChat'];
        $botStatusPhone = $data['botCheckPhone'];
        $errors = array();
        if( trim($data['botCheckPhone']) != '1' && trim($data['botCheckPhone']) !='0'){
            $errors[]= 'Данное состояние бота не поддерживается';
        }
        if( trim($data['ip']) == ''){
            $errors[]= 'Введите ip';
        }
        if( trim($data['portPatchPanel'] == '')){
            $errors[] = 'Введите порт';
        }
        if( trim($data['floorPhone'] == '')){
            $errors[] = 'Введите этаж';
        }
        if( trim($data['blockPhone'] == '')){
            $errors[] = 'Введите корпус';
        }
        if (empty($errors)) {
            /* if ($stmt = $dbphones->prepare('SELECT `ip` FROM phones WHERE `ip` = ?')) {
            $stmt->bind_param('s', $data['ip']);//подготовка параметров
            $stmt->execute();// отправка запроса
            $stmt->store_result(); //сохранение запроса на клиенте
            

            if ($stmt->num_rows > 0) {
                //$arrayPhonesNumberIPCheck = $dbphones->query("SELECT `number`, `ip` FROM phones WHERE `ip` = '$ipForm' ");
                $message = 'Такой ip уже есть';
                $color = 'alert-danger';
            }else {
                $dbphones->query("UPDATE `phones` SET `name`= '$namePhoneForm' ,`ip`='$ipForm', `port_pp`='$portPanelForm' WHERE `id` = $idPhonePage ");
                $dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$userAccessFormPhone', 'Изменение параметров телефона', 'Параметры у телефона номером: $numberForm изменены успешно', '$numberForm', '$today')");
                $message = 'Данные телефона '.$data['number'].' изменены!';
                $color = 'alert-success';
                $data = "";
                exit("<meta http-equiv='refresh' content='0; url= $url'>");
            }
            } else {
                $message = 'Ошибка отправки формы';
                $color = 'alert-danger';
            }*/
            if ($stmt = $dbphones->prepare('SELECT `ip` FROM phones WHERE `number` = ?')) {
                $stmt->bind_param('i', $numberPhonePage);//подготовка параметров
                $stmt->execute();
                $stmt->bind_result($ipCheck);
                $stmt->fetch();
                $stmt->close();
                $ipPhoneSetting = getIpPhone($ipForm);
                $num = $data['number'];
                //echo "sdadsad ".$ipCheck." fsdfsfsdfsf ".$data['ip']. "daadsadadas" . $numberPhonePage;
                if (($ipCheck == $data['ip']) || empty($ipPhoneSetting)) {
                    if ($typePhonePhonePage == "primary") {
                        $dbphones->query("UPDATE `phones` SET `name`= '$namePhoneForm' ,`ip`='$ipForm', `port_pp`='$portPanelForm', `block` = '$blockForm', `floor` = '$floorForm', `chatID` = '$chatIDPhone', `botStatus` = '$botStatusPhone' WHERE `id` = '$idPhonePage' ");
                        insertAction(0, 'setting phone', $loginUser, $typeUserRU, 'Изменение параметров телефона', "Параметры у телефона номером: $numberPhonePage изменены успешно", $linkRegistration, $numberPhonePage, $today);
                        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$loginUser', '$typeUserRU', 'Изменение параметров телефона', 'Параметры у телефона номером: $numberPhonePage изменены успешно', '$numberPhonePage', '$today')");
                        $message = 'Данные телефона '.$numberPhonePage.' изменены!';
                        $color = 'alert-success';
                        $data = "";
                        exit("<meta http-equiv='refresh' content='0; url= $url'>");
                    }elseif ($typePhonePhonePage == "secondary") {
                        $dbphones->query("UPDATE `phones` SET `name`= '$namePhoneForm' ,`ip`='$ipForm', `port_pp`='$portPanelForm', `block` = '$blockForm', `floor` = '$floorForm',`depends` = '$dependForm',`chatID` = '$chatIDPhone', `botStatus` = '$botStatusPhone' WHERE `id` = $idPhonePage ");
                        insertAction(0, 'setting phone', $loginUser, $typeUserRU, 'Изменение параметров телефона', "Параметры у телефона номером: $numberPhonePage изменены успешно", $linkRegistration, $numberPhonePage, $today);
                        //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$loginUser', '$typeUserRU', 'Изменение параметров телефона', 'Параметры у телефона номером: $numberPhonePage изменены успешно', '$numberPhonePage', '$today')");
                        $message = 'Данные телефона '.$numberPhonePage.' изменены!';
                        $color = 'alert-success';
                        $data = "";
                        exit("<meta http-equiv='refresh' content='0; url= $url'>");
                    }
                }else{
                    $message = 'IP '.$ipForm.' уже есть в системе.';
                    $color = 'alert-danger';
                }
                } else {
                    $message = 'Ошибка отправки формы';
                    $color = 'alert-danger';
                }
        }else {
            $message = array_shift($errors);
            $color = 'alert-danger';
        }
    };
    if( isset($data['phoneDeleteButton']) ){
        $errors = array();
        if (empty($errors)) {
            $dbphones->query("DELETE FROM `phones` WHERE `id` = '$idPhonePage'");
            insertAction(0, 'setting phone', $loginUser, 'admin', 'Изменение параметров телефона', "Номер телефона: $numberPhonePage удален успешно", $linkRegistration, $numberPhonePage, $today);
            //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$loginUser', '$typeUserRU', 'Изменение параметров телефона', 'Номер телефона: $numberPhonePage удален успешно', '$numberPhonePage','$today')");
            $message = 'Номер '.$numberPhonePage.' удален!';
            $color = 'alert-success';
            $data = "";
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
                        <?php } elseif($_SESSION['access'] === "admin"){
                    ?>
                        <div class="card-body">
                            <div class="card-title p-3 text-center <?php echo $colorTextContant?>">
                                <div class="col-12 h-3 pb-1 h4 "><span>Телефон: <?php echo $numberPhonePage?></span></div>
                                <div class="row">
                                    <div class="col-12 pl-5">
                                        <div class="row">
                                            <?php 
                                                if ($typePhonePhonePage == "primary") {?>
                                                    <span class="pl-1 h6 <?php echo $colorTextContant?>">Зависимые:  
                                                    <?php
                                                        $dependsPhonesPageSetting = $dbphones->query("SELECT `id`, `number` FROM `phones` WHERE `depends` = '$numberPhonePage'");
                                                        $countDp = 0;
                                                        foreach ($dependsPhonesPageSetting as $dependsPhonePageSetting) {
                                                            $countDp = 1;
                                                            ?>
                                                            <a class="ml-1 <?php echo $logoColorText?>" href="phoneSetting.php?id=<?php echo $dependsPhonePageSetting['id']?>"><?php echo " ".$dependsPhonePageSetting['number']?></a>
                                                        <?php }?><?php 
                                                        if ($countDp == 0) {?>
                                                            <a class="ml-1 <?php echo $logoColorText?>" ><?php echo " Нет зависимых телефонов"?></a>
                                                        <?php }?></span><?php 
                                                }else{ ?>
                                                    <span class="pl-1 h6 <?php echo $colorTextContant?>">Основной:
                                                    <?php
                                                        $dependsPhonesPageSetting = $dbphones->query("SELECT `id`, `number` FROM `phones` WHERE `number` = '$dependsPhonePage'");
                                                        foreach ($dependsPhonesPageSetting as $dependsPhonePageSetting) {
                                                            $countDp = 1;
                                                            ?>
                                                            <a class="ml-1 <?php echo $logoColorText?>" href="phoneSetting.php?id=<?php echo $dependsPhonePageSetting['id']?>"><?php echo "".$dependsPhonePageSetting['number']?></a>
                                                        <?php }?><?php 
                                                        if ($countDp == 0) {?>
                                                            <a class="ml-1 <?php echo $logoColorText?>" ><?php echo " Нет основного телефона"?></a>
                                                        <?php }?></span><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-text <?php echo $colorTextContant?>">
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <form class="pl-5 pr-5 pb-2" action="phoneSetting.php?id=<?php echo $idPhonePage?>" method="POST">
                                            <?php if(!empty($message)) { ?>
                                                <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                                                    <?php echo $message; ?>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                            <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Параметры телефона</p>

                                            <label for="ipRegister">IP телефона</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="ip" id="ipRegister" type="text" placeholder="Введите ip" value="<?php echo $ipPhonePage ?>" pattern="((^|\.)((25[0-5]_*)|(2[0-4]\d_*)|(1\d\d_*)|([1-9]?\d_*))){4}_*$" title="192.168.1.1" required>

                                            <label for="macRegister">MAC телефона</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="mac" id="macRegister" type="text" placeholder="Введите MAC" value="<?php echo $macPhonePage ?>" required disabled>

                                            <label for="portRegister">Порт на PatchPanel телефона</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="portPatchPanel" id="portRegister" type="text" placeholder="Введите порт на patch panel" value="<?php echo $portPatchPhonePage ?>" required>
                                            
                                            <label for="nameRegister">Место размещения телефона</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="namePhone" id="nameRegister" type="text" placeholder="Введите место расположения телефона" value="<?php echo $namePhonePage?>">
                                            
                                            <label for="floorRegister">Этаж</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="floorPhone" id="floorRegister" type="text" placeholder="Введите этаж расположения телефона" value="<?php echo $floorPhonePage?>" required>
                                            
                                            <label for="blockRegister">Корпус</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="blockPhone" id="blockRegister" type="text" placeholder="Введите корпус расположения телефона" value="<?php echo $blockPhonePage?>" required>
                                            
                                            <label for="IDChatRegister">ID личного чата телеграм</label>
                                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="IDChat" id="IDChatRegister" type="text" placeholder="-xxxxxxxxxxxxx" value="<?php echo $chatID?>">
                                            
                                            <label class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="botCheckPhone">Состояние бота </label>
                                                <select name="botCheckPhone" class="browser-default custom-select mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" id="botCheckPhone">
                                                    <option value="<?php echo $botStatus ?>"><?php if($botStatus == 0){echo "выключен";}elseif($botStatus == 1){echo "включен";} ?></option>
                                                    <?php if($botStatus == 0 ){?><option value="1"><?php echo "включен"; ?></option><?php }elseif($botStatus == 1){?><option value="0"><?php echo "выключен"; ?></option><?php } ?>
                                                </select>
                                            <?php 
                                                if ($typePhonePhonePage != "primary") {?>
                                                    <label class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="dependPhone">Номер основного телефона</label>
                                                    <select name="numberForDepend" class="browser-default custom-select <?php echo $bgColorCard?> <?php echo $colorTextContant?>" id="dependPhone">
                                                        <option value="<?php echo $dependsPhonePage ?>"><?php echo $dependsPhonePage ?></option>
                                                        <?php
                                                        $dependPhones = $dbphones->query("SELECT `number` FROM `phones` WHERE `number` != $dependsPhonePage AND `type_phone` = 'primary' ORDER BY `number` ASC");
                                                        foreach ($dependPhones as $dependPhone){?>
                                                            <option value="<?php echo $dependPhone['number']?>"><?php echo $dependPhone['number'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                            <?php }else{ ?><?php }
                                            ?>
                                            <button class="btn <?php echo $btnColor?> btn-block my-4 " type="submit" name="phoneUpdateButton">Изменить параметры телефона</button>
                                        </form>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <p class="h5 mb-4 text-center <?php echo $colorTextContant?>">Управление телефоном</p>
                                        <div class="d-flex flex-column justify-content-center m-2 mx-lg-5">
                                            <button type="button" class="btn btn-success mt-2" id="call"  data-toggle="modal" data-target="#callPhone" value="1">Звонок на телефон</button>
                                            <button type="button" class="btn btn-success mt-2" id="volup" onclick="getData('0','VOLUME_UP')" value="0">Увеличить громкость</button>
                                            <button type="button" class="btn btn-success mt-2" id="dndoff" onclick="getData('0','DNDOff')" value="0">Выключить режим «Не беспокоить»</button>
                                            <button type="button" class="btn btn-danger mt-5" id="reboot" onclick="getData('0','Reboot')" value="0">Перезагрузка телефона</button>
                                            <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#deletePhone">удалить телефон</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php'?>
        </div>
    </main>
    <div class="modal fade" id="deletePhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-2 <?php echo $bgColorCard?>">
                <div class="modal-header text-center <?php echo $logoColorText?>">
                    <h4 class="modal-title w-100 font-weight-bold">Удаление телефона</h4>
                    <button type="button" class="close <?php echo $colorTextContant?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="phoneSetting.php?id=<?php echo $idPhonePage?>" method="POST">
                    <p class = "text-center <?php echo $colorTextContant?> pt-1">Вы уверены, что хотите удалить запись в базе данных о телефоне <?php echo $numberPhonePage?> ?</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Нет</button>
                        <button class="btn btn-danger" type="submit" name="phoneDeleteButton">Да</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="callPhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-2 <?php echo $bgColorCard?>">
                <div class="modal-header text-center <?php echo $logoColorText?>">
                    <h4 class="modal-title w-100 font-weight-bold">Выбор линии и номера для звонка на телефон</h4>
                    <button type="button" class="close <?php echo $colorTextContant?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="m-3">
                    <p class = "text-left <?php echo $colorTextContant?> pt-1">Введите линию для звонка с номера  <?php echo $numberPhonePage?></p>
                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="lineCall" type="text" id="lineCall" value="1" require>
                    <p class = "text-left <?php echo $colorTextContant?> pt-1">Введите номер для звонка с номера  <?php echo $numberPhonePage?></p>
                    <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="numberCall" type="text" value="" placeholder="Например 401" id="nunberCall" require>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn <?php echo $btnColor?>" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="getData('1','F_HANDFREE')">Позвонить</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        <?php $dataPhones = getDataPhones();?>
        let user = "<?php echo $dataPhones['loginPhones']?>";
        let password = "<?php echo $dataPhones['passwordPhones']?>";
    </script>
    <script type="text/javascript" src="/resources/js/array.js" defer></script>
    <script type="text/javascript" src="/resources/js/processing.js" defer></script>
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php';?>
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php' ?>
</body>

</html>