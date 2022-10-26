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

<div class ='center'>
    <form action="" method="post" name="form" id ="form">
        <div class = 'input_form'>
            <label for="name" class="form">Name </label>
            <input type="text" name="name" id="name" placeholder="Name" class="input">

            <label for="username" class="form">Username </label>
            <input type="text" name="username" id="username1" placeholder="Username" class="input" required onblur="validate('username', this.value)">
            <td><div id='username'></div></td>

            <label for="email" class="form">Email </label>
            <input type="text" name="email" id="email1" placeholder="Email" class="input" required onblur="validate('email', this.value)">
            <td><div id='email'></div></td>

            <label for="password" class="form">Password </label>
            <input type="password" name= "password" id="password1" placeholder="Password" class="input" required onblur="validate('password', this.value)">
            <td><div id='password'></div></td>

            <label for="confirm_password" class="form">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password1" placeholder="Confirm Password" class="input" required onblur="validate('confirm_password', this.value)">
            <td><div id='confirm_password'></div></td>
        </div>
        <div class ='form_bottom'>
            <button onclick="check_form()" type="submit" name="register" class ="register">Register</button>
        </div>
    </form>
</div>

</body>
</html>