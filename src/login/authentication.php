<?php
$conn = mysqli_connect("localhost", "root", "", "binotify");

function isLogin(){
    global $conn;
    if(isset($_COOKIE['user_id']) && isset($_COOKIE['key'])){
        $user_id = $_COOKIE['user_id'];
        $key = $_COOKIE['key'];
    
        // Ambil username berdasarkan user_id
        $result = mysqli_query($conn, "SELECT username FROM user WHERE user_id = $user_id");
        $row = mysqli_fetch_assoc($result);
    
        // Cek cookie dan username (Klo salah (takut ada yg iseng masukin cookie manual) di redirect ke halaman login)
        if(!($key === hash('sha256', $row['username']))){
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function isAdmin(){
    global $conn;
    if(isset($_COOKIE['user_id']) && isset($_COOKIE['key'])){
        $user_id = $_COOKIE['user_id'];
        $key = $_COOKIE['key'];
    
        // Ambil username berdasarkan user_id
        $result = mysqli_query($conn, "SELECT username FROM user WHERE user_id = $user_id");
        $row = mysqli_fetch_assoc($result);
    
        // Cek cookie dan username (Klo salah (takut ada yg iseng masukin cookie manual) di redirect ke halaman login)
        if(!($key === hash('sha256', $row['username']))){
            return false;
        } else {
            $result = mysqli_query($conn, "SELECT isAdmin FROM user WHERE user_id = $user_id");
            $row = mysqli_fetch_assoc($result);
            if($row['isAdmin'] == "1"){
                return true;
            } else{
                return false;
            }
        }   
    } else {
        return false;
    }
}

?>