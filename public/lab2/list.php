<?php

$upload_dir = 'uploads/';

echo "<h2>Список завантажених файлів</h2>";

if (is_dir($upload_dir)) {
    $files = scandir($upload_dir);
    $files = array_diff($files, ['.', '..']);

    if (!empty($files)) {
        echo "<ul>";
        foreach ($files as $file) {
            echo "<li><a href='$upload_dir$file' download>" . htmlspecialchars($file) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Немає завантажених файлів.</p>";
    }
} else {
    echo "<p>Директорія завантажень не знайдена.</p>";
}

?>