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
            $penyanyi = $_REQUEST['penyanyi'];
            $tanggal_terbit = $_REQUEST['tanggal_terbit'];
            $genre = $_REQUEST['genre'];
            
            // image
            // $file_image_name = $_FILES["fileImage"]["name"];
            
            // $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
            // $target_file_image = getcwd() . $relative_path . $judul . "." .$ext;
            // if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image)) {
            //     echo "The file ". htmlspecialchars( basename( $file_image_name)). " has been uploaded.";
            // } else {
            //     echo "Error";
            // }

            
            // add to database
            $stmt = "INSERT INTO album(judul, penyanyi, total_duration, genre,image_path) VALUES ('$judul', '$penyanyi', 666,'$genre', '$genre')";
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