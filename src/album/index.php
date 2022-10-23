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
    <title>Document</title>
</head>
    <?php
    for ($i=1;$i<=$jumlah_paggination;$i++): ?>\
        <a href="?halaman=<?php echo $i;?>">
            <?php echo $i; ?>
        </a>
    <?php endfor;?>
    <h1>Daftar Album</h1>
    <?php
    while($row = mysqli_fetch_assoc($page_album)){
    ?>
    <tr>
        <td><?php echo $row['album_id']; ?></td>
        <td><?php echo $row['judul']; ?></td>
    
    </tr>
    <br />
    <?php
    }
    ?>
<body>

</body>
</html>
