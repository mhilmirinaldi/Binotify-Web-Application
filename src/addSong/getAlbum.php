<select id="album" name="album">
    <?php
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $MYSQLICONNECT = new mysqli("localhost","root","","binotify");

        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = "SELECT album_id, judul FROM album WHERE penyanyi = '$penyanyi'";
        $page_album = mysqli_query($MYSQLICONNECT,$stmt);
        while ($row = mysqli_fetch_assoc($page_album)){
    ?>
    <option value="<?php echo $row['album_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>