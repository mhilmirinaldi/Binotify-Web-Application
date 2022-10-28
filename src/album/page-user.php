<?php
    require_once("../login/authentication.php");
    
    include('./album-detail.php');
    include ("../navbar/navbargenerate.php");

    $is_admin = isAdmin();
    $is_login = isLogin();
    if($is_login){
        $user_id = $_COOKIE['user_id'];
    } else{
        $user_id = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">
    <link href="/album/style.css" rel="stylesheet">

    <title>Album</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
</head>
<body>
    <div>
        <?php
            if (isset($_COOKIE['user_id'])){
                $user_id = $_COOKIE['user_id'];
                generate_navbar(isAdmin(), $user_id);
            } 
            else{
                generate_navbar();
            }
        ?>
    </div>

    <div class="main">
        <?php
            if(isset($_GET['id']) && $_GET['id'] != ''){
                try{
                    $album = albumDetail();
                } catch(Exception $e){
                    echo '<div class="error"><i>', $e->getMessage(), "</i></div>";
                    exit();
                }
            } else{
                echo '<div class="error"><i>No Album (empty id)</i></div>';
                exit();
            }
        ?>

        <div class="main-view">
            <div class="album-top">
                <div class="album-image">
                    <img src="<?php if(isset($album)) echo $album['image_path'] ?>">
                </div>
                <div class="album-title-detail">
                    <div>ALBUM</div>
                    <h1 class="judul judul-text"><?php if(isset($album)) echo $album['judul'] ?></h1>
                    <div class="album-detail-container">
                        <span class="penyanyi album-detail"><?php if(isset($album)) echo $album['penyanyi'] ?> •&nbsp;</span>
                        <span class="tanggal-terbit album-detail"><?php if(isset($album)) echo $album['tanggal_terbit'] ?> •&nbsp;</span>
                        <span class="duration album-detail"><?php if(isset($album)) echo gmdate("H:i:s", $album['total_duration']) ?> •&nbsp;</span>
                        <span class="genre album-detail"><?php if(isset($album)) echo $album['genre'] ?></span>
                    </div>
                </div>
            </div>
            <div class="search-song-title-result">
                <div class="search-song-title">
                    <h2>Songs</h2>
                </div>

                <div class="search-song-result">
                    <?php
                        include('../components/songentry-template.php');
                        if(isset($album)){
                            $songs = $album['songs'];
                            foreach($songs as $song){
                                generateSongentry($song);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
