<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php'?>
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
                    <div class="card-body">
                        <div class="card-title p-3">
                            <div class="row">
                                <div class="col-12 col-md-9 <?php echo $colorTextContant?>">Страница загрузок</div>
                            </div>
                        </div>
                        <div class="card-text">
                            <a href="/scriptPHP/dataScanningPhone.txt" class="text-muted" download>
                                <div class="container-fluid mb-1 p-3 border border-light rounded waves-effect">
                                    <div class="row">
                                        <div class="col-12 <?php echo $colorTextContant?>">
                                            <i class="fas fa-cog"> Скачать данные телефонов</i><br>
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