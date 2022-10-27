<?php
    require_once('../login/authentication.php');
    $is_admin = isAdmin();

    if(!$is_admin){
        http_response_code(403);
        echo "Unauthorized access";
        exit();
    }

    function updateSong(){
        $config = include('../config.php');
        $song_id = $_POST['song_id'];
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('SELECT song_id, image_path, audio_path, duration FROM song WHERE song_id=?');
        $stmt->execute(array($song_id));
        $song = $stmt->fetch(PDO::FETCH_ASSOC);

        $upload_status = 1;

        // File Image Handling
        $image_path ="";

        // create folder for file upload
        // Relative path save file
        $relative_path = "/media/song/" . $song_id . "/";

        $target_folder = getcwd() . "/.." . $relative_path;
        
        if(!file_exists($target_folder)){
            mkdir($target_folder);
        }

        if(!isset($_FILES["fileImage"])){
            if(!empty($song['image_path'])){
                // No file uploaded, keep existing image
                $image_path = $song['image_path'];
            } else{
                // give image dummy
                $image_path = "/media/album/0/0.png";
            }
        } else{

            // image
            $file_image = $_FILES["fileImage"]["tmp_name"];
            $file_image_name = $_FILES["fileImage"]["name"];
            $filesize = filesize($file_image);

            if ($filesize == 0 or $filesize > 3145728) {
                $image_path = "/media/album/0/0.png";
            }
            else {

                $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
                
                $image_path =$relative_path . $song_id . "." . $ext;
                
                $target_file_image = $target_folder . $song_id . "." .$ext;
                
                if (move_uploaded_file($file_image, $target_file_image) and  $upload_status==1) {
                
                } else {
                    $upload_status=0;
                }
            }
        }

        $file_audio_name = $_FILES["fileAudio"]["name"];
        if(empty($file_audio_name)){
           $audio_path = $song['audio_path'];
           $duration = $song['duration'];
        } else{
            $ext = pathinfo($file_audio_name, PATHINFO_EXTENSION);
            $audio_path = $relative_path . $song_id .  "." . $ext;
            $duration = $_POST['duration'];
            $target_file_audio = $target_folder . $song_id . "." .$ext;
            if (move_uploaded_file($_FILES["fileAudio"]["tmp_name"], $target_file_audio) and  $upload_status==1) {   
            } else {
                $upload_status=0;
            }
        }

        $stmt = $db->prepare('UPDATE song SET judul=?, genre=?, tanggal_terbit=?, image_path=?, audio_path=?, duration=? WHERE song_id=?');
        $stmt->execute(array($_POST['judul'], $_POST['genre'], $_POST['tanggal_terbit'], $image_path, $audio_path, $duration, $_POST['song_id']));
    }

    if(isset($_POST['song_id'])){
        updateSong();
        header("Location: /song?id={$_POST['song_id']}");
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! song id must be provided";
        exit();
    }
?>
