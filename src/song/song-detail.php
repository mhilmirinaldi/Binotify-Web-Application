<?php
    function songDetail(){
        $config = include('../config.php');

        if(empty($_GET['id'])){
            throw new Exception("400: song id must be provided");
        }
    
        $config = include('../config.php');

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        $stmt = $db->prepare('SELECT song_id, song.judul AS judul, song.penyanyi AS penyanyi, song.tanggal_terbit AS tanggal_terbit, song.genre AS genre, duration, song.image_path AS image_path, audio_path,
                              song.album_id AS album_id, album.judul AS album_judul, total_duration, album.image_path AS album_image_path, album.tanggal_terbit AS album_tanggal_terbit, album.genre AS album_genre
                              FROM song LEFT OUTER JOIN album ON song.album_id = album.album_id
                              WHERE song_id=?');
        $stmt->execute(array($_GET['id']));
        $song = $stmt->fetch(PDO::FETCH_ASSOC);

        if($song === false){
            throw new Exception("404: song with the given id is not found");
        }

        return $song;
    }
?>