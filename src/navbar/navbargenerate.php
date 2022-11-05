<link rel = "stylesheet" href="../navbar/navbar.css">
<?php
function  generate_navbar($isAdmin = false, $user_id= 0) {
    // user navbar  
    $username = "username";
    $isAdmin = NULL;
    if($user_id != 0){
        $config = include('../config.php');  
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        $stmt = $db->prepare("SELECT username,isAdmin FROM user WHERE user_id = ?");
        $stmt->execute(array($user_id));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $user["username"];
        $isAdmin = $user["isAdmin"];
    }
    $html = <<<"EOT"
    <div class="navbar"> 
        <img class="logo" src="/static/logo-with-text.svg" >
        <a href="/home" >Home</a>
        <a href="/search"  > Search</a>
        <a href="/album-list"  >List Album</a>

    EOT;

    // admin navbar
    if ($isAdmin){
        $html = $html . <<<"EOT"
        <a href="/addAlbum"  >Add Album</a>
        <a href="/addSong"  >Add Song</a>
        <a href="/users"  >List User</a>
        EOT;
    }

    if ($user_id !=0){
        $html = $html . <<<"EOT"
        <a href="/login/logout.php"  >Logout</a>
        EOT;
    }
    else{
        $html = $html . <<<"EOT"
        <a href="/login"  >Login</a>
        <a href="/register"  >SignUp</a>
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

