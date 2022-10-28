<select id="song" name="song">
    <option value="">Select Song</option>
    <?php
        $config = include('../config.php');
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $MYSQLICONNECT = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);
        
        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = "SELECT song_id, judul FROM song WHERE penyanyi = '$penyanyi' AND (album_id is NULL OR album_id=0)";
        $page_song = mysqli_query($MYSQLICONNECT,$stmt);
        while ($row = mysqli_fetch_assoc($page_song)){
    ?>
    <option style="color:black" value="<?php echo $row['song_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>