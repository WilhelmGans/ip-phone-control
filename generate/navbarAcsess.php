<?php
    for ($nav = 0; $nav <= count($navbar) ; $nav++) {
        if ($typeUser == "user" ){
            if ($typeUser == $navbarAccess[$nav]) {?>
                <li class="nav-item <active>">
                    <a href="/<?php echo $navbarLink[$nav]?>" class="nav-link waves-effect"><?php echo $navbar[$nav]?></a>
                </li>
            <?php } ?>
        <?php } elseif($typeUser == "admin"){?>
            <li class="nav-item <active>">
                <a href="/<?php echo $navbarLink[$nav]?>" class="nav-link waves-effect"><?php echo $navbar[$nav]?></a>
            </li>
        <?}
    };
?>