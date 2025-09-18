<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && isset($_POST['password'])) {
    $login = 'user'; 
    $password = 'pass'; 

    if ($_POST['login'] === $login && $_POST['password'] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $login;
        header('Location: 2_session.php');
        exit;
    } else {
        $error = "Невірний логін або пароль.";
    }
}

// Логіка виходу
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset(); 
    session_destroy();
    header('Location: 2_session.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Робота з SESSION</title>
</head>
<body>
    <h2>Робота з $_SESSION</h2>

    <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo "<h3>Вітаю, " . htmlspecialchars($_SESSION['username']) . "! Ви увійшли.</h3>";
        echo '<a href="?action=logout">Вихід</a>';
    } else {
        if (isset($error)) {
            echo '<p style="color:red;">' . $error . '</p>';
        }
        ?>
        <form action="" method="post">
            <label for="login">Логін:</label><br>
            <input type="text" id="login" name="login" required><br><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Увійти">
        </form>
        <?php
    }
    ?>
</body>
</html>