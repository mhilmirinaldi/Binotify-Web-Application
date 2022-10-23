<!DOCTYPE html>
<html>
 
<head>
    <title>Insert Page page</title>
</head>
<body>
    <center>
    <?php 
        try{
            //connect dbms
            $MYSQLICONNECT = new mysqli("localhost","root","","binotify");
            
            // Relative path save file
            $relative_path = "/../../dummy/";

            // grab data
            $judul = $_REQUEST['judul'];
            $tanggal_terbit = $_REQUEST['tanggal_terbit'];
            $penyanyi = $_REQUEST['penyanyi'];
            $genre = $_REQUEST['genre'];
            $duration = $_REQUEST['duration'];

            echo $duration;

            // image
            $file_image_name = $_FILES["fileImage"]["name"];
            
            $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
            $target_file_image = getcwd() . $relative_path . $judul . "." .$ext;
            

            // audio
            $file_audio_name = $_FILES["fileAudio"]["name"];
           
            $ext = pathinfo($file_audio_name, PATHINFO_EXTENSION);
            $target_file_audio = getcwd() . $relative_path . $judul . "." .$ext;
            
            if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image)) {
                echo "The file ". htmlspecialchars( basename( $file_image_name)). " has been uploaded.";
            } else {
                echo "Error";
            }

            if (move_uploaded_file($_FILES["fileAudio"]["tmp_name"], $target_file_audio)) {
                echo "The file ". htmlspecialchars( basename( $file_audio_name)). " has been uploaded.";
            } else {
                echo "Error";
            }

            // add to database
            $stmt = "INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, audio_path,image_path) VALUES ('$judul', '$penyanyi', '$tanggal_terbit', '$genre','$genre', '$genre')";
            if(mysqli_query($MYSQLICONNECT, $stmt)){
                echo "berhasil";
            }

            // update total duration
            
        } catch (PDOException $e){
            echo $e;
        }
    ?>
    </center>

</body>

</html>