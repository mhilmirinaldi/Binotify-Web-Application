<?php
    if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:../home');
    exit;
}
?>
<!DOCTYPE html>
<html>
 
<head>
    <link rel = "stylesheet" href="../style.css">
</head>
<body>
    
    <?php 
    include ("../navbar/navbargenerate.php");
    require_once("../login/authentication.php");
    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
        generate_navbar(isAdmin(), $user_id);
    } 
    else{
        generate_navbar();
    }?>
    
    <div class="main">
<?php 
    try{
        $config = include('../config.php');
        $upload_status = 1;
        // grab data
        $judul = $_REQUEST['judul'];
        $tanggal_terbit = $_REQUEST['tanggal_terbit'];
        $penyanyi = $_REQUEST['penyanyi'];
        $genre = $_REQUEST['genre'];
        $duration = $_REQUEST['duration'];
        $album_id = $_REQUEST['album'];

        //connect dbms
        $db =  new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
            
        if ($album_id ==""){
            $stmt = $db->prepare("INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path,image_path) VALUES (?, ?, ?, ?, ? ,'', '')");
            $stmt->execute(array($judul, $penyanyi, $tanggal_terbit, $genre, $duration));
        }   
        else{
            $stmt = $db->prepare("INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path,image_path,album_id) VALUES (?, ?, ?, ?, ? ,'', '', '')");
            $stmt->execute(array($judul, $penyanyi, $tanggal_terbit, $genre, $duration, $album_id));
        }

        // get song_id
        $stmt =  $db->query("SELECT MAX(song_id) AS max_id from song");
        $row_song = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $song_id = $row_song["max_id"];

        $image_path ="";

        // create folder for file upload
        // Relative path save file
        $relative_path = "/media/song/" . $song_id . "/";

        $target_folder = getcwd() . "/.." . $relative_path;
        
        if(!file_exists($target_folder)){
            mkdir($target_folder);
        }

        if(!isset($_FILES["fileImage"])){
            // give image dummy
            $image_path = "/media/album/0/0.png";
        }
        else{

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


        

        // audio
        $file_audio_name = $_FILES["fileAudio"]["name"];
        
        $ext = pathinfo($file_audio_name, PATHINFO_EXTENSION);
        
        $audio_path = $relative_path . $song_id .  "." . $ext;

        $target_file_audio = $target_folder . $song_id . "." .$ext;

        $stmt = $db->prepare("UPDATE song SET audio_path = ?,image_path = ? WHERE song_id = ?");
        if($stmt->execute(array($audio_path, $image_path, $song_id))){
        }
        else {
            $upload_status =0;
        }


        if (move_uploaded_file($_FILES["fileAudio"]["tmp_name"], $target_file_audio) and  $upload_status==1) {
            
        } else {
            $upload_status=0;
        }

        include ("../notification/notification.php");
            if ($status_upload = 1){
                echo_notification($desc ="Berhasil menambahkan Lagu");
            }
            else{
                echo_notification($desc ="Gagal menambahkan Lagu", $image = "../notification/failed.png");
            }
    } catch (PDOException $e){
        echo $e;
    }
?>
</div>

</body>

</html>