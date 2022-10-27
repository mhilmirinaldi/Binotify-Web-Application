<?php
    $config = include('../config.php');
    $MYSQLICONNECT = new  mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);

    $stmt = "SELECT * FROM album";
    $daftar_album = mysqli_query($MYSQLICONNECT,$stmt);

    $jumlah_data = 4;
    
    $totaldata = mysqli_num_rows($daftar_album);
    $jumlah_paggination = ceil($totaldata / $jumlah_data);


    if(isset($_GET['halaman'])){
        $halaman_aktif=$_GET['halaman'];
    } else{
        $halaman_aktif=1;
    }

    $data_awal = ($halaman_aktif * $jumlah_data) - $jumlah_data;

    $stmt = "SELECT album_id,judul,genre,year(tanggal_terbit) as tahun,penyanyi, image_path FROM album ORDER BY judul LIMIT $data_awal,$jumlah_data";
    
    $page_album = mysqli_query($MYSQLICONNECT,$stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="albumlist.css">
    <link rel = "stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
    <?php include ("../navbar/navbargenerate.php");
    echo_card()?>
    <div class="main">
        <div class="container">
            <h2>Daftar Album</h2>
            
        <div class = "flex-container-album">
        <?php
        while($row = mysqli_fetch_assoc($page_album)){
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
