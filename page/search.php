<?php
    require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
    $search=$_POST['search'];
    $search = trim($search);
    $search = strip_tags($search);
    $q= $dbphones->query("SELECT * FROM `actions` WHERE `theme` LIKE '%$search%' OR `id` LIKE '%$search%' OR `type` LIKE '%$search%' OR `user` LIKE '%$search%' OR `user_level` LIKE '%$search%' OR `text` LIKE '%$search%' OR `subject` LIKE '%$search%' OR `date` LIKE '%$search%'");
    $qPhone = $dbphones->query( "SELECT * FROM `phones` WHERE `number` LIKE '%$search%' OR `id` LIKE '%$search%' OR `type_phone` LIKE '%$search%' OR `block` LIKE '%$search%' OR `floor` LIKE '%$search%'");
    
?>
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-lg-9 mb-4">
            <div class="card wow slideInLeft <?php echo $bgColorCard?>">
                <div class="card-body">
                    <div class="card-title p-3">
                        <div class="row">
                            <div class="col-12 col-md-9 <?php echo $colorTextContant?>">Поиск по вашему запросу: <?php echo $search?></div>
                        </div>
                    </div>
                    <div class="card-text <?php if($_SESSION['access'] == "admin") { echo "row"; }?>">
                        <div class="col-12 <?php if($_SESSION['access'] == "admin") { echo "col-lg-8"; }?>">
                            <h5 class="text-center <?php echo $colorTextContant?>">События</h5>
                            <?php
                            foreach ($q as $itog) {
                                $textAction = substr($itog['text'], 0, 200);
                                $iconforActionType = generateIconForActions($itog['type']);
                                if ($_SESSION['access'] == "admin") {?>
                                    <a href="/page/action.php?id=<?php echo $itog['id']?>" class="<?php echo $colorTextContant?>">
                                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-2 p-2 text-center">
                                                    <i class="<?php echo $iconforActionType?>"> <?php echo $itog['type']?></i><br>
                                                    <span><?php echo $itog['user'], ' ', $itog['user_level']?></span>
                                                </div>
                                                <div class="col-md-12 col-lg-8 p-2 text-left "><?php echo $textAction,' ...' ?></div>
                                                <div class="col-md-12 col-lg-2 p-2 text-center"><?php echo $itog['subject'] ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php }elseif ($_SESSION['access'] == $itog['user_level']) {?>
                                    <a href="/page/action.php?id=<?php echo $itog['id']?>" class="<?php echo $colorTextContant?>">
                                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-2 p-2 text-center">
                                                    <i class="<?php echo $iconforActionType?>"> <?php echo $itog['type']?></i><br>
                                                    <span><?php echo $itog['user'], ' ', $itog['user_level']?></span>
                                                </div>
                                                <div class="col-md-12 col-lg-8 p-2 text-left "><?php echo $textAction,' ...' ?></div>
                                                <div class="col-md-12 col-lg-2 p-2 text-center"><?php echo $itog['subject'] ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php }; ?>
                            <?php }?>
                        </div>
                        <?php if($_SESSION['access'] == "admin") {?>
                        <div class="col-12 col-lg-4">
                            <h5 class="text-center <?php echo $colorTextContant?>">Телефоны</h5>
                            <?php
                            foreach ($qPhone as $itogPhone) {
                                $iconforActionType = generateIconForActions("setting phone");
                                if ($_SESSION['access'] == "admin") {?>
                                    <a href="/page/phoneSetting.php?id=<?php echo $itogPhone['id']?>" class="<?php echo $colorTextContant?>">
                                        <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-2 p-2 text-center">
                                                    <i class="<?php echo $iconforActionType?>"> <?php echo $itogPhone['number']?></i><br>
                                                </div>
                                                <div class="col-md-12 col-lg-8 p-2 text-left ">Страница телефона</div>
                                                <div class="col-md-12 col-lg-2 p-2 text-center"><?php echo $itogPhone['number'] ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php }else{}?>
                            <?php } ?>
                        </div>
                    <?php }else{}?>
                    </div>
                </div>
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