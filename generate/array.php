<?php
    $navbar = array('Главная', 'События', 'Рассылка', 'Администрирование', 'Пользователи');
    $navbarLink = array('homePage.php', 'page/allActions.php', 'page/sendMessage.php', 'page/adminPage.php', 'page/userSetting.php');
    $navbarAccess = array('user', 'user', 'user', 'admin', 'admin');
    $arrayIcon = array('fas fa-exclamation-triangle', 'fas fa-check');
    $arrayColor = array('badge-danger','badge-success','badge-warning','badge-info', 'badge-secondary', 'badge-default');
    $arrayIconForActions = array('far fa-envelope', 'fas fa-cog', 'fas fa-users-cog');
    // function for working with an arrays
    global $typeAction;
    function generateIconForActions($typeAction){
        global $arrayIconForActions;
        if ($typeAction === "message"){
            $iconforActionType = $arrayIconForActions[0];
        }elseif($typeAction === "setting phone" || $typeAction === "setting base" || $typeAction === "setting" || $typeAction === "Sign in" || $typeAction === "Log out"){
            $iconforActionType = $arrayIconForActions[1];
        }elseif ($typeAction === "user setting"){
            $iconforActionType = $arrayIconForActions[2];
        };
        return $iconforActionType;
    };
    global $checkPing;
    function generateParametresForModal($checkPing){
        global $arrayIcon;
        global $arrayColor;
        $parametres = array('','','');
        if ($checkPing === '0'){
            $parametres[0] = " Error ";
            $parametres[1] = $arrayIcon[0];
            $parametres[2] = $arrayColor[0];
        }elseif($checkPing === '1'){
            $parametres[0] = " Good ";
            $parametres[1] = $arrayIcon[1];
            $parametres[2] = $arrayColor[1];
        }elseif ($checkPing === '2') {
            $parametres[0] = " Good ";
            $parametres[1] = $arrayIcon[1];
            $parametres[2] = $arrayColor[2];
        }elseif ($checkPing === '3') {
            $parametres[0] = " DND on ";
            $parametres[1] = $arrayIcon[1];
            $parametres[2] = $arrayColor[3];
        }elseif ($checkPing === '4') {
            $parametres[0] = " Sound off ";
            $parametres[1] = $arrayIcon[1];
            $parametres[2] = $arrayColor[4];
        }elseif ($checkPing === '5') {
            $parametres[0] = " Redir on ";
            $parametres[1] = $arrayIcon[1];
            $parametres[2] = $arrayColor[5];
        };
        return $parametres;
    }
?>