<?php
    require_once('../login/authentication.php');
    $is_admin = isAdmin();

    if(!$is_admin){
        http_response_code(403);
        echo "Unauthorized access";
        exit();
    }

    function deleteSongFromAlbum($song_id, $album_id){
        $config = include('../config.php');

        if($song_id == ''){
            return;
        }

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('UPDATE song SET album_id = NULL WHERE song_id=?');
        $stmt->execute(array($song_id));
    }

    function addSongToAlbum($song_id, $album_id){
        $config = include('../config.php');

        if($song_id == ''){
            return;
        }

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('UPDATE song SET album_id = ? WHERE song_id=?');
        $stmt->execute(array($album_id, $song_id));
    }

    if(isset($_POST['album_id']) && isset($_POST['action']) && isset($_POST['song_id'])){
        $song_id = $_POST['song_id'];
        $action = $_POST['action'];
        $album_id = $_POST['album_id'];

        if($action == 'delete'){
            deleteSongFromAlbum($song_id, $album_id);
        } else if($action == 'add'){
            addSongToAlbum($song_id, $album_id);
        }

        header("Location: /album/edit-song.php?id={$album_id}");
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! album id, action, and song id must be provided";
        exit();
    }
?>
