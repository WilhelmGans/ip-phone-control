<div class="row">

<?php
    $quantityFloor = $dbphones->query("SELECT COUNT(DISTINCT `floor`) as countFloor FROM `phones` WHERE `block` = 1");// получаекм количество этажей
    $quantityFloor = mysqli_fetch_assoc($quantityFloor);

    $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `block` = '1' ORDER BY `floor` ASC LIMIT 1");// получаем минимальный упикальный номер этажа 
    $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
    $quantityFloorRaundArray = $quantityFloorRaund['floor'];
    $floorCard = 0;// для сравнения количество этажей
    while ($floorCard < $quantityFloor['countFloor']) { //генерация 1 блока за роход, количество этажей 0 < 1 выполняем
        $checkPrimaryPhone = $dbphones->query("SELECT COUNT(DISTINCT `type_phone`) as countPrimaryPhone FROM `phones` WHERE `block` = '1' && `floor` = '$quantityFloorRaundArray' && `type_phone` = 'primary'");
        $checkPrimaryPhone = mysqli_fetch_assoc($checkPrimaryPhone);
        $checkPrimaryPhone = $checkPrimaryPhone['countPrimaryPhone'];
        if ( $checkPrimaryPhone > '0') {?>        
            <div class="col-lg-6 mb-4 wow fadeInUp">
                <div class="card <?php echo $bgColorCard?>">
                    <div class="card-body">
                        <div class="card-title <?php echo $colorTextContant?>">
                        1 Корпус  <?php echo $quantityFloorRaundArray?> Этаж
                        </div>
                        <div class="card-text row" id="block1floor<?php echo $quantityFloorRaundArray?>">
                            <?php
                                $fullOptionsPhones = getFullOptionsPhones();
                                global $arrayIcon;
                                global $arrayColor;
                                foreach ($fullOptionsPhones as $fullOptionsPhone) {
                                    $number = $fullOptionsPhone["number"];
                                    $typephone = $fullOptionsPhone['type_phone'];
                                    $blockPhone = $fullOptionsPhone['block'];
                                    $floorForeach = $fullOptionsPhone['floor'];
                                    $checkPing = $fullOptionsPhone['check_ping'];
                                    if ($typephone === "primary" && $floorForeach === $quantityFloorRaund['floor'] && $blockPhone == 1){
                                        $parametres = generateParametresForModal($checkPing);
                                        ?>
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor<?php echo $number ?>" title="<?php echo $parametres['0'] ?>"><?php echo $number ?>
                                                    <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right"><?php echo $parametres['0'] ?><i class="<?php echo $parametres['1'] ?>"></i></span>
                                                </a>
                                            </div>
                                        <?php
                                    };
                                };
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        
<?php   //продолжение цикла 
        }
        $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArray' ORDER BY `floor` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
        $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
        $quantityFloorRaundArray = $quantityFloorRaund['floor'];
        $floorCard++; // + 1 для кол этажей
    };
    $quantityFloorRaund = 0;
    $quantityFloorRaundArray = 0;
    $floorCard = 0;
?>

<?php
    $quantityBlock = $dbphones->query("SELECT COUNT(DISTINCT `block`) as countBlock FROM `phones` WHERE `block` != 1");// получаекм количество корпусов для цикла while.
    $quantityBlock = mysqli_fetch_assoc($quantityBlock);

    $quantityBlockRaund = $dbphones->query("SELECT `block` FROM `phones` WHERE `block` != 1 ORDER BY `block` ASC LIMIT 1");// получаем минимальный упикальный номер корпуса 
    $quantityBlockRaund = mysqli_fetch_assoc($quantityBlockRaund);
    $quantityBlockRaundArray = $quantityBlockRaund['block'];



    $blockCard = 0;// для сравнения количество этажей
    while ($blockCard < $quantityBlock['countBlock']) {//генерация 1 блока за роход, количество этажей 0 < 1 выполняем
        $quantityFloor = $dbphones->query("SELECT COUNT(DISTINCT `floor`) as countFloor FROM `phones` WHERE `block` = '$quantityBlockRaundArray'");// получаекм количество этажей
        $quantityFloor = mysqli_fetch_assoc($quantityFloor);

        $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1");// получаем минимальный упикальный номер этажа 
        $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
        $quantityFloorRaundArray = $quantityFloorRaund['floor']; 
        while($floorCard < $quantityFloor['countFloor']){
            $checkPrimaryPhone = $dbphones->query("SELECT COUNT(DISTINCT `type_phone`) as countPrimaryPhone FROM `phones` WHERE `block` = '$quantityBlockRaundArray' && `floor` = '$quantityFloorRaundArray' && `type_phone` = 'primary'");
            $checkPrimaryPhone = mysqli_fetch_assoc($checkPrimaryPhone);
            $checkPrimaryPhone = $checkPrimaryPhone['countPrimaryPhone'];
            if ( $checkPrimaryPhone > '0') {?>
                <div class="col-lg-4 mb-4 wow fadeInUp">
                    <div class="card <?php echo $bgColorCard?>">
                        <div class="card-body">
                            <div class="card-title <?php echo $colorTextContant?>">
                            <?php echo $quantityBlockRaundArray?> Корпус  <?php echo $quantityFloorRaundArray?> Этаж 
                            </div>
                            <div class="card-text row" id="block<?php echo $quantityBlockRaundArray?>floor<?php echo $quantityFloorRaundArray?>">
                                <?php
                                    $fullOptionsPhones = getFullOptionsPhones();
                                    global $arrayIcon;
                                    global $arrayColor;
                                    foreach ($fullOptionsPhones as $fullOptionsPhone) {
                                        $number = $fullOptionsPhone["number"];
                                        $typephone = $fullOptionsPhone['type_phone'];
                                        $blockPhone = $fullOptionsPhone['block'];
                                        $floorForeach = $fullOptionsPhone['floor'];
                                        $checkPing = $fullOptionsPhone['check_ping'];
                                        if ($typephone === "primary" && $floorForeach === $quantityFloorRaund['floor'] && $blockPhone == $quantityBlockRaundArray){
                                            $parametres = generateParametresForModal($checkPing);
                                            ?>
                                                <div class="list-group list-group-flush">
                                                    <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor<?php echo $number ?>" title="<?php echo $parametres['0'] ?>"><?php echo $number ?>
                                                        <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right"><?php echo $parametres['0'] ?><i class="<?php echo $parametres['1'] ?>"></i></span>
                                                    </a>
                                                </div>
                                            <?php
                                        };
                                    };
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        ?>
<?php       //продолжение цикла 2
            $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArray' && `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
            $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
            $quantityFloorRaundArray = $quantityFloorRaund['floor'];
            $floorCard++; // + 1 для кол этажей
        }
        //продолжение цикла 1
        $quantityFloorRaund = 0;
        $quantityFloorRaundArray = 0;
        $floorCard = 0;
        $quantityBlockRaund = $dbphones->query("SELECT `block` FROM `phones` WHERE `block` > '$quantityBlockRaundArray' ORDER BY `block` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
        $quantityBlockRaund = mysqli_fetch_assoc($quantityBlockRaund);
        $quantityBlockRaundArray = $quantityBlockRaund['block'];
        //echo $blockCard;
        $blockCard++;
        //echo $blockCard; // + 1 для кол этажей
    };
?>


</div>
