<?php
    return array(
        // use XAMPP
        // 'db_host' => 'localhost',
        // 'db_database' => 'binotify',
        // 'db_user' => 'root',
        // 'db_password' => '',
        // 'db_pdo_connect' => "mysql:host=localhost;dbname=binotify",

        // 'search_defaultpagesize' => 10

        // use Docker
        'db_host' => 'db',
        'db_database' => 'binotify',
        'db_user' => 'root',
        'db_password' => 'MYSQL_ROOT_PASSWORD',
        'db_pdo_connect' => "mysql:host=db;dbname=binotify",

        'search_defaultpagesize' => 10
    );
?>
