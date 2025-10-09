<?php
session_start(); 

require_once 'db_connect.php';

$username = $email = $password = "";
$username_err = $email_err = $password_err = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Будь ласка, введіть ім'я користувача.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $username_err = "Це ім'я користувача вже зайняте.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Ой! Щось пішло не так. Спробуйте пізніше.";
            }
            $stmt->close();
        }
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Будь ласка, введіть електронну пошту.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = "Користувач з цією поштою вже існує.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
            $stmt->close();
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Будь ласка, введіть пароль.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Пароль повинен містити не менше 6 символів.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);
            
            $param_username = $username;
            $param_email = $email;
            
            $param_password = md5($password);
            
            if ($stmt->execute()) {
                $success_msg = "Реєстрація успішна! Тепер ви можете <a href='login.php'>увійти</a>.";
                $username = $email = $password = "";
            } else {
                echo "Щось пішло не так під час вставки. Спробуйте пізніше.";
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
    <title>Реєстрація</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: 0 auto; }
        .error{ color: red; }
        .success{ color: green; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Реєстрація</h2>
        <p>Заповніть форму для створення облікового запису.</p>
        
        <?php if (!empty($success_msg)): ?>
            <p class="success"><?php echo $success_msg; ?></p>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Ім'я користувача</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="error"><?php echo $username_err; ?></span>
            </div>
            <div>
                <label>Електронна пошта</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div>
                <label>Пароль</label>
                <input type="password" name="password">
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Зареєструватися">
            </div>
            <p>Вже маєте обліковий запис? <a href="login.php">Увійдіть тут</a>.</p>
        </form>
    </div>    
</body>
</html>