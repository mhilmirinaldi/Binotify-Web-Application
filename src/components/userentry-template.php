<?php
$i = 1;

function generateUser($user){
    global $i;
    if($user['isAdmin'] == 1){
        $admin = "Admin";
    } else {
        $admin = "User";
    }
    
    if($i == 1){
        $html = <<<EOF
        <div class="user">
            <div class="number">No.</div>
            <div class="user-email">Email</div>
            <div class="user-username">Username</div>
            <div class="user-role">Role</div>
        </div>
        <link href="/components/userentry-template.css" rel="stylesheet">
        
        <div class="user">
                <div class="number">{$i}</div>  
                <div class="user-email">{$user['email']}</div>
                <div class="user-username">{$user['username']}</div>
                <div class="user-role">{$admin}</div>
        </div>
        EOF;
    } else {
        $html = <<<EOF
        <link href="/components/userentry-template.css" rel="stylesheet">
        
        <div class="user">
                <div class="number">{$i}</div>  
                <div class="user-email">{$user['email']}</div>
                <div class="user-username">{$user['username']}</div>
                <div class="user-role">{$admin}</div>
        </div>
        EOF;
    }
    

    $i++;

    echo $html;
}


?>