<?php
// Завдання 7
echo "Результат обробки кнопки";
echo "<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["surname"]) && !empty($_POST["surname"])){
        $name = htmlspecialchars(trim($_POST["name"]));
        $surname = htmlspecialchars(trim($_POST["surname"]));
    }

    if (is_string($name) && is_string($surname)){
        echo "Hello"." ".$name." ".$surname."!";
    } else{
        echo "Error: Incorrect data type.";
    }

}

?>