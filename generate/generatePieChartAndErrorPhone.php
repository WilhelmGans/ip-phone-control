<div class="col-lg-3 mb-4">
    <div class="card mb-2 wow slideInRight <?php echo $bgColorCard?>">
        <div class="card-body">
            <canvas id="pieChart" ></canvas>
        </div>
    </div>
    <script type="text/javascript">
        const chxPie = document.getElementById('pieChart').getContext('2d');
        const myPieChart = new Chart(chxPie, {
            type: 'doughnut',
            data: {
                labels: ["Good", "Error"],
                datasets: [{
                    data: [<?php echo $phonesGood ?>,<?php echo $phonesError ?>],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545'
                    ],
                    hoverBackgroundColor: [
                        '#25933e',
                        '#e23546'
                    ],
                    cutoutPercentage: 10,
                }]
            },
            options: {
                responsive: true,
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: '<?php echo $ColorPieChart?>'
                    }
                }
            }
        });
    </script>
    <div class="card mt-4 wow slideInRight <?php echo $bgColorCard?>">
        <div class="card-body">
            <div class="card-title">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 <?php echo $colorTextContant?>">Телефоны с ошибкой</div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="/scriptPHP/updateErrorPhone.php" id="upErrorPhoneInPie">
                                <span class="badge badge-success badge-pill pull-right">update <i class="fas fa-undo-alt"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="progress mt-3 none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
                    </div>

                </div>
            </div>
            <div class="card-text row" id="phoneErrorBlock">
                <?php
                $statusIpPhones = getStatusIpPhoneCheckPing();
                foreach ($statusIpPhones as $statusIpPhone) {
                    $ipStatusIpPhone =$statusIpPhone['ip'];
                    $numberStatusIpPhone = $statusIpPhone['number'];
                    $checkPingStatusIpPhone = $statusIpPhone['check_ping'];
                    if ($checkPingStatusIpPhone === "0"){
                    ?>
                    <div class="list-group list-group-flush <?php echo $bgColorCard?> ">
                        <a href="<?php if ($_SESSION['access'] === "admin"){echo "http://".$ipStatusIpPhone;}else{echo "#";}?>" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" target="<?php if ($_SESSION['access'] === "admin"){echo "_blank";}else{echo "_self";}?>"><?php echo $numberStatusIpPhone?>
                            <span class="badge badge-danger badge-pill pull-right">Error <i class="fas fa-exclamation-triangle"></i></span>
                        </a>
                    </div>
                <?php };};
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" defer>
    let statusUpdateEror;
    let checkPingEror;
    let iconStatusArrayEror = ['fas fa-exclamation-circle fa-pulse', 'fas fa-check'];
    let colorStatusArrayEror = ['badge-danger','badge-success','badge-warning','badge-info'];
    let parametresEror = ['','',''];
    function parametresPhone(checkPing) {
        if (checkPingEror === '0'){
            parametresEror[0] = " Error ";
            parametresEror[1] = iconStatusArrayEror[0];
            parametresEror[2] = colorStatusArrayEror[0];
        }else if(checkPingEror === '1'){
            parametresEror[0] = " Good ";
            parametresEror[1] = iconStatusArrayEror[1];
            parametresEror[2] = colorStatusArrayEror[1];
        }else if(checkPingEror === '2') {
            parametresEror[0] = " Good ";
            parametresEror[1] = iconStatusArrayEror[1];
            parametresEror[2] = colorStatusArrayEror[2];
        }else if(checkPingEror === '3') {
            parametresEror[0] = " DND on ";
            parametresEror[1] = iconStatusArrayEror[1];
            parametresEror[2] = colorStatusArrayEror[3];
        };
        return parametresEror;
    }
    function get_cookie(name) {
    return (document.cookie.match('(^|; )' + name + '=([^;]*)') || 0)[2]
    }

    function checkDatabaseError() {
        if (get_cookie('DataChanged') == "Y") {
            //alert("Страница будет сейчас обновлена!!! ")
            //location.href = '<?php //echo $linkNavigate?>.php';
            $.ajax({
                    url: '/generate/phonesStatusAjaxError.php', // путь к ajax-обработчику
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
                            $statusIpPhones = getStatusIpPhoneCheckPing();
                            foreach ($statusIpPhones as $statusIpPhone) {
                                $ipStatusIpPhone =$statusIpPhone['ip'];
                                $numberStatusIpPhone = $statusIpPhone['number'];
                                $checkPingStatusIpPhone = $statusIpPhone['check_ping'];
                                if ($checkPingStatusIpPhone === "0"){
                                ?>
                                $("#phoneErrorBlock").empty();
                                    $.each(data, function(index, data) {
                                        //alert(data.check_ping);
                                        if (data.check_ping == "0") {
                                            parametresEror = parametresPhone(data.check_ping);
                                            //alert(<?php echo $quantityBlockRaundArray?>);
                                            $("#phoneErrorBlock").append(`
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action waves-effect p-3 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor${data.number}" title="${parametres[0]}">${data.number}
                                                    <span class="badge ${parametresEror[2]} badge-pill pull-right">${parametresEror[0]}<i class="${parametresEror[1]}"></i></span>
                                                </a>
                                            </div>
                                            `);
                                        }
                                    });
                        <?php };};
                        ?>
                    }
                });
        }
    }
    setInterval(function() {
        checkDatabaseError();
    }, 5000);//45000
    </script>
    <div class="card mt-4 wow slideInRight <?php echo $bgColorCard?>">
        <div class="card-body">
            <div class="card-title">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 <?php echo $colorTextContant?>">Информация о типах статусов телефонов</div>
                    </div>
                </div>
            </div>
            <div class="card-text">
                <div class="list-group list-group-flush col-12 pr-0">
                    <?php
                    $arrayTextLegend = array(' Телефон не в сети', ' Телефон в сети', ' Трубка телефона снята или идёт разговор', ' Включён режим не беспокоить', ' Отключен звук вызова',' Включена переадресация вызова');
                    for ($i=0; $i < 6; $i++) { 
                        $parametres = generateParametresForModal("$i");?>
                        <div class="container-fluid p-1 col-12">
                            <a class="list-group-item list-group-item-action waves-effect col-12 <?php echo $bgColorCard?> <?php echo $colorTextContant?>" title="<?php echo $parametres['0'] ?>" disa>
                                <span class="badge <?php echo $parametres['2'] ?> badge-pill pull-right"><?php echo $parametres['0'] ?><i class="<?php echo $parametres['1'] ?>"></i></span><?php echo $arrayTextLegend[$i]?>
                            </a>
                        </div> 
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function(){
            $( "#upErrorPhoneInPie" ).click(function(){
                $('.progress').removeClass('none');
            });
        })
    </script>
    <?php
        if ($_SERVER['REQUEST_URI']=="/page/allActions.php" || $_SERVER['REQUEST_URI'] == "/page/adminSpecification.php?id=3" || $_SERVER['REQUEST_URI'] == "/page/adminSpecification.php?id=2" || $_SERVER['REQUEST_URI'] == "/scriptPHP/search.php"){
            $quantityFloor = $dbphones->query("SELECT `properies` FROM customization WHERE `id`= '2'");
            $quantityFloor = mysqli_fetch_assoc($quantityFloor);
            $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` ORDER BY `floor` ASC LIMIT 1");
            $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
            $quantityFloorRaundArray = $quantityFloorRaund['floor'];
            $floorCard = 0;
            while ($floorCard < $quantityFloor['properies']) {
                ?>
                <div class="card wow slideInRight mt-4 <?php echo $bgColorCard?>">
                    <div class="card-body">
                        <div class="card-title <?php echo $colorTextContant?>">
                            <?php echo $quantityFloorRaundArray?> Этаж
                        </div>
                        <div class="card-text row" id="floor<?php echo $quantityFloorRaundArray?>">
                            <?php
                                $fullOptionsPhones = getFullOptionsPhones();
                                global $arrayIcon;
                                global $arrayColor;
                                foreach ($fullOptionsPhones as $fullOptionsPhone) {
                                    $number = $fullOptionsPhone["number"];
                                    $typephone = $fullOptionsPhone['type_phone'];
                                    $floorForeach = $fullOptionsPhone['floor'];
                                    $checkPing = $fullOptionsPhone['check_ping'];
                                    if ($typephone === "primary" && $floorForeach === $quantityFloorRaund['floor']){
                                        $parametres = generateParametresForModal($checkPing);
                                        ?>
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action waves-effect <?php echo $bgColorCard?> <?php echo $colorTextContant?>" data-toggle="modal" data-target="#modalFor<?php echo $number ?>"><?php echo $number ?>
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
        <?php
                $quantityFloorRaund = $dbphones->query("SELECT `floor` FROM `phones` WHERE `floor` > '$quantityFloorRaundArray' ORDER BY `floor` ASC LIMIT 1");
                $quantityFloorRaund = mysqli_fetch_assoc($quantityFloorRaund);
                $quantityFloorRaundArray = $quantityFloorRaund['floor'];
                $floorCard++;
            };
        ?>
        <?};
    ?>
</div>
