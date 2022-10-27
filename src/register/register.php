<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

$input = $_GET['input'];
$field = $_GET['field'];

// Validasi input
global $conn;

if($field == "username"){
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$input'");
    if(mysqli_fetch_assoc($result)){
        echo "<span>Username sudah terdaftar!<span>";
    } else {
        if(!preg_match("/^[a-zA-Z0-9_]*$/", $input) || strlen($input) == 0){
            echo "<span>Username tidak valid!<span>";
        } else {
            echo "Valid";
        }
    }
}

if($field == "email"){
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if(!validateEmail($input)){
        echo "<span>Email tidak valid!<span>";
    } else {
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$input'");
        if(mysqli_fetch_assoc($result)){
            echo "<span>Email sudah terdaftar!<span>";
        } else {
            echo "Valid";
        }
    }
}


if($field == "confirm_password"){
    if($input == "true"){
        echo "Valid";
    } else{
        echo "<span>Password tidak sama<span>";
    }
}

?>