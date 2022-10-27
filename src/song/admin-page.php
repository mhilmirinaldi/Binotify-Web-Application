<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
        <link href="./style.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">

        <title>Binotify</title>
        <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
    </head>
    <body>
        <div>
            <?php
                include("../navbar/navbargenerate.php");
                echo_card();
            ?>
        </div>

        <form class="main" method="POST"
            action="/api/updateSong.php"
            onkeydown="return event.key != 'Enter';">
            <div class="main-view">
                <?php
                    include('./song-detail.php');
                    if(isset($_GET['id']) && $_GET['id'] != ''){
                        try{
                            $song = songDetail();
                        } catch(Exception $e){
                            echo "<i>", $e->getMessage(), "</i>";
                        }
                    } else{
                        echo "<i>No Song (empty id)</i>";
                    }
                ?>
                <div class="song-top">
                    <div class="song-image">
                        <img src="<?php if(isset($song)) echo $song['image_path'] ?>">
                    </div>
                    <div class="song-title-detail">
                        <div name="id" value=<?php echo $song['song_id'] ?>>SONG: id=<?php echo $song['song_id'] ?></div>
                        <input type="hidden" name="song_id" value=<?php echo $song['song_id'] ?>>
                        <input type='text' class="judul judul-text"
                            name="judul"
                            value="<?php if(isset($song)) echo $song['judul'] ?>"
                            placeholder='title'>
                        <div class="song-detail-container">
                            <span type='text' class="penyanyi song-detail"><?php if(isset($song)) echo $song['penyanyi'] ?> •&nbsp;</span>
                            <input type='date' class="tanggal-terbit song-detail"
                                name="tanggal_terbit"
                                value=<?php if(isset($song)) echo $song['tanggal_terbit'] ?>>
                            <span class="duration song-detail"><?php if(isset($song)) echo gmdate("i:s", $song['duration']) ?> •&nbsp;</span>
                            <input type='text' class="genre song-detail"
                                name="genre"
                                placeholder="genre"
                                value=<?php if(isset($song)) echo $song['genre'] ?>>
                        </div>
                    </div>
                </div>
                <div>
                    <div>ALBUM</div>
                    <select>
                        <?php
                            function getAllAlbum(){
                                $config = include('../config.php');

                                $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
                                
                                $stmt = $db->prepare('SELECT album_id, judul
                                                    FROM album');
                                $stmt->execute(array());
                                $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                return $albums;
                            }

                            $albums = getAllAlbum();
                            foreach($albums as $album){
                                $selected = $album['album_id'] == $song['album_id'] ? 'selected' : '';
                                echo "<option value={$album['album_id']} $selected>{$album['album_id']} - {$album['judul']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="audioplayer-container">
                <audio class="audioplayer" src="<?php if(isset($song)) echo $song['audio_path'] ?>" controls>
                    Audio not supported
                </audio>
            </div>
            <button onclick="location.reload(); return false;">Cancel</button>
            <button type="submit">Save</button>
        </form>
    </body>
</html>
