<?php
define('DB_SERVER', 'mysql');
define('DB_USERNAME', 'started-user'); 
define('DB_PASSWORD', 'started-password'); 
define('DB_NAME', 'started'); 

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
    die("Помилка підключення до бази даних: " . $link->connect_error);
}

$link->set_charset("utf8mb4");
?>