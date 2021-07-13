<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php'?>
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-lg-9 mb-4">
        <form method="post" id="ajax_form" name="message" class="<?php echo $colorTextContant?>">
        <?php
            $quantityBlockForm = $dbphones->query("SELECT COUNT(DISTINCT `block`) as countBlock FROM `phones` ");// получаекм количество корпусов для цикла while.
            $quantityBlockForm = mysqli_fetch_assoc($quantityBlockForm);

            $quantityBlockRaundForm = $dbphones->query("SELECT `block` FROM `phones` ORDER BY `block` ASC LIMIT 1");// получаем минимальный упикальный номер корпуса 
            $quantityBlockRaundForm = mysqli_fetch_assoc($quantityBlockRaundForm);
            $quantityBlockRaundArrayForm = $quantityBlockRaundForm['block'];

            $blockCard = 0;// для сравнения количество этажей
            while ($blockCard <= $quantityBlockForm['countBlock']) {//генерация 1 блока за роход, количество этажей 0 < 1 выполняем
                $quantityFloorForm = $dbphones->query("SELECT COUNT(DISTINCT `floor`) as countFloor FROM `phones` WHERE `block` = '$quantityBlockRaundArrayForm'");// получаекм количество этажей
                $quantityFloorForm = mysqli_fetch_assoc($quantityFloorForm);

                $quantityFloorRaundForm = $dbphones->query("SELECT `floor` FROM `phones` WHERE `block` = '$quantityBlockRaundArrayForm' ORDER BY `floor` ASC LIMIT 1");// получаем минимальный упикальный номер этажа 
                $quantityFloorRaundForm = mysqli_fetch_assoc($quantityFloorRaundForm);
                $quantityFloorRaundArrayForm = $quantityFloorRaundForm['floor']; 
                while($floorCard < $quantityFloorForm['countFloor']){
                    $checkPrimaryPhoneForm = $dbphones->query("SELECT COUNT(DISTINCT `type_phone`) as countPrimaryPhone FROM `phones` WHERE `block` = '$quantityBlockRaundArrayForm' && `floor` = '$quantityFloorRaundArrayForm' && `type_phone` = 'primary'");
                    $checkPrimaryPhoneForm = mysqli_fetch_assoc($checkPrimaryPhoneForm);
                    $checkPrimaryPhoneForm = $checkPrimaryPhoneForm['countPrimaryPhone'];
                    if ( $checkPrimaryPhoneForm > '0') {?>
                    <div class="card wow slideInLeft mb-4 <?php echo $bgColorCard?>">
                        <div class="card-body <?php echo $colorTextContant?>">
                            <div class="card-title p-3">
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-start">
                                        <?php echo $quantityBlockRaundArrayForm?> Корпус  <?php echo $quantityFloorRaundArrayForm?> Этаж
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block">
                                        <label class="custom-control-label" for="checkbox-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block" accesskey="<?php echo $quantityFloorRaundArrayForm?>">Весь этаж</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-text row pl-3" id="controls-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block">
                                <?php
                                $fullOptionsPhones = getFullOptionsPhones();
                                foreach ($fullOptionsPhones as $fullOptionsPhone) {
                                    $number = $fullOptionsPhone["number"];
                                    $typephone = $fullOptionsPhone['type_phone'];
                                    $ip = $fullOptionsPhone['ip'];
                                    $floorFormForeach = $fullOptionsPhone['floor'];
                                    $blockFormForeach = $fullOptionsPhone['block'];
                                    $checkPing = $fullOptionsPhone['check_ping'];
                                    if ($checkPing === "0") {
                                        $disabled = "disabled";
                                        $colorStatusPhone = "text-danger";
                                    }else{
                                        $disabled = "";
                                        $colorStatusPhone = "text-success";
                                    };
                                    if ($typephone === "primary" && $floorFormForeach === $quantityFloorRaundArrayForm && $blockFormForeach === $quantityBlockRaundArrayForm){
                                        ?>
                                    <div class="list-group list-group-flush m-2 p-2">
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" name="numberPhones[]" id="<?php echo $number?>" value="<?php echo $number?>" <?php echo $disabled ?> >
                                            <label class="custom-control-label  <?php echo $colorStatusPhone?>" for="<?php echo $number?>"><?php echo $number?></label>
                                        </div>
                                    </div>
                                    <?php
                                    };
                                };
                            ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('#checkbox-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block').click(function() {
                            if ($(this).is(':checked')) {
                                $('#controls-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block input:checkbox').prop('checked', true);
                            } else {
                                $('#controls-<?php echo $quantityFloorRaundArrayForm?>floor<?php echo $quantityBlockRaundArrayForm?>block input:checkbox').prop('checked', false);
                            }
                        });
                    </script>
                    <?php  }     //продолжение цикла 2
                    $quantityFloorRaundForm = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArrayForm' && `block` = '$quantityBlockRaundArrayForm' ORDER BY `floor` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
                    $quantityFloorRaundForm = mysqli_fetch_assoc($quantityFloorRaundForm);
                    $quantityFloorRaundArrayForm = $quantityFloorRaundForm['floor'];
                    $floorCard++; // + 1 для кол этажей
                }
                //продолжение цикла 1
                $quantityFloorRaundForm = 0;
                $quantityFloorRaundArrayForm = 0;
                $floorCard = 0;
                $quantityBlockRaundForm = $dbphones->query("SELECT `block` FROM `phones` WHERE `block` > '$quantityBlockRaundArrayForm' ORDER BY `block` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
                $quantityBlockRaundForm = mysqli_fetch_assoc($quantityBlockRaundForm);
                $quantityBlockRaundArrayForm = $quantityBlockRaundForm['block'];
                //echo $blockCard;
                $blockCard++;
                //echo $blockCard; // + 1 для кол этажей
            };
        ?>
                <div class="card wow slideInLeft mb-4 <?php echo $bgColorCard?>">
                    <div class="card-body">
                        <div class="card-title p-3">
                            Информация сообщения
                        </div>
                        <?php if(!empty($message)) { ?>
                        <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } ?>
                        <div class="card-text container-fluid p-3" id="controls-4">
                            <input type="text" name="date" class="form-control none" value="<?php echo $today?>">
                            <div class="md-form <?php echo $colorTextContant?>">
                                <i class="fas fa-address-card prefix mr-1"></i>
                                <input type="text" name="title" id="titleMessage" class="form-control form-control-sm <?php echo $colorTextContant?>">
                                <label for="titleMessage" class="active <?php echo $colorTextContant?>">Тема</label>
                            </div>
                            <div class="md-form amber-textarea active-amber-textarea <?php echo $colorTextContant?>">
                                <i class="fas fa-envelope prefix mr-1"></i>
                                <textarea id="textMessage" class="md-textarea form-control <?php echo $colorTextContant?>" name="content" rows="3" length="2000"></textarea>
                                <label for="textMessage" class="<?php echo $colorTextContant?>">Текст сообщения</label>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <button id="send" type="button" class="btn <?php echo $btnColor?>" name="sendMessageButton"><i class="far fa-paper-plane"></i> Отправить сообщение</button>
                            </div>
                            <div id="result_form"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php require  $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
    </div>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php'?>
</div>
</main>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>
</body>
<!-- Сделать калькулятор просто так -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#send").click(
            function() {
                if (jQuery('#ajax_form input[type=checkbox]:checked').length) {
                    swal({
                        title: "Сообщения отправлены",
                        text: "Нажмите на кнопку закрыть",
                        icon: "success",
                        button: "закрыть",
                        timer: 1100
                    });
                    sendAjaxForm('result_form', 'ajax_form', '/scriptPHP/sendMessage/sendScript.php');
                    return false;
                } else {
                    swal({
                        title: "Сообщения не отправлены",
                        text: "выберите номер телефона",
                        icon: "error",
                        button: "закрыть"
                    });
                }
            }
        );
    });

    function sendAjaxForm(result_form, ajax_form, url) {
        jQuery.ajax({
            url: url, //url страницы (sendScript.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: jQuery("#" + ajax_form).serialize(), // Сеарилизуем объект
            error: function(response) { // Данные не отправлены
                //document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
                swal({
                        title: "Сообщения не отправлены",
                        text: "Ошибка. Данные не отправленны.",
                        icon: "error",
                        button: "закрыть"
                    });
            }
        });
    }
</script>

</html>