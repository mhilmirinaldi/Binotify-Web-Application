<!DOCTYPE html>
<html>
 
<head>
    <link rel = "stylesheet" href="../style.css">
</head>
<body>
    
    <?php 
    include ("../navbar/navbargenerate.php");
    echo_card();?>
    
    <div class="main">
<?php 
    try{
        
        $upload_status = 1;
        // grab data
        $judul = $_REQUEST['judul'];
        $tanggal_terbit = $_REQUEST['tanggal_terbit'];
        $penyanyi = $_REQUEST['penyanyi'];
        $genre = $_REQUEST['genre'];
        $duration = $_REQUEST['duration'];
        $album_id = $_REQUEST['album'];

        //connect dbms
        $MYSQLICONNECT = new mysqli("localhost","root","","binotify");   
        if ($album_id ==""){
            $stmt = "INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path,image_path) VALUES ('$judul', '$penyanyi', '$tanggal_terbit', '$genre', '$duration' ,'', '')";
        }
        else{
            $stmt = "INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path,image_path,album_id) VALUES ('$judul', '$penyanyi', '$tanggal_terbit', '$genre', '$duration' ,'', '', '$album_id')";
        }
        // // add to database
        if(mysqli_query($MYSQLICONNECT, $stmt)){
            
        }
        else {
             $upload_status = 0;
        }

        // get song_id
        $stmt = "SELECT MAX(song_id) AS max_id from song";
        $query = mysqli_query($MYSQLICONNECT, $stmt);
        $row_song = mysqli_fetch_array($query);
        
        $song_id = $row_song["max_id"];

                // Relative path save file
        $relative_path = "/media/song/" . $song_id . "/";

        $target_folder = getcwd() . "/.." . $relative_path;
        
        if(!file_exists($target_folder)){
            mkdir($target_folder);
        }


        // image
        $file_image_name = $_FILES["fileImage"]["name"];
        
        $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
        
        $image_path = $relative_path . $song_id . "." . $ext;
        
        $target_file_image = $target_folder . $song_id . "." .$ext;
    

        // audio
        $file_audio_name = $_FILES["fileAudio"]["name"];
        
        $ext = pathinfo($file_audio_name, PATHINFO_EXTENSION);
        
        $audio_path = $relative_path . $song_id .  "." . $ext;

        $target_file_audio = $target_folder . $song_id . "." .$ext;

        $stmt = "UPDATE song SET audio_path = '$audio_path',image_path = '$image_path' WHERE song_id = '$song_id'";
        if(mysqli_query($MYSQLICONNECT, $stmt) and  $upload_status==1){
        }
        else {
            $upload_status =0;
        }

        if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image) and  $upload_status==1) {
           
        } else {
            $upload_status=0;
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