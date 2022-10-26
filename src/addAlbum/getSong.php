<select id="album" name="album">
    <?php
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $MYSQLICONNECT = new mysqli("localhost","root","","binotify");

        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = "SELECT song_id, judul FROM song WHERE penyanyi = '$penyanyi' AND album_id is NULL";
        $page_song = mysqli_query($MYSQLICONNECT,$stmt);
        while ($row = mysqli_fetch_assoc($page_song)){
    ?>
    <option value="<?php echo $row['song_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>