<?php
session_start();

$session_timeout = 5 * 60; 

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    echo "<p>Ваша сесія завершилась через неактивність.</p>";
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = date('H:i:s');
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Таймаут сесії</title>
</head>
<body>
    <h2>Автоматичне завершення сесії</h2>
    <p>Ця сторінка завершить сесію, якщо ви не будете її оновлювати протягом 5 хвилин.</p>
    <p>Сесію розпочато о: **<?php echo $_SESSION['start_time']; ?>**</p>
    <p>Оновіть сторінку, щоб скинути таймер.</p>
    
    <hr>
    
    <p>Поточний час на сервері: **<?php echo date('H:i:s'); ?>**</p>

</body>
</html>