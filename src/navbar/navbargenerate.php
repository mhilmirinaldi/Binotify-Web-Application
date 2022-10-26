<link rel = "stylesheet" href="../navbar/navbar.css">
<?php
function echo_card($title = "Default Title", $desc = "Default Description", $img = "../navbar/logo.svg") {
   $html = <<<"EOT"
    <div class="navbar"> 
        <img src="$img" >
        <a href="/home" onclick="route()">Home</a>
        <a href="/search"  onclick="route()"> Search</a>
        <a href="/listAlbum"  onclick="route()">Daftar Album</a>
        <a href="/song"  onclick="route()">Daftar Lagu</a>
        <a href="/addAlbum"  onclick="route()">Add Album</a>
        <a href="/addSong"  onclick="route()">Add Song</a>
    </div>
EOT;

   echo $html;
}

?>