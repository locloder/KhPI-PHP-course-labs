<?php

$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_to_upload'])) {

    $file = $_FILES['file_to_upload'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Помилка завантаження файлу. Код помилки: " . $file['error'];
        exit;
    }

    if (is_uploaded_file($file['tmp_name'])) {
        
        $file_name = basename($file['name']);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $file['size'];
        $max_size = 2 * 1024 * 1024; // 2 МБ
        $allowed_types = ['jpg', 'jpeg', 'png'];

        if (!in_array($file_type, $allowed_types)) {
            echo "Помилка: Дозволено завантажувати лише файли .jpg, .jpeg, .png.";
            exit;
        }

        if ($file_size > $max_size) {
            echo "Помилка: Розмір файлу не повинен перевищувати 2 МБ.";
            exit;
        }

        $target_path = $upload_dir . $file_name;

        if (file_exists($target_path)) {
            $unique_suffix = date('YmdHis') . '_' . uniqid();
            $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $unique_suffix . '.' . $file_type;
            $target_path = $upload_dir . $new_file_name;
            echo "Файл з таким ім'ям вже існує. Файл збережено як: **" . $new_file_name . "**<br>";
        } else {
            $new_file_name = $file_name;
        }
        
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            echo "<h2>Файл успішно завантажено! ✅</h2>";
            echo "Ім'я файлу: **" . $new_file_name . "**<br>";
            echo "Тип файлу: **" . $file_type . "**<br>";
            echo "Розмір файлу: **" . round($file_size / 1024, 2) . "** КБ<br>";
            echo "<br>";
            echo "<a href='$target_path' download>Завантажити файл назад</a>";
        } else {
            echo "Помилка при збереженні файлу на сервері.";
        }
    } else {
        echo "Файл не був завантажений через HTTP POST.";
    }
} else {
    echo "Будь ласка, оберіть файл для завантаження.";
}
?>