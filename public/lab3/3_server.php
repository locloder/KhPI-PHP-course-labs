<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: 3_server.php'); 
    exit;
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Робота з SERVER</title>
</head>
<body>
    <h2>Робота з $_SERVER</h2>

    <h3>Інформація про клієнта та сервер:</h3>
    <ul>
        <li>IP-адреса клієнта: **<?php echo $_SERVER['REMOTE_ADDR']; ?>**</li>
        <li>Назва та версія браузера: **<?php echo $_SERVER['HTTP_USER_AGENT']; ?>**</li>
        <li>Назва скрипта: **<?php echo $_SERVER['PHP_SELF']; ?>**</li>
        <li>Метод запиту: **<?php echo $_SERVER['REQUEST_METHOD']; ?>**</li>
        <li>Шлях до файлу: **<?php echo $_SERVER['SCRIPT_FILENAME']; ?>**</li>
    </ul>

</body>
</html>