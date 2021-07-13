<?php
    require $_SERVER['DOCUMENT_ROOT'].'/generate/connect.php';
    $data = $_POST;
    if( isset($data['do_signup']) ){
        $errors = array();
        if( trim($data['login']) == ''){
            $errors[]= 'Введите логин!';
        }
        if( $data['password'] == ''){
            $errors[]= 'Введите пароль!';
        }
        if( $data['password_2'] != $data['password']){
            $errors[]= 'Пароли не совпадают!';
        }
        if (empty($errors)) {
            // отправляем

        }else {
            echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
        }
    };


?>
<form action="/signup.php" method="POST">
    <p>
        <input type="text" name="login" placeholder="login" value="<?php echo @$data['login']?>">
    </p>
    <p>
        <input type="password" name="password" placeholder="password" value="<?php echo @$data['password']?>">
    </p>
    <p>
        <input type="password" name="password_2" placeholder="password" value="<?php echo @$data['password_2']?>">
    </p>
    <p>
        <button type="submit" name="do_signup">Регистрация</button>
    </p>
</form>