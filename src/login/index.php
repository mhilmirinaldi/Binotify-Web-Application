<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek username
    if(mysqli_num_rows($result) === 1 && $username != "" && $password != ""){
        // Cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            // Set cookie
            setcookie('user_id', $row['user_id'], time()+3000, '/');
            setcookie('key', hash('sha256', $row['username']), time()+3000, '/');
            
            // Link ke halaman home
            header("Location: ../home/");
            
            exit;
        } 

        $error = true;
    }
}

?>

<!DOCTYPE html>
<html >
<head>
    <title>Login</title>
    <link rel="icon" href="../static/logo-only.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class='header'>
        <img src="../static/logo-with-text.svg" class=img>
    </div>
    <div class='center'>
        <?php if(isset($error)) : ?>
            <p class='error'>Incorrect username or password</p>
        <?php endif; ?>
    </div>
    <div class ='center'>
        <form action="" method="post">
            <div class = 'input_form'>

                <label for="username" class="form">Username</label>
                <input type="text" class="input" name="username" id="username" placeholder="Username" required>

                <label for="password" class="form">Password </label>
                <input type="password" class="input" name= "password" id="password" placeholder="Password" required>

            </div>
            <div class='form_bottom'>
                <button type="submit" name="login" class='login'>LOG IN</button>
            </div>
        </form>
    </div>
    <div class ='register'>
        <p>Don't have an account? </p>
        <a href="../register/" class ='register'>SIGN UP FOR BINOTIFY</a>
    </div>

</body>
</html>