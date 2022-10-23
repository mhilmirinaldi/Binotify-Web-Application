<?php
    if(empty($_GET['id'])){
        http_response_code(400);
        echo "song id must be provided";
        exit;
    }

    $config = include('../config.php');
    try{

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        $stmt = $db->prepare('SELECT song_id, judul, penyanyi, tanggal_terbit, genre, duration, audio_path FROM song WHERE song_id=?');
        $stmt->execute(array($_GET['id']));
        $song = $stmt->fetch(PDO::FETCH_OBJ);
        if($song === false){
            http_response_code(404);
            echo "song with the given id is not found";
            exit;
        }

        header('Content-type: application/json');
        echo json_encode($song);

    } catch(Exception $e){
        http_response_code(500);
        echo "server database error";
    }
?>
