<?php
    include ("../navbar/navbargenerate.php");
    require_once("../login/authentication.php");
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
    <link href="/success/style.css" rel="stylesheet">

    <title>Success</title>
</head>
<body>
<?php 
        if (isset($_COOKIE['user_id'])){
            $user_id = $_COOKIE['user_id'];
            generate_navbar(isAdmin(), $user_id);
        } 
        else{
            generate_navbar();
        }?>
    <div class="main">
        <div class="main-view">
            <div class="success-page">
                <img src="/notification/success.svg">
                <span>Success</span>
            </div>
        </div>
    </div>
</body>
</html>