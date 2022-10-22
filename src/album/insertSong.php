<!DOCTYPE html>
<html>
 
<head>
    <title>Insert Page page</title>
</head>
<body>
    <center>
    <?php 
        try{
            $MYSQLICONNECT = new mysqli("localhost","root","","binotify");
            
            $judul = $_REQUEST['judul'];
            $tanggal_terbit = $_REQUEST['tanggal_terbit'];
            $penyanyi = $_REQUEST['penyanyi'];
            $genre = $_REQUEST['genre'];
            // ganti disini pathnya
            $relative_path = "/../../dummy/";
            $filename = $_FILES["fileImage"]["name"];
            $audio_path = $_REQUEST['audio_path'];
            // directori image
            $target_dir = getcwd() . $relative_path;
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $target_file = $target_dir . $judul . "." .$ext;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileImage"]["name"])). " has been uploaded.";
            } else {
                echo "Erroar";
            }
            $stmt = "INSERT INTO song(judul, penyanyi, tanggal_terbit, genre, audio_path,image_path) VALUES ('$judul', '$penyanyi', '$tanggal_terbit', '$genre', '$genre', '$relative_path . $judul')";
            if(mysqli_query($MYSQLICONNECT, $stmt)){
                echo "berhasil";
            }
        } catch (PDOException $e){
            echo $e;
        }
    ?>
    </center>

</body>

</html>