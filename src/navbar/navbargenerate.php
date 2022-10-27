<link rel = "stylesheet" href="../navbar/navbar.css">
<?php
function  echo_navbar($isAdmin = false, $user_id= 0) {
    // user navbar  
    $config = include('../config.php');  
    $MYSQLICONNECT = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);
    $stmt = "SELECT username FROM user WHERE user_id = '$user_id'";
    $page_user= mysqli_query($MYSQLICONNECT,$stmt);
    $user = mysqli_fetch_array($page_user);
    $username = $user["username"];
    $html = <<<"EOT"
    <div class="navbar"> 
        <img class="logo" src="/static/logo-with-text.svg" >
        <a href="/home" onclick="route()">Home</a>
        <a href="/search"  onclick="route()"> Search</a>
        <a href="/album-list"  onclick="route()">List Album</a>

    EOT;

    // admin navbar
    if ($isAdmin){
        $html = $html . <<<"EOT"
        <a href="/addAlbum"  onclick="route()">Add Album</a>
        <a href="/addSong"  onclick="route()">Add Song</a>
        EOT;
    }

    $html = $html . <<<"EOT"
     </div>
    <div class="user"> 
        <img class="logo" src="/static/user.png" > 
        <div class="nameuser">$username</div> 
    </div> 
    EOT;

   echo $html;
}
?>