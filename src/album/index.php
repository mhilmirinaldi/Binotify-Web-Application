<?php
    $MYSQLICONNECT = new mysqli("localhost","root","","binotify");

    $stmt = "SELECT * FROM album";
    $daftar_album = mysqli_query($MYSQLICONNECT,$stmt);

    $jumlah_data = 3;
    
    $totaldata = mysqli_num_rows($daftar_album);
    $jumlah_paggination = ceil($totaldata / $jumlah_data);


    if(isset($_GET['halaman'])){
        $halaman_aktif=$_GET['halaman'];
    } else{
        $halaman_aktif=1;
    }

    $data_awal = ($halaman_aktif * $jumlah_data) - $jumlah_data;

    $stmt = "SELECT * FROM album ORDER BY judul LIMIT $data_awal,$jumlah_data";
    
    $page_album = mysqli_query($MYSQLICONNECT,$stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="index.css">
    <title>Document</title>
</head>
    <h1>Daftar Album</h1>
    <div class = "flex-container-album">
    <?php
    while($row = mysqli_fetch_assoc($page_album)){
    ?>
        <div class = "flex-album">
            <image src="<?php echo "../" . $row['image_path'];?>">
            <p class ="judul"> <?php echo $row['judul']; ?></p>
            <span>
                <p> <?php echo $row['tanggal_terbit']; ?></p>
                <p>&nbsp;•&nbsp;</p>
                <p><?php echo $row['penyanyi']; ?></p>
            </span>
            
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
    
<body>

</body>
</html>
