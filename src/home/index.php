<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

include '../login/authentication.php';

if(!isLogin()){
    header("Location: ../login/");
    exit;
}

if(isAdmin()){
    echo "Welcome admin";
} else {
    echo "Welcome user";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
</head>
<body>
    <h1>Halaman Home</h1>

    <a href="../login/logout.php">Logout</a>
</body>
</html>