<div id="modal">
    <?php
        $modalIpPhones = getFullOptionsPhones();
        global $arrayIcon;
        global $arrayColor;
        foreach ($modalIpPhones as $modalIpPhone) {
            $idForLinlSetting = $modalIpPhone['id'];
            $idForModal = $modalIpPhone['number'];
            $typePhone = $modalIpPhone['type_phone'];
            $depends = $modalIpPhone['depends'];
            $checkPing = $modalIpPhone['check_ping'];
            $ipPhone = $modalIpPhone['ip'];
            if ($checkPing === "0") {
                $disabled = "disabled";
                $linkForm = "";
            }elseif ($checkPing === "1" || $checkPing === "2" || $checkPing === "3" || $checkPing === "4" || $checkPing === "5") {
                $disabled = "";
                $linkForm = "/scriptPHP/sendMessage/sendScriptForModal.php";
            }
            if ($typePhone === "primary"){
                ?>
                <div class="modal fade" id="modalFor<?php echo $idForModal ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" wfd-invisible="true" data-gtm-vis-first-on-screen-2340190_1302="182897" data-gtm-vis-total-visible-time-2340190_1302="100" data-gtm-vis-has-fired-2340190_1302="1" aria-hidden="true">
                    <div class="modal-dialog cascading-modal" role="document">
                        <!--Content-->
                        <div class="modal-content <?php echo $bgColorCard?>">
                            <!--Modal cascading tabs-->
                            <div class="modal-c-tabs <?php echo $bgColorCard?>">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs md-tabs tabs-2 <?php echo $orangColor?> p-2 rounded " role="tablist" <?php echo $orangColorBorder?>>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link color-light active" data-toggle="tab" href="#primary<?php echo $idForModal ?>" role="tab" aria-selected="true">
                                            <i class="fas fa-phone-alt mr-1"></i>Основной телефон</a>
                                    </li>
                                    <?php
                                        $numberID = $dbphones->query("SELECT `number` FROM `phones` WHERE `depends`='$idForModal'");
                                        $numberID = mysqli_fetch_assoc($numberID);
                                        $numberID = $numberID['number'];
                                        if ($numberID != ""){?>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link color-light" data-toggle="tab" href="#secondary<?php echo $idForModal ?>" role="tab" aria-selected="false"> Зависимый телефон <i class="fas fa-phone mr-1"></i></a>
                                            </li>
                                        <? }
                                    ?>
                                    
                                </ul>
                                <!-- Tab panels -->
                                <div class="tab-content <?php echo $bgColorCard?>">
                                    <!--Panel 17-->
                                    <div class="tab-pane fade in active show fadeIn" id="primary<?php echo $idForModal ?>" role="tabpanel" wfd-invisible="true">
                                        <!--Body-->
                                        <div class="modal-body mb-1">
                                            <?php
                                                $parametres = generateParametresForModal($checkPing);
                                            ?>
                                            <div class="container-fluid p-1 rounded <?php echo $parametres['2'] ?> lighten-1 text-light">
                                                <div class="row">
                                                    <div class="col-6 col-sm-6"><?php echo $idForModal ?></div>
                                                    <div class="col-2 col-sm-4 d-flex justify-content-end">
                                                        <a href="#">
                                                            <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right"><?php echo $parametres['0'] ?><i class="<?php echo $parametres['1'] ?>"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="col-4 col-sm-2 d-flex justify-content-end">
                                                        <a href="#" onclick="updatePhones();">
                                                            <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right">update <i class="fas fa-undo-alt"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="#" name="formMessagePrimary" method="POST" class="<?php echo $colorTextContant?>" id="forSendMsModal<?php echo $idForModal?>">
                                                <div class="md-form form-sm">
                                                    <i class="fas fa-address-card prefix active"></i>
                                                    <input type="text" name="title" id="themeForPrimary<?php echo $idForModal ?>" class="form-control form-control-sm <?php echo $colorTextContant?>" required>
                                                    <label for="themeForPrimary<?php echo $idForModal ?>" class="active <?php echo $colorTextContant?>">Тема</label>
                                                </div>
                                                <input type="text" name="number" id="number<?php echo $idForModal ?>" class="form-control none" value="<?php echo $idForModal?>">
                                                <input type="text" name="link" id="link<?php echo $idForModal ?>" class="form-control none" value="<?php echo $urlModal = $_SERVER['REQUEST_URI'];?>">
                                                <div class="md-form amber-textarea active-amber-textarea">
                                                    <i class="fas fa-envelope prefix"></i>
                                                    <textarea id="textMessage<?php echo $idForModal ?>" name="content" class="md-textarea form-control <?php echo $colorTextContant?>" rows="3" required></textarea>
                                                    <label for="textMessage<?php echo $idForModal ?>" class="<?php echo $colorTextContant?>">Текст вашего сообщения</label>
                                                </div>
                                                <div class="text-center mt-4">
                                                    <button class="btn <?php echo $btnColor?> waves-effect waves-light" type="button" onclick="sendMessageModal('#forSendMsModal<?php echo $idForModal?>')" <?php echo $disabled?>>Отправить</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--Footer-->
                                        <div class="modal-footer">
                                            <?php
                                            if ($_SESSION['access'] === "admin") {?>
                                                <div class="options text-left mt-1 <?php echo $logoColorText?> ">
                                                    <p>
                                                        <i class="fas fa-cog"></i>
                                                        <a href="/page/phoneSetting.php?id=<?php echo $idForLinlSetting?>" class="<?php echo $logoColorText?>"> Настройка</a>
                                                    </p>
                                                    <p>
                                                        <i class="fas fa-cog"></i>
                                                        <a href="http://<?php echo $ipPhone ?>" class="<?php echo $logoColorText?>" target = "_blank"> Перейти к телефону</a>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <button type="button" class="btn <?php echo $btnOutlineColor?> waves-effect ml-auto" data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                    <!--/.Panel 7-->
                                    <!--Panel 18-->
                                    <div class="tab-pane fade" id="secondary<?php echo $idForModal?>" role="tabpanel" wfd-invisible="true">
                                        <ul class="nav md-pills nav-justified <?php echo $orangColor ?>">
                                            <?php
                                            //$modalIpPhonesSecondary = getFullOptionsPhones();
                                            $modalIpPhonesSecondary = $dbphones->query("SELECT * FROM `phones` WHERE depends = '$idForModal'");
                                            global $idForModal;
                                            global $arrayIcon;
                                            global $arrayColor;
                                            foreach ($modalIpPhonesSecondary as $modalIpPhoneSecondary) {
                                                $idForModalSecondary = $modalIpPhoneSecondary['number'];
                                                $typePhone = $modalIpPhoneSecondary['type_phone'];
                                                $depends = $modalIpPhoneSecondary['depends'];
                                                $checkPing = $modalIpPhoneSecondary['check_ping'];
                                                $ipPhone = $modalIpPhoneSecondary['ip'];
                                                if ($depends == $idForModal){
                                                    ?>
                                                    <li class="nav-item waves-effect waves-light">
                                                        <a class="nav-link " data-toggle="tab" href="#formMessage<?php echo $idForModalSecondary ?>" role="tab" aria-selected="false"><?php echo $idForModalSecondary ?></a>
                                                    </li>
                                                    <?php
                                                };
                                            };
                                            ?>
                                        </ul>
                                        <!--Body-->
                                        <?php
                                        $i = 0;
                                        foreach ($modalIpPhonesSecondary as $modalIpPhoneSecondary) {
                                            $idForLinkSettingSecondary = $modalIpPhoneSecondary['id'];
                                            $idForModalSecondary = $modalIpPhoneSecondary['number'];
                                            $typePhone = $modalIpPhoneSecondary['type_phone'];
                                            $depends = $modalIpPhoneSecondary['depends'];
                                            $checkPing = $modalIpPhoneSecondary['check_ping'];
                                            $ipPhone = $modalIpPhoneSecondary['ip'];
                                            if ($checkPing === "0") {
                                                $disabled = "disabled";
                                                $linkForm = "";
                                            }elseif ($checkPing === "1") {
                                                $disabled = "";
                                                $linkForm = "/sendMessage/sendScriptForModal.php";
                                            }
                                            if ($depends == $idForModal){
                                                if ($i == 0){$show = "in show active";}else{$show = "";};// установка класса на первый элемент
                                                ?>
                                                <div class="tab-pane fade <?php echo $show ?> collapse fadeIn" id="formMessage<?php echo $idForModalSecondary ?>" role="tabpanel" wfd-invisible="true">
                                                <!--Body-->
                                                <div class="modal-body mb-1">
                                                <?php
                                                    $parametres = generateParametresForModal($checkPing);
                                                    ?>
                                                    <div class="container-fluid p-1 rounded <?php echo $parametres['2'] ?> lighten-1 text-light">
                                                        <div class="row">
                                                            <div class="col-6 col-sm-6"><?php echo $idForModalSecondary ?></div>
                                                            <div class="col-2 col-sm-4 d-flex justify-content-end">
                                                                <a href="#"><span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right"><?php echo $parametres['0'] ?><i class="<?php echo $parametres['1'] ?>"></i></span></a>
                                                            </div>
                                                            <div class="col-4 col-sm-2 d-flex justify-content-end">
                                                                <a href="#" onclick="updatePhones();">
                                                                    <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right">update <i class="fas fa-undo-alt"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="#" name="formMessageSecondaty" method="POST" class="<?php echo $colorTextContant?>" id="forSendMsModal<?php echo $idForModalSecondary?>">
                                                        <div class="md-form form-sm">
                                                            <i class="fas fa-address-card prefix active"></i>
                                                            <input type="text" name="title" id="themeForPrimary<?php echo $idForModalSecondary ?>" class="form-control form-control-sm <?php echo $colorTextContant?>" required>
                                                            <label for="themeForPrimary<?php echo $idForModalSecondary ?>" class="active <?php echo $colorTextContant?>">Тема</label>
                                                        </div>
                                                        <input type="text" name="number" id="number<?php echo $idForModalSecondary ?>" class="form-control none" value="<?php echo $idForModalSecondary?>">
                                                        <input type="text" name="link" id="link<?php echo $idForModalSecondary ?>" class="form-control none" value="<?php echo $urlModal = $_SERVER['REQUEST_URI'];?>">
                                                        <div class="md-form amber-textarea active-amber-textarea">
                                                            <i class="fas fa-envelope prefix"></i>
                                                            <textarea id="textMessage<?php echo $idForModalSecondary ?>" name="content" class="md-textarea form-control <?php echo $colorTextContant?>" rows="3" required></textarea>
                                                            <label for="textMessage<?php echo $idForModalSecondary ?>" class="<?php echo $colorTextContant?>">Ваш текст сообщения</label>
                                                        </div>
                                                        <div class="text-center mt-4">
                                                            <button class="btn <?php echo $btnColor?> waves-effect waves-light" type="button" onclick="sendMessageModal('#forSendMsModal<?php echo $idForModalSecondary?>')" <?php echo $disabled?>>Отправить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!--Footer-->
                                                <div class="modal-footer">
                                                    <?php
                                                    if ($_SESSION['access'] === "admin") {?>
                                                        <div class="options text-left mt-1 <?php echo $logoColorText?>">
                                                            <p>
                                                                <i class="fas fa-cog"></i>
                                                                <a href="/page/phoneSetting.php?id=<?php echo $idForLinkSettingSecondary?>" class="<?php echo $logoColorText?>"> Настройка</a>
                                                            </p>
                                                            <p>
                                                                <i class="fas fa-cog"></i>
                                                                <a href="http://<?php echo $ipPhone ?>" class="<?php echo $logoColorText?>" target = "_blank"> Перейти к телефону</a>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                    <button type="button" class="btn <?php echo $btnOutlineColor?> waves-effect ml-auto" data-dismiss="modal">Закрыть</button>
                                                </div>
                                            </div>
                                                <?php
                                                $i += 1;
                                            };
                                        };
                                        ?>
                                        <!--Footer-->
                                    </div>
                                    <!--/.Panel 8-->
                                </div>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <?php
            };
        };
        
    ?>
</div>
<script type="text/javascript">
    function updatePhones() {
        $.get("/scriptPHP/updateErrorPhone.php");
        //alert("Проверка телефонов запущена");
        swal({
                title: "Проверка телефонов запущена",
                text: "Нажмите на кнопку закрыть",
                icon: "success",
                button: "закрыть",
                timer: 1000
            });
        return false;
    }


    function sendMessageModal(idModal){
            swal({
                title: "Сообщения отправлены",
                text: "Нажмите на кнопку закрыть",
                icon: "success",
                button: "закрыть",
                timer: 1000
            });
            sendAjaxForm('result_form', idModal, '/scriptPHP/sendMessage/sendScriptForModal.php');
            return false;
        }

    function sendAjaxForm(result_form, ajax_form, url) {
        jQuery.ajax({
            url: url, //url страницы (sendScript.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: jQuery(ajax_form).serialize(), // Сеарилизуем объект
            error: function(response) { // Данные не отправлены
                document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
            }
        });
    }
</script>
