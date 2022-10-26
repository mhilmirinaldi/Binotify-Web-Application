<?php
    function albumDetail(){
        $config = include('../config.php');

        if(!(isset($_GET['id']) && $_GET['id'] != '')){
            throw new Exception("400: album id must be provided");
        }

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('SELECT album_id, judul, penyanyi, tanggal_terbit, total_duration, genre, image_path
                              FROM album WHERE album_id=?');
        $stmt->execute(array($_GET['id']));
        $album = $stmt->fetch(PDO::FETCH_ASSOC);
        if($album === false){
            throw new Exception("404: album with the given id is not found");
        }

        $stmtsongs = $db->prepare('SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path
                                   FROM song WHERE album_id=?');
        $stmtsongs->execute(array($_GET['id']));
        $songs = $stmtsongs->fetchAll(PDO::FETCH_ASSOC);

        $album['songs'] = $songs;
        return $album;
    }
?>
