<?php
    require  $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
    $action = getActionsById($_GET['id']);
    $typeAction = $action['type'];
    $theme = $action['theme'];
    $user = $action['user'];
    $userLevel = $action['user_level'];
    $textAction = $action['text'];
    $subject = $action['subject'];
    $id = $action['id'];
    $dataAction = $action['date'];
    $linkRegistration = $action['linkRegistr'];
    session_start();
    ?>
        <div class="container-fluid pt-5">
            <div class="row">
                <div class="col-lg-9 mb-4">
                    <div class="card wow slideInLeft <?php echo $bgColorCard?>">
                        <div class="card-body <?php echo $colorTextContant?>">
                            <?php
                                if ($_SESSION['access'] == "admin") {?>
                                    <div class="card-title p-3 text-center">
                                        <div class="col-12 h-3 pb-1"><span><?php echo $typeAction?></span></div>
                                    </div>
                                    <div class="card-text pb-2 border-bottom border-light">
                                        <div class="container-fluid <?php echo $colorTextContant?>">
                                        <?php echo $textAction ?><br>
                                        <?php echo $linkRegistration ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mt-2 ml-2">
                                            <div class="pl-1 pt-2">От пользователя: <?php echo $user ?>.</div>
                                            <div class="pl-1 pt-2">Кому: <?php echo $subject ?></div>
                                            <div class="pl-1 pt-2">Уровень прав пользователя: <?php echo $userLevel ?>.</div>
                                        </div>
                                        <div class="col-lg-4 mt-2 ml-2">
                                            <div class="pl-1 pt-2">Тема: <?php echo $theme ?>.</div>
                                            <div class="pl-1 pt-2">Дата: <?php echo $dataAction ?></div>
                                        </div>
                                        
                                    </div>
                                <?php }elseif ($_SESSION['access'] == $userLevel) {?>
                                    <div class="card-title p-3 text-center">
                                        <div class="col-12 h-3 pb-1"><span><?php echo $typeAction?></span></div>
                                    </div>
                                    <div class="card-text pb-2 border-bottom border-light">
                                        <div class="container-fluid <?php echo $colorTextContant?>">
                                        <?php echo $textAction ?><br>
                                        <?php echo $linkRegistration ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mt-2 ml-2">
                                            <div class="pl-1 pt-2">От пользователя: <?php echo $user ?>.</div>
                                            <div class="pl-1 pt-2">Кому: <?php echo $subject ?></div>
                                            <div class="pl-1 pt-2">Уровень прав пользователя: <?php echo $userLevel ?>.</div>
                                        </div>
                                        <div class="col-lg-4 mt-2 ml-2">
                                            <div class="pl-1 pt-2">Тема: <?php echo $theme ?>.</div>
                                            <div class="pl-1 pt-2">Дата: <?php echo $dataAction ?></div>
                                        </div>
                                        
                                    </div>
                                <?php }else{ ?>
                                    <div class="card-body">
                                        <h3 class="text-center text-danger">У вас недостаточно прав</h3>
                                    </div>
                                <?php }
                            ?>
                        </div>
                    </div>
                </div>
                <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/generate/floor.php'?>
        </div>
    </main>
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php';?>
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php' ?>
</body>

</html>