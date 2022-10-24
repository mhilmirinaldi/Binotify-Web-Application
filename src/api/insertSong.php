<?php 
    try{
        //connect dbms
        $MYSQLICONNECT = new mysqli("localhost","root","","binotify");
    

        // get song_id
        $stmt = "SELECT MAX(song_id) AS max_id from song";
        $song_id = mysqli_query($MYSQLICONNECT, $stmt);
        $row_song = mysqli_fetch_array($song_id);
        
        
        // grab data
        $song_id = $row_song["max_id"] + 1;

        $judul = $_REQUEST['judul'];
        $tanggal_terbit = $_REQUEST['tanggal_terbit'];
        $penyanyi = $_REQUEST['penyanyi'];
        $genre = $_REQUEST['genre'];
        $duration = $_REQUEST['duration'];

        // Relative path save file
        $relative_path = "media/song/" . $song_id;

        $target_folder = getcwd() . "/../" . $relative_path;
        
        if(!file_exists($target_folder)){
            mkdir($target_folder);
            echo "berhasil";
        }

        // image
        $file_image_name = $_FILES["fileImage"]["name"];
        
        $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
        
        $image_path = $relative_path . "/" . $song_id . "." . $ext;
        
        $target_file_image = $target_folder . "/" . $song_id . "." .$ext;
    
        // $image_path = $relative_path . ;

        // audio
        $file_audio_name = $_FILES["fileAudio"]["name"];
        
        $ext = pathinfo($file_audio_name, PATHINFO_EXTENSION);
        
        $audio_path = $relative_path . "/" . $song_id .  "." . $ext;

        $target_file_audio = $target_folder . "/" . $song_id . "." .$ext;
        
        if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image)) {
            echo "The file ". htmlspecialchars( basename( $file_image_name)). " has been uploaded.";
        } else {
            echo "Error image";
        }

        if (move_uploaded_file($_FILES["fileAudio"]["tmp_name"], $target_file_audio)) {
            echo "The file ". htmlspecialchars( basename( $file_audio_name)). " has been uploaded.";
        } else {
            echo "Error song";
        }

        // // add to database
        $stmt = "INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, duration, audio_path,image_path) VALUES ('$judul', '$penyanyi', '$tanggal_terbit', '$genre', '$duration' ,'$audio_path', '$image_path')";
        if(mysqli_query($MYSQLICONNECT, $stmt)){
            echo "berhasil";
        }

        // update total duration
        
    } catch (PDOException $e){
        echo $e;
    }
?>