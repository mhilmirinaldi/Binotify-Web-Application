<?php
    function songDetail(){
        $config = include('../config.php');

        if(empty($_GET['id'])){
            throw new Exception("400: song id must be provided");
        }
    
        $config = include('../config.php');

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        $stmt = $db->prepare('SELECT song_id, judul, penyanyi, tanggal_terbit, genre, duration, image_path, audio_path FROM song WHERE song_id=?');
        $stmt->execute(array($_GET['id']));
        $song = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($song === false){
            throw new Exception("404: song with the given id is not found");
        }

        return $song;
    }
?>