<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/header.php';
session_start();
if ($_SESSION['access'] == "user") {
    $res = mysqli_query($dbphones, "SELECT * FROM `actions` WHERE `user_level` = 'user' ORDER BY `user_level`,`id` DESC LIMIT 10");
}elseif ($_SESSION['access'] == "admin") {
    $res = mysqli_query($dbphones, "SELECT * FROM `actions` ORDER BY `id` DESC LIMIT 10");
}
// Формируем массив из 10 статей
$actionsLog = array();
if ($res){
    while($row = mysqli_fetch_assoc($res)){
        $actionsLog[] = $row;
};
if ($_SESSION['access'] == "user") {
    $urlAction = "../generate/actionAjaxUser.php";
}elseif ($_SESSION['access'] == "admin") {
    $urlAction = "../generate/actionAjax.php";
}
}?>
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-lg-9 mb-4">
            <div class="card wow slideInLeft <?php echo $bgColorCard?>">
                <div class="card-body">
                    <div class="card-title p-3 <?php echo $colorTextContant?>">
                        Все события
                    </div>
                    <div class="card-text <?php echo $colorTextContant?>" id="action" >
                        <?php
                        foreach ($actionsLog as $action){
                            $typeAction = $action['type'];
                            $user = $action['user'];
                            $textAction = substr($action['text'], 0, 300);
                            $subject = $action['subject'];
                            $id = $action['id'];
                            $userLevel = $action['user_level'];
                            $iconforActionType = generateIconForActions($typeAction);
                            if ($_SESSION['access'] == "admin") {?>
                            <a href="action.php?id=<?php echo $id?>" class="<?php echo $colorTextContant?>">
                                <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-2 p-2 text-center">
                                            <i class="<?php echo $iconforActionType?>"> <?php echo $typeAction?></i><br>
                                            <span><?php echo $user, ' ', $userLevel?></span>
                                        </div>
                                        <div class="col-md-12 col-lg-8 p-2 text-left ">
                                            <?php echo $textAction,' ...' ?>
                                        </div>
                                        <div class="col-md-12 col-lg-2 p-2 text-center">
                                            <?php echo $subject ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php }elseif ($_SESSION['access'] == $userLevel) {?>
                            <a href="action.php?id=<?php echo $id?>" class="<?php echo $colorTextContant?>">
                                <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-2 p-2 text-center">
                                            <i class="<?php echo $iconforActionType?>"> <?php echo $typeAction?></i><br>
                                            <span><?php echo $user, ' ', $userLevel?></span>
                                        </div>
                                        <div class="col-md-12 col-lg-8 p-2 text-left ">
                                            <?php echo $textAction,' ...' ?>
                                        </div>
                                        <div class="col-md-12 col-lg-2 p-2 text-center">
                                            <?php echo $subject ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php };
                        };?>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button id="more" type="button" class="btn <?php echo $btnColor?>"><i class="fas fa-arrow-circle-down"></i> Загрузить ещё</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require  $_SERVER['DOCUMENT_ROOT'].'/generate/generatePieChartAndErrorPhone.php'?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        let inProgress = false; // идет процесс загрузки
        let startFrom = 10; // позиция с которой начинается вывод данных
        let iconArray = ['far fa-envelope', 'fas fa-cog', 'fas fa-users-cog'];
        $('#more').click(function() {
            if (!inProgress) {
                $.ajax({
                    url: '<?php echo $urlAction?>', // путь к ajax-обработчику
                    method: 'POST',
                    data: {
                        "start": startFrom
                    },
                    beforeSend: function() {
                        inProgress = true;
                    }
                }).done(function(data) {
                    //alert(startFrom);
                    data = jQuery.parseJSON(data); // данные в json
                    if (data.length > 0) {
                        // добавляем записи в блок в виде html
                        $.each(data, function(index, data) {
                            if (data.type === "message"){
                                icon = iconArray[0];
                            }else if(data.type === "setting phone" || data.type === "setting base" || data.type === "Sign in" || data.type === "setting" || data.type === "Log out"){
                                icon = iconArray[1];
                            }else if (data.type === "user setting"){
                                icon = iconArray[2];
                            }else{
                                icon = iconArray[1];
                            };
                            $("#action").append(`
                                <a href="action.php?id=${data.id}" class="<?php echo $colorTextContant?>">
                                    <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-2 p-2 text-center">
                                                <i class="${icon}"> ${data.type}</i><br>
                                                <span>${data.user} ${data.user_level}</span>
                                            </div>
                                            <div class="col-md-12 col-lg-8 p-2 text-left ">${data.text} ...</div>
                                            <div class="col-md-12 col-lg-2 p-2 text-center">${data.subject}</div>
                                        </div>
                                    </div>
                                </a>
                            `);
                        });
                        inProgress = false;
                        startFrom += 10;
                    }
                });
            }
        });
    });
</script>
</main>
<!-- Footer -->
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/footer.php'?>
<?php require $_SERVER['DOCUMENT_ROOT'].'/generate/modal.php'?>
<!-- Footer -->
</body>


</html>