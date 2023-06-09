<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <title>Home</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
    <link href="../addAlbum/addAlbum.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <link href="../search/style.css" rel="stylesheet">

</head>
<body>
    <?php 
    include ("../navbar/navbargenerate.php");
    require_once("../login/authentication.php");
    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
        generate_navbar(isAdmin(), $user_id);
    } 
    else{
        generate_navbar();
    }
    ?>
    <div class="main">
        <div class="main-view">
            <div>
                <div class="search-song-title-result">
                    <div class="search-song-title">
                        <h2>Songs</h2>
                    </div>

                    <div class="search-song-result">
                        <?php
                            include('../components/songentry-template.php');
                            $config = include('../config.php');
                            $conn = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);
                            $songs = mysqli_query($conn, "SELECT *,YEAR(tanggal_terbit) AS tahun_terbit FROM song ORDER BY song_id DESC LIMIT 10");
                            if($songs->num_rows > 0){
                                try {
                                    foreach($songs as $song){
                                        generateSongentry($song);
                                    }
                                } catch(Exception $e){
                                    echo $e;
                                }
                            } else {
                                echo "<i>Daftar Lagu Tidak Ada</i>";
                            }
                        ?>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>