<?php
require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
$loginProfile = $_SESSION['login'];
$data=$_POST;
if (isset($data['passwordButton'])) {
    $errors = array();
    if( $data['password'] == '' || strlen($data['password']) > 20 || strlen($data['password']) < 5){
        $errors[]= 'Проверьте пароль!';
    }
    if( $data['password_2'] != $data['password']){
        $errors[]= 'Пароли не совпадают!';
    }
    if (empty($errors)) {
        $password = $data['password'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $dbphones->query("UPDATE `accounts` SET `password` = '$password' WHERE `username` = '$loginProfile'");
        insertAction(0, 'user setting', $loginProfile, 'admin', 'Изменение пароля', "Пароль у пользователя: $loginProfile изменен успешно", $linkRegistration, $loginProfile, $today);
        $message = "Пароль изменён";
        $color = 'alert-success';
    }else {
        $message = array_shift($errors);
        $color = 'alert-danger';
    }
}
if (isset($data['loginButton'])) {
    $errors = array();
    if( $data['login'] == ''){
        $errors[]= 'Логин не введён!';
    }
    if (empty($errors)) {
        $checkLoginName = $dbphones->query("SELECT `username` FROM `accounts` WHERE `username` = '$loginForm'");
        $checkLoginName = mysqli_fetch_assoc($checkLoginName);
        $checkLoginName = $checkLoginName['username'];
        if ($checkLoginName == ""){// если пусто то такого логина нет 
            $loginForm = $data['login'];
            str_replace(" ","",$loginForm);
            $dbphones->query("UPDATE `accounts` SET `username` = '$loginForm' WHERE `username` = '$loginProfile'");
            insertAction(0, 'user setting', $loginProfile, 'admin', 'Изменение логина', "Логин у пользователя: $loginProfile изменен успешно", $linkRegistration, $loginProfile, $today);
            $_SESSION['login'] = $loginForm;
            exit("<meta http-equiv='refresh' content='0; url= /profile.php'>");
        }else{
            $errors[]= 'Логин существует!';
            $message = array_shift($errors);
            $color = 'alert-danger';
        }
        
    }else {
        $message = array_shift($errors);
        $color = 'alert-danger';
    }
}
if (isset($data['accessButton'])) {
        $accessForm = $data['access'];
        if ($accessForm === "1" || $accessForm === "0") {
            $dbphones->query("UPDATE `accounts` SET `type_user` = '$accessForm' WHERE `username` = '$loginProfile'");
            insertAction(0, 'user setting', $loginProfile, 'admin', 'Изменение уровня доступа', "Уровень доступа у пользователя: $loginProfile изменен на $accessForm успешно", $linkRegistration, $loginProfile, $today);
            $_SESSION['access'] =  $data['access'];
            exit("<meta http-equiv='refresh' content='0; url= /profile.php'>");
        }else{
            $errors[]= 'Данный уровень пользователя не предусмотрен в системе!';
            $message = array_shift($errors);
            $color = 'alert-danger';
        }
        
};
if (isset($data['colorInterfaceButton'])) {
    $colorInterfaceForm = $data['color'];
    if ($colorInterfaceForm === "dark" || $colorInterfaceForm === "white") {
        $dbphones->query("UPDATE `accounts` SET `colorinterface` = '$colorInterfaceForm' WHERE `username` = '$loginProfile'");
        exit("<meta http-equiv='refresh' content='0; url= /profile.php'>");
    }else{
        $errors[]= 'Данный вариант интерфейса для пользователя не предусмотрен в системе!';
        $message = array_shift($errors);
        $color = 'alert-danger';
    }
}
if (isset($data['typeStatusPhoneButton'])) {
    $typeStatusPhoneForm = $data['typeStatus'];
    if ($typeStatusPhoneForm === "table" || $typeStatusPhoneForm === "row") {
        $dbphones->query("UPDATE `accounts` SET `typeStatusPhone` = '$typeStatusPhoneForm' WHERE `username` = '$loginProfile'");
        exit("<meta http-equiv='refresh' content='0; url= /profile.php'>");
    }else{
        $errors[]= 'Данный вариант интерфейса для пользователя не предусмотрен в системе!';
        $message = array_shift($errors);
        $color = 'alert-danger';
    }
}
?>

    <div class="container-fluid pt-5">
        <div class="row">
            <div class="col-lg-9 mb-4">
                <div class="card wow slideInLeft <?php echo $bgColorCard?>">
                    <div class="card-body">
                        <?php if(!empty($message)) { ?>
                        <div class="alert <?php echo $color ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <?php } ?>
                        <div class="col-12 h-3 pb-1 pt-3 border-bottom border-light waves-effect <?php echo $logoColorText?>"><span><?php echo $name ?></span></div>
                        <div class="card-text">
                            <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="<?php if ($_SESSION['access'] == "user") {echo "#";}?>#password">
                                <div class="container-fluid p-2 pt-3 border-bottom border-light waves-effect pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-2">Пароль: </div>
                                        <div class="col-12 col-sm-10">
                                            ****
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="<?php if ($_SESSION['access'] == "user") {echo "#";}?>#login">
                                <div class="container-fluid p-2 pt-3 border-bottom border-light waves-effect pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-2">Логин: </div>
                                        <div class="col-12 col-sm-10">
                                            <?php echo $_SESSION['login'] ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="<?php if ($_SESSION['access'] == "user") {echo "#";}?>#access">
                                <div class="container-fluid p-2 pt-3 border-bottom border-light waves-effect pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-2">Права доступа: </div>
                                        <div class="col-12 col-sm-10">
                                            <?php echo $typeUserRU ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="#themeColor">
                                <div class="container-fluid p-2 pt-3 border-bottom border-light waves-effect pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-2">Тема: </div>
                                        <div class="col-12 col-sm-10">
                                            <?php echo $colorinterface?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="<?php echo $colorTextContant?>" data-toggle="modal" data-target="#typeStatusPhone">
                                <div class="container-fluid p-2 pt-3 border-bottom border-light waves-effect pl-4">
                                    <div class="row">
                                        <div class="col-12 col-sm-2">Вид статуса телефонов: </div>
                                        <div class="col-12 col-sm-10">
                                            <?php echo $typeStatusPhone?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php'?>
    </div>
    </main>
    <?php
    if ($_SESSION['access'] === "admin") {?>
        <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center <?php echo $colorTextContant?>">
                        <h4 class="modal-title w-100 font-weight-bold">Изменение пароля</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="profile.php" method="POST">
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5">
                                <i class="fas fa-lock prefix grey-text"></i>
                                <input type="password" id="password-1" name="password" class="form-control validate <?php echo $colorTextContant?>" maxlength=140>
                                <label data-error="wrong" class="<?php echo $colorTextContant?>" data-success="right" for="password-1">Новый пароль</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fas fa-lock prefix grey-text"></i>
                                <input type="password" id="password-2" name="password_2" class="form-control validate <?php echo $colorTextContant?>">
                                <label data-error="wrong" class="<?php echo $colorTextContant?>" data-success="right" for="password-2">Пароль ещё раз</label>
                            </div>
                            <div class="text-center <?php echo $colorTextContant?>">Требования: не менее 5 и не более 20 символов в пароле</div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="submit" name="passwordButton" class="btn <?php echo $btnColor?>">Изменить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold <?php echo $colorTextContant?>">Изменение логина</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="profile.php" method="POST">
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5 <?php echo $colorTextContant?>">
                                <i class="fas fa-address-card prefix grey-text"></i>
                                <input type="text" id="orangeForm" name="login" class="form-control validate <?php echo $colorTextContant?>">
                                <label class="<?php echo $colorTextContant?>" data-error="wrong" data-success="right" for="orangeForm">Новый логин</label>
                            </div>  
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                                <button type="submit" name="loginButton" class="btn <?php echo $btnColor?>">Изменить</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center <?php echo $colorTextContant?>">
                        <h4 class="modal-title w-100 font-weight-bold <?php echo $colorTextContant?>">Изменение прав доступа</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="profile.php" method="POST">
                        <div class="modal-body mx-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text <?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="accessUser">Права пользователя</label>
                                </div>
                                <select class="browser-default custom-select <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="access" id="accessUser">
                                    <option value="0">Пользователь</option>
                                    <option value="1">Администратор</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" name="accessButton" class="btn <?php echo $btnColor?>">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php }?>
    <div class="modal fade" id="typeStatusPhone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold <?php echo $colorTextContant?>">Изменение дизайна статуса телефонов</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="profile.php" method="POST">
                        <div class="modal-body mx-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text <?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="typeStatus">Вид статуса телефонов</label>
                                </div>
                                <select class="browser-default custom-select <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="typeStatus" id="typeStatus">
                                    <option value="row">оригинальный</option>
                                    <option value="table">таблица</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" name="typeStatusPhoneButton" class="btn <?php echo $btnColor?>">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="themeColor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold <?php echo $colorTextContant?>">Изменение темы</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="profile.php" method="POST">
                        <div class="modal-body mx-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text <?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="themeColorUser">Цвет темы</label>
                                </div>
                                <select class="browser-default custom-select <?php echo $bgColorCard?> <?php echo $colorTextContant?>" name="color" id="themeColorUser">
                                    <option value="white">white</option>
                                    <option value="dark">dark</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" name="colorInterfaceButton" class="btn <?php echo $btnColor?>">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>