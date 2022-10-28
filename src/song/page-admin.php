<?php
    require_once('../login/authentication.php');

    include('./song-detail.php');
    include('../navbar/navbargenerate.php');
    
    $config = include('../config.php');

    $is_admin = isAdmin();
    $is_login = isLogin();
    if($is_login){
        $user_id = $_COOKIE['user_id'];
    } else{
        $user_id = null;
    }
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
        <link href="/song/style.css" rel="stylesheet">
        <link href="/style.css" rel="stylesheet">

        <title>Binotify</title>
        <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
    </head>
    <body>
        <div>
            <?php
                generate_navbar($is_admin, $user_id);
            ?>
        </div>

        <div class="main">
            <?php
                if(!$is_admin){
                    echo '<div class="error"><i>', "Only accessible to Admin", "</i></div>";
                    exit();
                }

                if(isset($_GET['id']) && $_GET['id'] != ''){
                    try{
                        $song = songDetail();
                    } catch(Exception $e){
                        echo '<div class="error"><i>', $e->getMessage(), "</i></div>";
                        exit();
                    }
                } else{
                    echo '<div class="error"><i>No Song (empty id)</i></div>';
                    exit();
                }
            ?>

            <form id="update_song" name="update_song" method="POST" action="/api/updateSong.php" enctype="multipart/form-data"
                onkeydown="return event.key != 'Enter';">
                <input type="hidden" name="song_id" value=<?php echo $song['song_id'] ?>>

                <div class="main-view">
                    <div class="song-top">
                        <div class="song-image change-image">
                            <div>
                                <label for="fileImage">
                                    <img src="<?php echo $song['image_path'] ?>" id="image-input">
                                </label>
                                <input type="file" name="fileImage" id="fileImage" accept="image/*" onchange="displayImage(event)">
                            </div>
                            
                            <span class="change-image-alt-tap-to-change"><i>(Tap image to change cover)</i></span>
                        </div>
                        <div class="song-title-detail">
                            <div value=<?php echo $song['song_id'] ?>>SONG</div>
                            <div class="id">Id: <?php echo $song['song_id'] ?></div>

                            <input type='text' class="judul judul-text"
                                name="judul"
                                value="<?php echo $song['judul'] ?>"
                                placeholder='title'>
                                
                            <div class="song-detail-container">
                                <span type='text' class="penyanyi song-detail"><?php echo $song['penyanyi'] ?> •&nbsp;</span>

                                <input type='date' class="tanggal-terbit song-detail"
                                    name="tanggal_terbit"
                                    value=<?php echo $song['tanggal_terbit'] ?>>

                                <span class="duration song-detail">&nbsp;•&nbsp;<?php echo gmdate("i:s", $song['duration']) ?> •&nbsp;</span>

                                <input type='text' class="genre song-detail"
                                    name="genre"
                                    placeholder="genre"
                                    value=<?php if(isset($song)) echo $song['genre'] ?>>
                            </div>
                        </div>
                    </div>

                    <div class="song-album-change-container">
                        <div>ALBUM</div>
                        <select name="album_id">
                            <?php
                                function getAllAlbum($song){
                                    $config = include('../config.php');

                                    $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
                                    
                                    $stmt = $db->prepare('SELECT album_id, judul
                                                        FROM album WHERE penyanyi=?');
                                    $stmt->execute(array($song['penyanyi']));
                                    $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    return $albums;
                                }

                                $albums = getAllAlbum($song);
                                echo "<option value=''>-- Select an album --</option>";
                                foreach($albums as $album){
                                    $selected = $album['album_id'] == $song['album_id'] ? 'selected' : '';
                                    echo "<option value={$album['album_id']} $selected>{$album['album_id']} - {$album['judul']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="song-audio-change-container">
                        <label for="fileAudio">Change Audio: </label>
                        <input type="file" accept="audio/*" name="fileAudio" id="fileAudio">
                        <input type="hidden" id="duration" name="duration">
                    </div>
                </div>
                
            </form>

            <form id="delete_song" name="delete_song" method="POST" action="/api/deleteSong.php">
                <input type="hidden" name="song_id" value=<?php echo $song['song_id'] ?>>
            </form>

            <div class="song-control-button-container">
                <button class="cancel" onclick="location.reload(); return false;">Cancel</button>
                <button class="save" onclick="document.update_song.submit()">Save</button>
                <button class="delete" onclick="document.delete_song.submit()">Delete Song</button>
            </div>

            <div class="audioplayer-container">
                <audio class="audioplayer" src="<?php if(isset($song)) echo $song['audio_path'] ?>" controls>
                    Audio not supported
                </audio>
            </div>
        </div>

        <script src="/addSong/addSong.js"></script>
    </body>
</html>
