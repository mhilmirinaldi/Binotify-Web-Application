<?php
    require_once('../login/authentication.php');

    $is_admin = isAdmin();
    $is_login = isLogin();
    if($is_login){
        $user_id = $_COOKIE['user_id'];
    } else{
        $user_id = null;
    }

    if($is_admin){
        include('./page-admin.php');
    } else{
        include('./page-user.php');
    }
?>
