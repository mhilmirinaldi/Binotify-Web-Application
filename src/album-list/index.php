<?php
    $config = include('../config.php');
    $db =  new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
    $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );      

    $daftar_album = $db->query("SELECT * FROM album");

    $jumlah_data = 4;
    
    $totaldata = $daftar_album->rowCount();
    $jumlah_paggination = ceil($totaldata / $jumlah_data);


    if(isset($_GET['halaman'])){
        $halaman_aktif=$_GET['halaman'];
    } else{
        $halaman_aktif=1;
    }

    $data_awal = ($halaman_aktif * $jumlah_data) - $jumlah_data;

    $stmt = $db->prepare("SELECT album_id,judul,genre,year(tanggal_terbit) as tahun,penyanyi, image_path FROM album ORDER BY judul LIMIT ? , ?");
    $stmt->execute(array($data_awal,$jumlah_data));
    // $row=$stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href="albumlist.css">
    <link rel = "stylesheet" href="../style.css">
    <title>Document</title>
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
        <div class="container">
            <h2>Daftar Album</h2>
            
        <div class = "flex-container-album">
        <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        ?>
            <div class = "flex-album" onClick = "window.location='/album?id=<?php echo $row['album_id']?>'" >
                <image class="image-album" src="<?php echo  $row['image_path'];?>">
                <div class ="judul"> <?php echo $row['judul']; ?></div>
                <span>
                    <p> <?php echo $row['tahun']; ?></p>
                    <p>&nbsp;•&nbsp;</p>
                    <p><?php echo $row['genre']; ?></p>
                </span>
                <p class="penyanyi"><?php echo $row['penyanyi']; ?></p>
                
            </div>
        <?php
        }
        ?>
        </div >
        <div class="pagination">
            <?php for ($i=1;$i<=$jumlah_paggination;$i++): ?>
            <a href="?halaman=<?php echo $i;?>">
                <?php echo $i; ?>
            </a>
            <?php endfor;?>
        </div>
    </div>
    </div>

</body>
</html>
