<?php

$log_file = 'log.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text_input'])) {
    
    $text = trim($_POST['text_input']);

    if (!empty($text)) {
        if (file_put_contents($log_file, $text . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
            echo "<h2>Текст успішно записано у файл " . $log_file . "!</h2>";
        } else {
            echo "Помилка: Не вдалося записати у файл.";
        }
    } else {
        echo "Будь ласка, введіть текст для запису.";
    }
}

echo "<hr>";

echo "<h2>Вміст файлу " . $log_file . ":</h2>";

if (file_exists($log_file)) {
    $content = file_get_contents($log_file);
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
} else {
    echo "Файл " . $log_file . " ще не існує.";
}

?>