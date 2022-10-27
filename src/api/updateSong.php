<?php
    function updateSong(){
        $config = include('../config.php');

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        $stmt = $db->prepare('UPDATE song SET judul=?, genre=?, tanggal_terbit=? WHERE song_id=?');
        $stmt->execute(array($_POST['judul'], $_POST['genre'], $_POST['tanggal_terbit'], $_POST['song_id']));
    }

    if(isset($_POST['judul'])){
        updateSong();
        header("Location: /song/admin-page.php?id={$_POST['song_id']}");
        exit;
    }
?>
