<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/head.php' ?>
<?php 
/*echo date('H:i:s')."     ";
echo $oldTime = date('H:i:s')."     ";
echo $newTime = date("H:i:s", strtotime("$oldTime +30 minutes" ))."     ";
if (date('H:i:s') == date('H:i:s')) {
    echo "yes";
}*/
if(!empty($message)) { ?>
    <div style="color:red;"><?php echo $message; ?></div><hr>
<?php } ?>
<body class="grey lighten-3">
    <div class="container wow fadeInUp">
        <form class="p-5 mt-5" action="/authenticate.php" method="POST">
            <p class="h4 mb-4 text-center">Вход</p>
            <input class="form-control mb-4" name="username" id="username" type="text" placeholder="Логин" required>
            <input class="form-control mb-4" name="password" id="password" type="password" placeholder="Пароль" required>
            <div class="d-flex justify-content-between">
            </div>
            <button class="btn btn-indigo btn-block my-4" type="submit">Войти</button>
            <div class="text-center">
                <small>
                    <div class="py-3">© 2020-<?php echo date("Y")?> VECTOR</div>
                </small>
            </div>
        </form>
    </div>
</body>

</html>
