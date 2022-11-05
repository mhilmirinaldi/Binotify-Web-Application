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
    <title>Insert Album</title>
    <link rel = "stylesheet" href="../style.css">
    <link rel = "stylesheet" href="../addAlbum/addAlbum.css">
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
            $status_upload = 1;

            //connect dbms
            $db =  new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
            
            
            // grab data
            $judul = $_REQUEST['judul'];
            $penyanyi = $_REQUEST['penyanyi'];
            $tanggal_terbit = $_REQUEST['tanggal_terbit'];
            $genre = $_REQUEST['genre'];
            
            // add to database
            $stmt = $db->prepare("INSERT INTO album(judul, penyanyi, total_duration, genre, tanggal_terbit, image_path) VALUES (?, ?, 0,?, ?, '')");
            $stmt->execute(array($judul, $penyanyi,$genre, $tanggal_terbit));


            // get album_id
            $stmt = $db->query("SELECT MAX(album_id) AS max_id from album");
            $row_album = $stmt->fetch(PDO::FETCH_ASSOC);
            $album_id = $row_album['max_id'];
            
            $image_path ="";
            
            // create folder for file upload
            $relative_path = "/media/album/" . $album_id;

            $target_folder = getcwd() . "/../" . $relative_path;

            if(!file_exists($target_folder)){
                mkdir($target_folder);
            }
            //cek image exist or not
            if(!isset($_FILES["fileImage"])){
                // give image dummy
                $image_path = "/media/album/0/0.png";
            }
            else{
                // Relative path save file
                $file_image = $_FILES["fileImage"]["tmp_name"];
                $file_image_name = $_FILES["fileImage"]["name"];
                $filesize = filesize($file_image);

                if ($filesize == 0 or $filesize > 3145728) {
                    $image_path = "/media/album/0/0.png";
                }
                else {

                    // image 
                    
                    $ext = pathinfo($file_image_name, PATHINFO_EXTENSION);
                    
                    $image_path = $relative_path . "/" . $album_id . "." . $ext;
                    
                    $target_file_image = $target_folder . "/" . $album_id . "." .$ext;
                    if (move_uploaded_file($file_image, $target_file_image)  ) {
                        
                    } else {
                        $status_upload =0;
                    }
                }
                
            }
            
            
            $stmt = $db->prepare("UPDATE album SET image_path = ? WHERE album_id = ?");
            $stmt->execute(array($image_path,$album_id));
            
            include ("../notification/notification.php");
            if ($status_upload = 1){
                echo_notification($desc ="Berhasil menambahkan Album");
                ?>
                <div class="addAlbumSong">
                    <a  href="/album?id=<?php echo $album_id?>">Tambahkan Lagu pada Album</a>  
                </div>
                <?php
            }
            else{
                echo_notification($desc ="Gagal menambahkan Album", $image = "../notification/failed.png");

            }
        } catch (Exception $e){
            http_response_code(500);
            include ("../notification/notification.php");
            echo_notification($desc ="Gagal menambahkan Album", $image = "../notification/failed.png");
        }
    ?>
      
</div>
    
</body>

</html>