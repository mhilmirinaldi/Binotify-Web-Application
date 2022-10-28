<?php
    include ("../navbar/navbargenerate.php");
    require_once("../login/authentication.php");

    $tomorrow = strtotime('tomorrow');
    
    $is_login = false;
    if(isLogin()){
        $user_id = $_COOKIE['user_id'];
        $is_login = true;
    } else{
        $user_id = 0;
        if(isset($_COOKIE['song-play-count'])){
            $song_play_count = $_COOKIE['song-play-count'] + 1;
            if($song_play_count <= 3){
                setcookie('song-play-count', $song_play_count, $tomorrow, "/");
            }
        } else{
            $song_play_count = 1;
            setcookie('song-play-count', 1, $tomorrow, "/");
        }
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
        <link href="./style.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">

        <title>Binotify</title>
        <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
    </head>
    <body>
        <div>
            <?php
                generate_navbar(false, $user_id);
            ?>
        </div>
        <div class="main">
            <?php
                if(!$is_login && $song_play_count > 3){
                    echo <<<EOT
                    <div class="error">
                        <i>You have reached daily maximum number of play (max 3)<br>
                            <a href="/register">Register</a> or <a href="/login">Login</a> right now to enjoy unlimited songs
                        </i>
                    </div>
                    EOT;
                    exit();
                }
            ?>
            <?php
                include('./song-detail.php');
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
            <div class="main-view">
                <div class="song-top">
                    <div class="song-image">
                        <img src="<?php if(isset($song)) echo $song['image_path'] ?>">
                    </div>
                    <div class="song-title-detail">
                        <div>SONG</div>
                        <h1 class="judul judul-text"><?php if(isset($song)) echo $song['judul'] ?></h1>
                        <div class="song-detail-container">
                            <span class="penyanyi song-detail"><?php if(isset($song)) echo $song['penyanyi'] ?> •&nbsp</span>
                            <span class="tanggal-terbit song-detail"><?php if(isset($song)) echo $song['tanggal_terbit'] ?> •&nbsp</span>
                            <span class="duration song-detail"><?php if(isset($song)) echo gmdate("i:s", $song['duration']) ?> •&nbsp;</span>
                            <span class="genre song-detail"><?php if(isset($song)) echo $song['genre'] ?></span>
                        </div>
                    </div>
                </div>
                <div>
                    <?php
                        if(isset($song) && $song['album_id'] !== null){
                            include('./albumentry-template.php');
                            echo "<div>ALBUM</div>";
                            generateAlbumentry($song);
                        } else if(isset($song)){
                            echo "<div><i>SINGLE</i></div>";
                        }
                    ?>
                </div>
            </div>

            <div class="audioplayer-container">
                <audio class="audioplayer" src="<?php if(isset($song)) echo $song['audio_path'] ?>" controls>
                    Audio not supported
                </audio>
            </div>
        </div>
    </body>
</html>
