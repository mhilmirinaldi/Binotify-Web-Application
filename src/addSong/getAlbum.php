<link rel = "stylesheet" href="addSong.css">
<select id="album" name="album">
    <option value="">select album</option>
    <?php
        $config = include('../config.php');
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $db =  new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
           
        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = $db->prepare("SELECT album_id, judul FROM album WHERE penyanyi = ?");
        $stmt->execute(array($penyanyi));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    ?>
    <option style="color:black" value="<?php echo $row['album_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>