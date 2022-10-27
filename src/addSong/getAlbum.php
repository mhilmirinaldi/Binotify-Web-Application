<link rel = "stylesheet" href="addSong.css">
<select id="album" name="album">
    <option >select album</option>
    <?php
        $config = include('../config.php');
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $MYSQLICONNECT = new  mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);

        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = "SELECT album_id, judul FROM album WHERE penyanyi = '$penyanyi'";
        $page_album = mysqli_query($MYSQLICONNECT,$stmt);
        while ($row = mysqli_fetch_assoc($page_album)){
    ?>
    <option style="color:black" value="<?php echo $row['album_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>