<link rel = "stylesheet" href="../navbar/navbar.css">
<?php
function echo_card($title = "Default Title", $desc = "Default Description", $img = "/static/logo-with-text.svg") {
   $html = <<<"EOT"
    <div class="navbar"> 
        <img class="logo" src="$img" >
        <a href="/home" onclick="route()">Home</a>
        <a href="/search"  onclick="route()"> Search</a>
        <a href="/album-list"  onclick="route()">Daftar Album</a>
        <a href="/song-list"  onclick="route()">Daftar Lagu</a>
        <a href="/addAlbum"  onclick="route()">Add Album</a>
        <a href="/addSong"  onclick="route()">Add Song</a>
    </div>
EOT;

   echo $html;
}
?>