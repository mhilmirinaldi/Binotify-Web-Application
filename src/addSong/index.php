<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>

<body>
    <?php include ("../navbar/navbargenerate.php");
    echo_card()?>
    <h1>Add Album or Song</h1>
    <div class="container">
        <h2>Add Song</h2>
        <form action="../api/insertSong.php" method="POST" enctype="multipart/form-data">
            <div class="image-upload">
                <label for="fileImage">
                    <img src="../media/album/0/input.png" id="image-input">
                </label>
                <input type="file" name="fileImage" id="fileImage" accept="image/*" onchange="displayImage(event)" required>
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
                    <input type="text" name="penyanyi" required>
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
                <div class="col-input">
                    <input type="text" name="album" required>
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
    
</body>
    <script src="index.js"/></script>
</html>