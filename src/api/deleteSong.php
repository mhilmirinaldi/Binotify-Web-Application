<?php
    require_once('../login/authentication.php');
    $is_admin = isAdmin();

    if(!$is_admin){
        http_response_code(403);
        echo "Unauthorized access";
        exit();
    }

    function deleteSong(){
        $config = include('../config.php');
        $song_id = $_POST['song_id'];
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('DELETE FROM song WHERE song_id=?');
        $stmt->execute(array($song_id));
    }

    if(isset($_POST['song_id'])){
        deleteSong();
        include ("../notification/notification.php");
        echo_notification($desc ="Berhasil menghapus lagu");
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! song id must be provided";
        exit();
    }
?>
