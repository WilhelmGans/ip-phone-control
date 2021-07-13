<div class="row">
    <div class="col-lg-9 mb-4">
        <div class="card wow slideInLeft">
            <div class="card-body <?php echo $bgColorCard?>">
                <div class="card-title p-3 <?php echo $colorTextContant?>">
                    Последние события
                </div>
                <div class="card-text">
                    <?php
                        $lastActions = getActions();
                        $i = 0;
                        global $arrayIconForActions;
                        foreach ($lastActions as $lastAction){
                            $typeAction = $lastAction['type'];
                            $user = $lastAction['user'];
                            $userLevel = $lastAction['user_level'];
                            $textAction = substr($lastAction['text'], 0, 200);
                            $subject = $lastAction['subject'];
                            $id = $lastAction['id'];
                            if ($i === 7){
                                break;
                            };
                            $iconforActionType = generateIconForActions($typeAction);
                            if ($typeUser === "admin") {
                                ?>
                                <a href="page/action.php?id=<?php echo $id?>" class="<?php echo $colorTextContant?>">
                                    <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-2 p-2 text-center">
                                                <i class="<?php echo $iconforActionType?>"> <?php echo $typeAction?></i><br>
                                                <span><?php echo $user, ' ', $userLevel?></span>
                                            </div>
                                            <div class="col-md-12 col-lg-8 p-2 text-left "><?php echo $textAction,' ...' ?></div>
                                            <div class="col-md-12 col-lg-2 p-2 text-center"><?php echo $subject ?></div>
                                        </div>
                                    </div>
                                </a>
                            <?php $i++; }elseif ($typeUser === $userLevel) {?>
                                <a href="page/action.php?id=<?php echo $id?>" class="<?php echo $colorTextContant?>">
                                    <div class="container-fluid mb-1 border border-light rounded waves-effect">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-2 p-2 text-center">
                                                <i class="<?php echo $iconforActionType?>"> <?php echo $typeAction?></i><br>
                                                <span><?php echo $user, ' ', $userLevel?></span>
                                            </div>
                                            <div class="col-md-12 col-lg-8 p-2 text-left "><?php echo $textAction,' ...' ?></div>
                                            <div class="col-md-12 col-lg-2 p-2 text-center"><?php echo $subject ?></div>
                                        </div>
                                    </div>
                                </a>
                            <?php $i++;}
                        };
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require 'generate/generatePieChartAndErrorPhone.php'?>
</div>