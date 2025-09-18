<?php
$cookie_lifetime = time() + (7 * 24 * 60 * 60);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_name'])) {
    $user_name = $_POST['user_name'];
    setcookie('user_name', $user_name, $cookie_lifetime);
    header('Location: 1_cookie.php'); // Перезавантажуємо сторінку, щоб відобразити привітання
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete_cookie') {
    setcookie('user_name', '', time() - 3600); // Встановлюємо час життя в минулому
    header('Location: 1_cookie.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Робота з COOKIE</title>
</head>
<body>
    <h2>Робота з $_COOKIE</h2>

    <?php
    if (isset($_COOKIE['user_name'])) {
        echo "<h3>Вітаю, " . htmlspecialchars($_COOKIE['user_name']) . "! 👋</h3>";
        echo '<a href="?action=delete_cookie">Видалити cookie</a>';
    } else {
        ?>
        <form action="" method="post">
            <label for="user_name">Введіть ваше ім'я:</label><br>
            <input type="text" id="user_name" name="user_name" required><br><br>
            <input type="submit" value="Зберегти ім'я">
        </form>
        <?php
    }
    ?>
</body>
</html>