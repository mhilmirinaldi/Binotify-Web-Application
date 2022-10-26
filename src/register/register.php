<?php 
$conn = mysqli_connect("localhost", "root", "", "binotify");

function register($data){
    global $conn;

    $name = $data["name"];
    $username = $data["username"];
    $email = $data["email"];
    $password = $data["password"];
    $confirm_password = $data["confirm_password"];

    # Cek username sudah ada atau belum
    # TASK : Validasi pengecekan pake AJAX
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Username sudah terdaftar!');
            </script>";
        return false;
    }

    # Validasi username hanya boleh huruf, angka, dan underscore
    if(!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
        echo "<script>
                alert('Username hanya boleh huruf, angka, dan underscore!');
            </script>";
        return false;
    }

    # Cek email sudah ada atau belum
    # TASK : Validasi pengecekan pake AJAX
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Email sudah terdaftar!');
            </script>";
        return false;
    }

    # Validasi email
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if(!validateEmail($email)){
        echo "<script>
                alert('Email tidak valid!');
            </script>";
        return false;
    }

    # Cek confirmasi password
    if($password !== $confirm_password){
        echo "<script>
                alert('Password tidak sesuai!');
            </script>";
        return false;
    }

    # Semua field harus diisi
    if(empty($name)||empty($username) || empty($email) || empty($password) || empty($confirm_password)){
        echo "<script>
                alert('Semua field harus diisi!');
            </script>";
        return false;
    }

    # Hashing password
    $password = password_hash($password, PASSWORD_DEFAULT);

    # Menambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$email', '$password', '$username', '0')");

    return mysqli_affected_rows($conn);
}

if (isset($_POST["register"])){
    if(register($_POST) > 0){
        # Link ke halaman login
        header("Location: ../login/login.php");
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
</head>
<body>

<h1>Halaman Register</h1>

<form action="" method="post">
    <ul>
        <li>
            <label for="name">Nama :</label>
            <input type="text" name="name" id="name">

        </li>
        <li>
            <label for="username">Username :</label>
            <input type="text" name="username" id="username">
        </li>
        <li>
            <label for="email">Email :</label>
            <input type="text" name="email" id="email">
        </li>
        <li>
            <label for="password">Password :</label>
            <input type="password" name= "password" id="password">
        </li>
        <li>
            <label for="confirm_password">Confirm Password :</label>
            <input type="password" name="confirm_password" id="confirm_password">
        </li>
        <li>
            <button type="submit" name="register">Register</button>
        </li>
    </ul>
</form>

</body>
</html>