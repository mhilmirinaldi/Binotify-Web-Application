<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek username
    if(mysqli_num_rows($result) === 1){
        // Cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            // Set cookie
            setcookie('user_id', $row['user_id'], time()+3000, '/');
            setcookie('key', hash('sha256', $row['username']), time()+3000, '/');
            
            // Link ke halaman home
            header("Location: ../home/home.php");
            
            exit;
        } else {
            echo "<script>
                    alert('Username atau password salah!');
                </script>";
        }
    } else {
        echo "<script>
                alert('Username atau password salah!');
            </script>";
    }
}

?>

<!DOCTYPE html>
<html >
<head>
    <title>Login</title>
</head>
<body>

<h1>Halaman Login</h1>

<form action="" method="post">
    <ul>
        <li>
            <label for="username">Username :</label>
            <input type="text" name="username" id="username">
        </li>
        <li>
            <label for="password">Password :</label>
            <input type="password" name= "password" id="password">
        </li>
        <li>
            <button type="submit" name="login">Login</button>
        </li> 
    </ul>
</form>
    
</body>
</html>