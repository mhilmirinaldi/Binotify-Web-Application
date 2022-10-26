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
    </head>
    <body>
        <div>
            <?php
                include("../navbar/navbargenerate.php");
                echo_card();
            ?>
        </div>
        <div class="main">
            <div class="main-view">
                <?php
                    include('./song-detail.php');
                    try{
                        $song = songDetail();
                    } catch(Exception $e){
                        echo $e;
                    }
                ?>
                <div class="song-top">
                    <div class="song-image">
                        <img src="<?php if(isset($song)) echo $song['image_path'] ?>">
                    </div>
                    <div class="song-title-detail">
                        <div>SONG</div>
                        <h1 class="judul judul-text"><?php if(isset($song)) echo $song['judul'] ?></h1>
                        <div class="song-detail-container">
                            <span class="penyanyi song-detail"><?php if(isset($song)) echo $song['penyanyi'] ?></span>
                            <span class="tanggal-terbit song-detail"><?php if(isset($song)) echo $song['tanggal_terbit'] ?></span>
                            <span class="duration song-detail"><?php if(isset($song)) echo gmdate("i:s", $song['duration']) ?></span>
                            <span class="genre song-detail"><?php if(isset($song)) echo $song['genre'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="audioplayer-container">
                <audio class="audioplayer" src="<?php if(isset($song)) echo $song['audio_path'] ?>" controls>
                    Audio not supported
                </audio>
            </div>
        </div>
        
        <script type="text/javascript" src="../utility.js"></script>
    </body>
</html>
