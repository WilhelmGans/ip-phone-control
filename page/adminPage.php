<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php'?>
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
                    <div class="card-body">
                        <div class="card-title p-3">
                            <div class="row">
                                <div class="col-12 text-center <?php echo $colorTextContant?>">Функции администрирования</div>
                            </div>
                        </div>
                        <div class="card-text">
                            <a href="adminSpecification.php?id=1" class="text-muted">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Добавить телефон</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="adminSpecification.php?id=2" class="text-muted">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Изменить данные телефона</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="adminSpecification.php?id=3" class="text-muted">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Удалить данные о телефоне</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="adminSpecification.php?id=5" class="text-muted">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Сканер сети</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/interfaces/control/interfaceControllPhones.php" class="text-muted" target="_blank">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Модуль локального управления ip-телефоном</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="adminSpecification.php?id=6" class="text-muted">
                                <div class="container-fluid mb-1 p-3  border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Прочее</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/page/downloadPage.php" class="text-muted">
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect <?php echo $colorTextContant?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <i class="fas fa-cog"> Загрузка</i><br>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>
</body>

</html>