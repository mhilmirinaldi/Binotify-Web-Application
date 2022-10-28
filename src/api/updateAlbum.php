<?php
    require_once('../login/authentication.php');
    $is_admin = isAdmin();

    if(!$is_admin){
        http_response_code(403);
        echo "Unauthorized access";
        exit();
    }

    function updateAlbum(){
        $config = include('../config.php');
        $album_id = $_POST['album_id'];
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare('SELECT album_id, judul, tanggal_terbit, image_path FROM album WHERE album_id=?');
        $stmt->execute(array($album_id));
        $album = $stmt->fetch(PDO::FETCH_ASSOC);

        $upload_status = 1;

        // File Image Handling
        $image_path ="";

        // create folder for file upload
        // Relative path save file
        $relative_path = "/media/album/" . $album_id . "/";

        $target_folder = getcwd() . "/.." . $relative_path;
        
        if(!file_exists($target_folder)){
            mkdir($target_folder);
        }

        if(!isset($_FILES["fileImage"]) || empty($_FILES['fileImage']['name'])){
            if(!empty($album['image_path'])){
                // No file uploaded, keep existing image
                $image_path = $album['image_path'];
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
                
                $image_path =$relative_path . $album_id . "." . $ext;
                
                $target_file_image = $target_folder . $album_id . "." .$ext;
                
                if (move_uploaded_file($file_image, $target_file_image) and  $upload_status==1) {
                
                } else {
                    $upload_status=0;
                }
            }
        }

        if(!empty($_POST['tanggal_terbit'])){
            $tanggal_terbit = $_POST['tanggal_terbit'];
        } else{
            $tanggal_terbit = $album['tanggal_terbit'];
        }

        if(!empty($_POST['judul'])){
            $judul = $_POST['judul'];
        } else{
            $judul = $album['judul'];
        }

        $stmt = $db->prepare('UPDATE album SET judul=?, genre=?, tanggal_terbit=?, image_path=? WHERE album_id=?');
        $stmt->execute(array($judul, $_POST['genre'], $tanggal_terbit, $image_path, $album_id));
    }

    if(isset($_POST['album_id'])){
        updateAlbum();
        header("Location: /album?id={$_POST['album_id']}");
        exit();
    } else {
        http_response_code(400);
        echo "Invalid request! album id must be provided";
        exit();
    }
?>
