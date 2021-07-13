
    <script type="text/javascript" defer>
    let statusUpdate;
    let checkPing;
    let iconStatusArray = ['fas fa-exclamation-triangle', 'fas fa-check'];
    let colorStatusArray = ['badge-danger','badge-success','badge-warning','badge-info', 'badge-secondary', 'badge-default'];
    let parametres = ['','',''];
    function parametresPhone(checkPing) {
        if (checkPing === '0'){
            parametres[0] = " Error ";
            parametres[1] = iconStatusArray[0];
            parametres[2] = colorStatusArray[0];
        }else if(checkPing === '1'){
            parametres[0] = " Good ";
            parametres[1] = iconStatusArray[1];
            parametres[2] = colorStatusArray[1];
        }else if(checkPing === '2') {
            parametres[0] = " Good ";
            parametres[1] = iconStatusArray[1];
            parametres[2] = colorStatusArray[2];
        }else if(checkPing === '3') {
            parametres[0] = " DND on ";
            parametres[1] = iconStatusArray[1];
            parametres[2] = colorStatusArray[3];
        }else if(checkPing === '4') {
            parametres[0] = " Sound off ";
            parametres[1] = iconStatusArray[1];
            parametres[2] = colorStatusArray[4];
        }else if(checkPing === '5') {
            parametres[0] = " Redir on ";
            parametres[1] = iconStatusArray[1];
            parametres[2] = colorStatusArray[5];
        };
        return parametres;
    }
    function get_cookie(name) {
    return (document.cookie.match('(^|; )' + name + '=([^;]*)') || 0)[2]
    }

    function checkDatabase() {
        if (get_cookie('DataChanged') == "Y") {
            //alert("Страница будет сейчас обновлена!!! ")
            //location.href = '<?php //echo $linkNavigate?>.php';
            $.ajax({
                    url: '/generate/phonesStatusAjax.php', // путь к ajax-обработчику
                    method: 'POST',
                    beforeSend: function() {
                        inProgress = true;
                    }
                }).done(function(data) {
                    data = jQuery.parseJSON(data); // данные в json
                    //alert("Страница будет сейчас обновлена!!! ");
                    if (data.length > 0) {
                        // добавляем записи в блок в виде html
                        <?php
                            if($typeStatusPhone == "row"){
                            $quantityBlock = $dbphones->query("SELECT COUNT(DISTINCT `block`) as countBlock FROM `phones`");// получаекм количество корпусов для цикла while.
                            $quantityBlock = mysqli_fetch_assoc($quantityBlock);
                            //echo $quantityBlock['countBlock'];

                            $quantityBlockRaund = $dbphones->query("SELECT `block` FROM `phones` ORDER BY `block` ASC LIMIT 1");// получаем минимальный упикальный номер корпуса 
                            $quantityBlockRaund = mysqli_fetch_assoc($quantityBlockRaund);
                            $quantityBlockRaundArray = $quantityBlockRaund['block'];
                            //echo $quantityBlock['countBlock']."   ".$quantityBlockRaundArray;


                            $blockCard = 0;// для сравнения количество этажей
                            while ($blockCard < $quantityBlock['countBlock']) {//генерация 1 блока за роход, количество этажей 0 < 1 выполняем
                                $quantityFloor = $dbphones->query("SELECT COUNT(DISTINCT `floor`) as countFloor FROM `phones` WHERE `block` = '$quantityBlockRaundArray'");// получаекм количество этажей
                                $quantityFloor = mysqli_fetch_assoc($quantityFloor);

                                $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1");// получаем минимальный упикальный номер этажа 
                                $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
                                $quantityFloorRaundArray = $quantityFloorRaund['floor']; 
                                while($floorCard < $quantityFloor['countFloor']){
                                ?>
                                $("#block<?php echo $quantityBlockRaundArray?>floor<?php echo $quantityFloorRaundArray?>").empty();
                                    $.each(data, function(index, data) {
                                        //alert(data.check_ping);
                                        if (data.floor == <?php echo $quantityFloorRaundArray?> && data.block == <?php echo $quantityBlockRaundArray?>) {
                                            parametres = parametresPhone(data.check_ping);
                                            //alert(<?php echo $quantityBlockRaundArray?>);
                                        $("#block<?php echo $quantityBlockRaundArray?>floor<?php echo $quantityFloorRaundArray?>").append(`
                                        <div class="list-group list-group-flush">
                                            <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">${data.number}
                                                <span class="badge ${parametres[2]} badge-pill pull-right">${parametres[0]}<i class="${parametres[1]}"></i></span>
                                            </a>
                                        </div>
                                        `);
                                        }
                                    });
                        <?php       $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArray' && `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
                                    $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
                                    $quantityFloorRaundArray = $quantityFloorRaund['floor'];
                                    $floorCard++; // + 1 для кол этажей
                                }//продолжение цикла 
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
                            $tablePhoneVariant2 = getFullOptionsPhones();
                        }elseif($typeStatusPhone == "table"){?>
                                            <?php 
                                            $quantityBlock = $dbphones->query("SELECT COUNT(DISTINCT `block`) as countBlock FROM `phones`");// получаекм количество корпусов для цикла while.
                                            $quantityBlock = mysqli_fetch_assoc($quantityBlock);
                                            //echo $quantityBlock['countBlock'];
                
                                            $quantityBlockRaund = $dbphones->query("SELECT `block` FROM `phones` ORDER BY `block` ASC LIMIT 1");// получаем минимальный упикальный номер корпуса 
                                            $quantityBlockRaund = mysqli_fetch_assoc($quantityBlockRaund);
                                            $quantityBlockRaundArray = $quantityBlockRaund['block'];
                                            //echo $quantityBlock['countBlock']."   ".$quantityBlockRaundArray;
                
                
                                            $blockCard = 0;// для сравнения количество этажей
                                            while ($blockCard < $quantityBlock['countBlock']) {//генерация 1 блока за роход, количество этажей 0 < 1 выполняем
                                                $quantityFloor = $dbphones->query("SELECT COUNT(DISTINCT `floor`) as countFloor FROM `phones` WHERE `block` = '$quantityBlockRaundArray'");// получаекм количество этажей
                                                $quantityFloor = mysqli_fetch_assoc($quantityFloor);
                
                                                $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1");// получаем минимальный упикальный номер этажа 
                                                $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
                                                $quantityFloorRaundArray = $quantityFloorRaund['floor']; 
                                                while($floorCard < $quantityFloor['countFloor']){
                                                ?>
                                                $("#block<?php echo $quantityBlockRaundArray?>floor<?php echo $quantityFloorRaundArray?>").empty();
                                                    $.each(data, function(index, data) {
                                                        //alert(data.check_ping);
                                                        if (data.floor == <?php echo $quantityFloorRaundArray?> && data.block == <?php echo $quantityBlockRaundArray?>) {
                                                            parametres = parametresPhone(data.check_ping);
                                                            //alert(<?php echo $quantityBlockRaundArray?>);
                                                        $("#block<?php echo $quantityBlockRaundArray?>floor<?php echo $quantityFloorRaundArray?>").append(`
                                                        <div class="list-group list-group-flush">
                                                            <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">${data.number}
                                                                <span class="badge ${parametres[2]} badge-pill pull-right">${parametres[0]}<i class="${parametres[1]}"></i></span>
                                                            </a>
                                                        </div>
                                                        `);
                                                        }
                                                    });
                                        <?php       $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArray' && `block` = '$quantityBlockRaundArray' ORDER BY `floor` ASC LIMIT 1"); // получаем следующий по возрастанию элемент
                                                    $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
                                                    $quantityFloorRaundArray = $quantityFloorRaund['floor'];
                                                    $floorCard++; // + 1 для кол этажей
                                                }//продолжение цикла 
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
                                            $tablePhoneVariant2 = getFullOptionsPhones();
                                            foreach ($tablePhoneVariant2 as $tablePhoneVariant2For) {
                                                $checkPing = $tablePhoneVariant2For['check_ping'];
                                                $parametres = generateParametresForModal($checkPing);
                                                ?>
                                                $("#tablePhone").empty();
                                                $.each(data, function(index, data) {
                                                    //alert(data.check_ping);
                                                        parametres = parametresPhone(data.check_ping);
                                                        //alert(<?php echo $quantityBlockRaundArray?>);
                                                    $("#tablePhone").append(`
                                                    <tr>
                                                    <th scope="row">
                                                        <a href="#" class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">
                                                            ${data.number}
                                                        </a>
                                                    </th>
                                                    <td>
                                                        <a href="#" class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">
                                                        ${data.name}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">
                                                        ${data.floor}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="<?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">
                                                            <span class="badge ${parametres[2]} badge-pill pull-right">${parametres[0]}<i class="${parametres[1]}"></i></span>
                                                        </a>
                                                    </td>   
                                                </tr>
                                                    
                                                    `);
                                                });
                                            <? }
                                            ?>
                        <?php }
                        ?>



                    }
                });
        }
    }
    setInterval(function() {
        checkDatabase();
    }, 5000);//45000
    </script>
    <script type="text/javascript">/*
        function modalCheck() {
        if (get_cookie('DataChanged') == "Y") {
            //alert("Страница будет сейчас обновлена!!! ")
            //location.href = '<?php //echo $linkNavigate?>.php';
            $.ajax({
                    url: '/generate/phonesStatusAjax.php', // путь к ajax-обработчику
                    method: 'POST',
                    beforeSend: function() {
                        inProgress = true;
                    }
                }).done(function(data) {
                    data = jQuery.parseJSON(data); // данные в json
                    //alert("Страница будет сейчас обновлена!!! ");
                    if (data.length > 0) {
                        // добавляем записи в блок в виде html
                        
                                $("#modal").empty();
                                    $.each(data, function(index, data) {
                                        //alert(data.check_ping);
                                        if (data.floor == <?php echo $quantityFloorRaundArray?> && data.block == <?php echo $quantityBlockRaundArray?>) {
                                            parametres = parametresPhone(data.check_ping);
                                            //alert(<?php echo $quantityBlockRaundArray?>);
                                        $("#modal").append(`
                                        <div class="list-group list-group-flush">
                                            <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">${data.number}
                                                <span class="badge ${parametres[2]} badge-pill pull-right">${parametres[0]}<i class="${parametres[1]}"></i></span>
                                            </a>
                                        </div>
                                        `);
                                        }
                                    });
                    }
                });
        }
    }
    setInterval(function() {
        modalCheck();
    }, 5000);//45000*/
    </script>
    
    <div class="modal fade" id="inputImageLogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content <?php echo $bgColorCard?>">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold <?php echo $colorTextContant?>">Добавить картинку профиля</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="/scriptPHP/upload.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body mx-3">
                        <?php
                            if (isset($_SESSION['message']) && $_SESSION['message'])
                            { ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?php printf('<b>%s</b>', $_SESSION['message']); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            unset($_SESSION['message']);
                            }
                        ?>
                            <div class="input-group">
                                <div class="custom-file">
                                <input class="form-control mb-4 none" name="login" type="text" value="<?php echo $login?>">
                                    <input type="file" class="custom-file-input <?php echo $bgColorCard?> <?php echo $colorTextContant?>" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="uploadedFile">
                                    <label class="custom-file-label <?php echo $bgColorCard?> <?php echo $colorTextContant?>" for="inputGroupFile01">Выберите файл</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" name="uploadBtn" value="Upload" class="btn <?php echo $btnColor?>">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- Footer -->