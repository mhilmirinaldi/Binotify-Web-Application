<?php
    require_once('../login/authentication.php');
    $is_admin = isAdmin();

    if(!$is_admin){
        http_response_code(403);
        echo "Unauthorized access";
        exit();
    }

    function deleteAlbum(){
        $config = include('../config.php');
        $album_id = $_POST['album_id'];
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('DELETE FROM album WHERE album_id=?');
        $stmt->execute(array($album_id));
    }

    if(isset($_POST['album_id'])){
        deleteAlbum();
        include ("../notification/notification.php");
        echo_notification($desc ="Berhasil menghapus album");
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! album id must be provided";
        exit();
    }
?>
