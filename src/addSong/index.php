<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href="addSong.css">
    <link rel = "stylesheet" href="../style.css">
    <title>Document</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
</head>

<body>
    <?php 
    include ("../navbar/navbargenerate.php");
    require_once("../login/authentication.php");
    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
        if(isAdmin()){
            generate_navbar(true, $user_id);
        }
        else{
            header("LOCATION: /home");
        }
    } 
    else{
        header("LOCATION: /home");  
    }
    ?>
    <div class="main">
        <div class="container">
            <h2>Add Song</h2>
            <form action="../api/insertSong.php" method="POST" enctype="multipart/form-data">
                <div class="image-upload">
                    <label for="fileImage">
                        <img src="../media/album/0/input.png" id="image-input">
                    </label>
                    <input type="file" name="fileImage" id="fileImage" accept="image/*" onchange="displayImage(event)">
                </div>
                
                <div class="row">
                    <div class="col-form">
                        <p>Judul Lagu</p>
                    </div>
                    <div class="col-input">
                        <input type="text" name="judul" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-form">
                        <p>Penyanyi</p>
                    </div>
                    <div class="col-input">
                        <input onChange="generateAlbum(this.value);" type="text" name="penyanyi" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-form">
                        <p>Genre</p>
                    </div>
                    <div class="col-input">
                        <input type="text" name="genre" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-form">
                        <p>Album</p>
                    </div>
                    <div class="col-input" id="daftaralbum">
                        <select id="album" name="album" class="album">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-form">
                        <p>Tanggal Terbit</p>
                    </div>
                    <div class="col-input">
                        <input type="date" name="tanggal_terbit" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-form">
                        <p>Input file Audio</p>
                    </div>
                    <div class="col-input">
                        <input type="file" accept="audio/*" name="fileAudio" id="fileAudio">
                    </div>
                </div>
                <input type="hidden" id="duration" name="duration">
                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
    
</body>
    <script src="addSong.js"/></script>
</html>