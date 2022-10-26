<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

$input = $_GET['input'];
$field = $_GET['field'];

// Validasi input
global $conn;

if($field == "username"){
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$input'");
    if(mysqli_fetch_assoc($result)){
        echo "Username sudah terdaftar!";
    } else {
        if(!preg_match("/^[a-zA-Z0-9_]*$/", $input) || strlen($input) == 0){
            echo "Username tidak valid!";
        } else {
            echo "<span>Valid</span>";
        }
    }
}

if($field == "email"){
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if(!validateEmail($input)){
        echo "Email tidak valid!";
    } else {
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$input'");
        if(mysqli_fetch_assoc($result)){
            echo "Email sudah terdaftar!";
        } else {
            echo "<span>Valid</span>";
        }
    }
}

?>