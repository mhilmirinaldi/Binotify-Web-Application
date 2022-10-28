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
            if(!$is_admin){
                echo '<div class="error"><i>', "Only accessible to Admin", "</i></div>";
                exit();
            }

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

        <form id="update_album" name="update_album" method="POST" action="/api/updateAlbum.php" enctype="multipart/form-data"
            onkeydown="return event.key != 'Enter'">
            <input type="hidden" id="album_id" name="album_id" value=<?php echo $album['album_id'] ?>>

            <div class="main-view">
                <div class="album-top">

                    <div class="album-image change-image">
                        <label for="fileImage">
                            <img src="<?php echo $album['image_path'] ?>" id="image-input">
                        </label>
                        <input type="file" name="fileImage" id="fileImage" accept="image/*" onchange="displayImage(event)">

                        <i>(Tap image to change cover)</i>
                    </div>

                    <div class="album-title-detail">
                        <div>ALBUM</div>
                        <div>Id: <?php echo $album['album_id'] ?></div>

                        <input type='text' class="judul judul-text"
                            name="judul"
                            value="<?php if(isset($album)) echo $album['judul'] ?>"
                            placeholder="title">

                        <div class="album-detail-container">
                            <span class="penyanyi album-detail"><?php if(isset($album)) echo $album['penyanyi'] ?> •&nbsp;</span>

                            <input type="date" class="tanggal-terbit album-detail"
                                name="tanggal_terbit"
                                value="<?php if(isset($album)) echo $album['tanggal_terbit'] ?>">

                            <span class="duration album-detail">&nbsp;• <?php if(isset($album)) echo gmdate("H:i:s", $album['total_duration']) ?> •&nbsp;</span>

                            <input type='text' class="genre album-detail"
                                name="genre"
                                placeholder="genre"
                                value="<?php if(isset($album)) echo $album['genre'] ?>">
                        </div>
                    </div>
                </div>

                <div class="search-song-title-result">
                    <div class="search-song-title">
                        <h2>Songs</h2>
                        <div><i>(Pressing edit song list will discard changes, please press "Save" first)</i><div>
                        <button type="button"
                            onclick="window.location=`/album/edit-song.php?id=<?php echo $album['album_id'] ?>`"
                        >Edit Song List</button>
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
        </form>

        <form id="delete_album" name="delete_album" method="POST" action="/api/deleteAlbum.php">
            <input type="hidden" name="album_id" value=<?php echo $album['album_id'] ?>>
        </form>

        <div class="album-control-button-container">
            <button class="cancel" onclick="location.reload(); return false;">Cancel</button>
            <button class="save" onclick="document.update_album.submit()">Save</button>
            <button class="delete" onclick="document.delete_album.submit()">Delete Album</button>
        </div>
    </div>

    <script src="/addAlbum/addAlbum.js"></script>
</body>
</html>
