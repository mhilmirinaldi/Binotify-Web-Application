<select id="song" name="song">
    <option value="">Select Song</option>
    <?php
        $config = include('../config.php');
        if(isset($_GET['penyanyi'])){
            $penyanyi = $_GET['penyanyi'];
        }else{
            $penyanyi = null;
        }
        $db =  new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);

        $penyanyi = $_REQUEST['penyanyi'];
        $stmt = db->prepare("SELECT song_id, judul FROM song WHERE penyanyi = ? AND (album_id is NULL OR album_id=0)");
        $stmt->execute(array($penyanyi));
        while ($stmt->fetch(PDO::FETCH_ASSOC)){
    ?>
    <option style="color:black" value="<?php echo $row['song_id']; ?>"><?php echo $row["judul"]; ?></option>
    <?php } ?>
</select>