<!DOCTYPE html>
<html>
 
<head>
    <title>Insert Album</title>
    <link rel = "stylesheet" href="../style.css">
</head>
<body>
    
    <?php 
    include ("../navbar/navbargenerate.php");
    echo_card();?>
    
    <div class="main">

    <?php 
        try{ 

            $status_upload = 1;

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
            }

            // image
            $file_image_name = $_FILES["fileImage"]["name"];
            
            $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
            
            $image_path = $relative_path . "/" . $album_id . "." . $ext;
            
            $target_file_image = $target_folder . "/" . $album_id . "." .$ext;
            if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $target_file_image)  ) {
                
            } else {
                $status_upload =0;
            }

            
            // add to database
            $stmt = "INSERT INTO album(judul, penyanyi, total_duration, genre, tanggal_terbit, image_path) VALUES ('$judul', '$penyanyi', 0,'$genre', '$tanggal_terbit', '$image_path')";
            if(mysqli_query($MYSQLICONNECT, $stmt) and $status_upload = 1){
                // nothing
            }
            else{
                $status_upload = 0;
            }
        
            $song_id = $_REQUEST['song'];
            if (song_id !=""){
                $stmt = "UPDATE song SET album_id = '$album_id' WHERE song_id = '$song_id'";
                if(mysqli_query($MYSQLICONNECT, $stmt) and $status_upload = 1){
                    //nothing
                }
                else{
                    $status_upload = 0;
                }
            }


            include ("../notification/notification.php");
            if ($status_upload = 1){
                echo_notification($desc ="Berhasil menambahkan Album");
            }
            else{
                echo_notification($desc ="Gagal menambahkan Album", $image = "../notification/failed.png");
            }
        } catch (Exception $e){
            http_response_code(500);
            echo_notification($desc ="Gagal menambahkan Album", $image = "../notification/failed.png");
        }
    ?>
    </div>

</body>

</html>