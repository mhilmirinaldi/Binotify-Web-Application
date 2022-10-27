<link rel = "stylesheet" href="../navbar/navbar.css">
<?php
function echo_card($title = "Default Title", $desc = "Default Description", $img = "/static/logo-with-text.svg", $isAdmin = true, $username ="User") {
    // user navbar    
    $html = <<<"EOT"
    <div class="navbar"> 
        <img class="logo" src="$img" >
        <a href="/home" onclick="route()">Home</a>
        <a href="/search"  onclick="route()"> Search</a>
        <a href="/album-list"  onclick="route()">List Album</a>
        <a href="/addAlbum"  onclick="route()">Add Album</a>
        <a href="/addSong"  onclick="route()">Add Song</a>
    </div>
    EOT;

    // admin navbar
    if ($isAdmin){
        $html = $html . <<<"EOT"
        EOT;
    }

    $html = $html . <<<"EOT"
    <div class="user"> 
        <img class="logo" src="/static/user.png" > 
        <div class="nameuser">$username</div> 
    </div> 
    EOT;

   echo $html;
}
?>