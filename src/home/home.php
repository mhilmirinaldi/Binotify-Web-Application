<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

// Autentikasi udah login atau belum buat halaman yang perlu login, klo belum di redirect ke halaman login
// Home ga perlu autentikasi login (buat contoh)
if(isset($_COOKIE['user_id']) && isset($_COOKIE['key'])){
    $user_id = $_COOKIE['user_id'];
    $key = $_COOKIE['key'];

    // Ambil username berdasarkan user_id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);

    // Cek cookie dan username (Klo salah (takut ada yg iseng masukin cookie manual) di redirect ke halaman login)
    if(!($key === hash('sha256', $row['username']))){
        header("Location: ../login/login.php");
        exit;
    }
} else {
    header("Location: ../login/login.php");
    exit;
}

function username($user_id){
    global $conn;
    $result = mysqli_query($conn, "SELECT username FROM user WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
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

    <p>Selamat datang <?php echo username($_COOKIE['user_id'])?></p>

    <a href="../login/logout.php">Logout</a>
</body>
</html>