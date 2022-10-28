<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
    <link href="../addAlbum/addAlbum.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

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
                <div class="search-user-title-result">
                    <div class="user-title">
                        <h2>Users</h2>
                    </div>

                    <div class="user-result">
                        <?php
                            include('../components/userentry-template.php');
                            $config = include('../config.php');
                            $conn = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);
                            $users = mysqli_query($conn, "SELECT * FROM user");
                            if($users->num_rows > 0){
                                try {
                                    foreach($users as $user){
                                        generateUser($user);
                                    }
                                } catch(Exception $e){
                                    echo $e;
                                }
                            } else {
                                echo "<i>Daftar User Tidak Ada</i>";
                            }
                        ?>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>