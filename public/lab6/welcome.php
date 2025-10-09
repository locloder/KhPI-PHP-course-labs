<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Ласкаво просимо</title>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 500px; padding: 20px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Привіт, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Ласкаво просимо на захищену сторінку!</h1>
        <p>Ваш ID користувача: **<?php echo htmlspecialchars($_SESSION["id"]); ?>**.</p>
        <p>Це підтверджує успішну авторизацію та використання сесії `$_SESSION`.</p>
        <p>
            <a href="logout.php">Вийти з облікового запису</a>
        </p>
    </div>
</body>
</html>