<?php 
$config = include('../config.php');
$conn = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);

function register($data){
    global $conn;

    $name = $data["name"];
    $username = $data["username"];
    $email = $data["email"];
    $password = $data["password"];
    $confirm_password = $data["confirm_password"];

    # Cek username
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(!preg_match("/^[a-zA-Z0-9_]*$/", $username) || strlen($username) == 0){
        return false;
    }
    if(mysqli_fetch_assoc($result)){
        return false;
    }

    # Cek email
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)){
        return false;
    }

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    if(!validateEmail($email)){
        return false;
    }

    #Cek confirmasi password
    if($password !== $confirm_password){
        return false;
    }

    # Semua field harus diisi
    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
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
        # Login dan link ke halaman home
        $username = $_POST["username"];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
        $row = mysqli_fetch_assoc($result);

        setcookie('user_id', $row['user_id'], time()+3000, '/');
        setcookie('key', hash('sha256', $row['username']), time()+3000, '/');
            
        // Link ke halaman home
        header("Location: ../home/");
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../static/logo-only.svg" type="image/svg+xml">
    <script src='register.js'></script>
</head>
<body>

<div class='header'>
        <img src="../static/logo-with-text.svg" class=img>
</div>
<div class='center'>
    <?php if(isset($error)) : ?>
        <p class='error'>The form is not valid</p>
    <?php endif; ?>
</div>
<div class ='center'>
    <form action="" method="post" name="form" id ="form">
        <div class = 'input_form'>
            <label for="name" id="nama" class="form">Name </label>
            <input type="text" name="name" id="name1" placeholder="Name" class="input" onblur="validate('name', this.value)">
            <td><div id='name'></div></td>

            <label for="username" class="form">Username </label>
            <input type="text" name="username" id="username1" placeholder="Username" class="input" required onblur="validate('username', this.value)">
            <td><div id='username'></div></td>

            <label for="email" class="form">Email </label>
            <input type="text" name="email" id="email1" placeholder="Email" class="input" required onblur="validate('email', this.value)">
            <td><div id='email'></div></td>

            <label for="password" class="form">Password </label>
            <input type="password" name= "password" id="password1" placeholder="Password" class="input" required onblur="validate_password1('password', this.value)">
            <td><div id='password'></div></td>

            <label for="confirm_password" class="form">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password1" placeholder="Confirm Password" class="input" required onblur="validate_password2('confirm_password', this.value)">
            <td><div id='confirm_password'></div></td>
        </div>
        <div class ='form_bottom'>
            <button type="submit" name="register" class ="register">Sign up</button>
        </div>
        <div class ='login'>
            <p>Have an account? <a href="../login/" class ='login'>Log in.</a> </p> 
        </div>
    </form>
</div>





</body>
</html>