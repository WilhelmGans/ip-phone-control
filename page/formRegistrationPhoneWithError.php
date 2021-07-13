<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
require  $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
$numberPhoneGET = $_GET['number'];
$ipGET = $_GET['ip'];
$macGET = $_GET['mac'];
$linkHref = "/page/formRegistrationPhoneWithError.php?number=$numberPhoneGET&ip=$ipGET&mac=$macGET";



$data = $_POST;
    if( isset($data['phoneRegisterButton']) ){
        $checkPing = '0';
        $userFormPhone = $_SESSION['login'];
        $userAccessFormPhone = $_SESSION['access'];
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
                                //$dbphones->query("INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `subject`,`date`) VALUES (NULL, 'setting phone', '$userFormPhone', '$typeUserRU', 'Добавление телефона', 'Телефон с номером: $numberForm создан успешно', '$numberForm','$today')");
                                insertAction(0, 'setting phone', $loginUser, $typeUserRU, 'Добавление телефона', "Телефон с номером: $numberForm создан успешно", $linkRegistration, $numberForm, $today);
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
                                insertAction(0, 'setting phone', $loginUser, $typeUserRU, 'Добавление телефона', "Телефон с номером: $numberForm создан успешно", $linkRegistration, $numberForm, $today);
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
?>



<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-lg-9 mb-4">
            <div class="card wow slideInLeft <?php echo $bgColorCard?>">
            <?php
            if ($typeUser === "user") {?>
                <div class="card-body">
                    <h3 class="text-center text-danger">У вас недостаточно прав</h3>
                </div>
                <?php } else{
            ?>
                <div class="card-body <?php echo $colorTextContant?>">
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
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="ip" id="ipRegister" type="text" placeholder="Введите ip" value="<?php echo $ipGET?>">
                            
                            <label for="macRegister">MAC телефона</label>
                            <input class="form-control mb-4 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="mac" id="macRegister" type="text" placeholder="Введите MAC" value="<?php echo $macGET ?>" required>
                            
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
                </div>
                <?php }?>
            </div>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
    </div>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php'?>
</div>
</main>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>
</body>

</html>