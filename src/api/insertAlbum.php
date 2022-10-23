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
            
            // get album_id
            $stmt = "SELECT MAX(album_id) AS max_id from album";
            $album_id = mysqli_query($MYSQLICONNECT, $stmt);
            $row_album = mysqli_fetch_array($album_id);

            // grab data
            $album_id = $row_album["max_id"] + 1;
            $judul = $_REQUEST['judul'];
            $penyanyi = $_REQUEST['penyanyi'];
            $tanggal_terbit = $_REQUEST['tanggal_terbit'];
            $genre = $_REQUEST['genre'];
            
            // Relative path save file
            $relative_path = "media/album/" . $album_id;

            $target_folder = getcwd() . "/../" . $relative_path;

            if(!file_exists($target_folder)){
                mkdir($target_folder);
                echo "berhasil";
            }

            // image
            $file_image_name = $_FILES["fileImage"]["name"];
            
            $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
            
            $image_path = $relative_path . "/" . $album_id . "." . $ext;
            
            $target_file_image = $target_folder . "/" . $album_id . "." .$ext;
            if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image)) {
                echo "The file ". htmlspecialchars( basename( $file_image_name)). " has been uploaded.";
            } else {
                echo "Error";
            }

            
            // add to database
            $stmt = "INSERT INTO album(judul, penyanyi, total_duration, genre, tanggal_terbit, image_path) VALUES ('$judul', '$penyanyi', 0,'$genre', '$tanggal_terbit', '$image_path')";
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