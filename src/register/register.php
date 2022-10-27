<?php
$config = include('../config.php');
$conn = new mysqli($config['db_host'],$config['db_user'],$config['db_password'],$config['db_database']);

$input = $_GET['input'];
$field = $_GET['field'];

// Validasi input
global $conn;

if($field == "name"){
    if(strlen($input) > 0){
        echo "<style>input[name='name']{background-color: rgb(161, 238, 178);}</style>";
    }
}
if($field == "username"){
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$input'");
    if(mysqli_fetch_assoc($result)){
        echo "<span>The username already exists<span>";
    } else {
        if(!preg_match("/^[a-zA-Z0-9_]*$/", $input) || strlen($input) == 0){
            echo "<span>The username is not valid<span>";
        } else {
            // Change background color input form to green
            echo "<style>input[name='username']{background-color: rgb(161, 238, 178);}</style>";
        }
    }
}

if($field == "email"){
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if(!validateEmail($input)){
        echo "<span>The email is not valid<span>";
    } else {
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$input'");
        if(mysqli_fetch_assoc($result)){
            echo "<span>The email already exists<span>";
        } else {
            echo "<style>input[name='email']{background-color: rgb(161, 238, 178);}</style>";
        }
    }
}

if($field == "confirm_password"){
    if($input == "true"){
        echo "<style>input[name='password']{background-color: rgb(161, 238, 178);}</style>";
        echo "<style>input[name='confirm_password']{background-color: rgb(161, 238, 178);}</style>";
    } else{
        echo "<span>Password do not match<span>";
    }
}

?>