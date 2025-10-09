<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

require_once 'db_connect.php';

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Будь ласка, введіть ім'я користувача.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Будь ласка, введіть пароль.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {                    
                    $stmt->bind_result($id, $username, $hashed_password_from_db);
                    if ($stmt->fetch()) {
                        $is_password_correct = (md5($password) === $hashed_password_from_db);
                        
                        if ($is_password_correct) {
                            session_regenerate_id(true); 
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: welcome.php");
                            exit;
                        } else {
                            $login_err = "Невірне ім'я користувача або пароль.";
                        }
                    }
                } else {
                    $login_err = "Невірне ім'я користувача або пароль.";
                }
            } else {
                echo "Ой! Щось пішло не так. Спробуйте пізніше.";
            }

            $stmt->close();
        }
    }
    
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: 0 auto; }
        .error{ color: red; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Вхід</h2>
        <p>Будь ласка, заповніть свої дані для входу.</p>

        <?php if (!empty($login_err)): ?>
            <div class="error"><?php echo $login_err; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Ім'я користувача</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="error"><?php echo $username_err; ?></span>
            </div>
            <div>
                <label>Пароль</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Увійти">
            </div>
            <p>Не маєте облікового запису? <a href="register.php">Зареєструйтесь зараз</a>.</p>
        </form>
    </div>
</body>
</html>