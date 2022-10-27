<?php
    require_once('../login/authentication.php');

    $user_id = $_COOKIE['user_id'];
    $is_admin = isAdmin();
    $is_login = isLogin();

    if($is_admin){
        include('./page-admin.php');
    } else{
        include('./page-user.php');
    }
?>
