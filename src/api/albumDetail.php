<?php
    header('Content-type: application/json');

    if(empty($_GET['id'])){
        http_response_code(400);
        echo "album id must be provided";
        exit;
    }

    $config = include('../config.php');
    try{

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        $stmt = $db->prepare('SELECT album_id, judul, penyanyi, total_duration, image_path, tanggal_terbit, genre FROM album WHERE album_id=?');
        $stmt->execute(array($_GET['id']));
        $song = $stmt->fetch(PDO::FETCH_OBJ);
        if($song === false){
            http_response_code(404);
            echo "album with the given id is not found";
            exit;
        }

        echo json_encode($song);

    } catch(Exception $e){
        http_response_code(500);
        echo "server database error";
    }
?>