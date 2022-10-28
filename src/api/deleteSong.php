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

        $stmt = $db->prepare("SELECT song_id, image_path, audio_path FROM song WHERE song_id=?");
        $stmt->execute(array($song_id));
        $song = $stmt->fetch();

        $file_image_path = getcwd() . "/.." . $song['image_path'];
        $audio_image_path = getcwd() . "/.." . $song['audio_path'];
        unlink($file_image_path);
        unlink($audio_image_path);

        $stmt = $db->prepare('DELETE FROM song WHERE song_id=?');
        $stmt->execute(array($song_id));
    }

    if(isset($_POST['song_id'])){
        deleteSong();
        header('Location: /success');
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! song id must be provided";
        exit();
    }
?>
