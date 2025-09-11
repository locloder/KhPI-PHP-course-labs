<?php
// Завдання 1
echo "Hello world!"."<br>";
echo "<br>";

// Завдання 2
$string = "рядок";
$int = 1;
$float = 1.2;
$bool = True ;

// Вивід завдання 2
echo "Вивід рядка: ".$string."<br>"; 
echo "Вивід цілого числа: ".$int."<br>"; 
echo "Вивід числа з плавуючою комою: ".$float."<br>"; 
echo "Вивід булевої змінної: ".$bool."<br>"; 

echo "<br>";
//var_dump
var_dump($string);
echo "<br>";
var_dump($int);
echo "<br>";
var_dump($float);
echo "<br>";
var_dump($bool);
echo "<br>";

// Завдання 3
$first_name = "Odin";
$second_name = "Beautiful";

$full_name = $second_name." ".$first_name;

echo "<br>";
echo $full_name;
echo "<br>";
echo "<br>";

// Завдання 4
$number = 5;

if ($number %2 == 0) {
    echo "Число"." ".$number." "."є парним";
} else{
        echo "Число"." ".$number." "."є не парним";
}
echo "<br>";
echo "<br>";

// Завдання 5
// for
echo "Вивід від 1 до 10: ";
for ($i = 1; $i <= 10; $i++){
    echo $i." ";
}
echo "<br>";

// while
echo "Вивід числа від 10 до 1: ";
$j = 10;
while ($j >= 1){
    echo $j." ";
    $j--;
}
echo "<br>";
echo "<br>";
// Завдання 6

$student = [
    "Name" => "Artem",
    "Surname" => "Makarenko",
    "Age" => 20,
    "group" => "IKM-223a"
];

echo "Information: <br>";
echo "Name: "." ".$student["Name"]."<br>";
echo "Surname: "." ".$student["Surname"]."<br>";
echo "Age: "." ".$student["Age"]."<br>";
echo "Group: "." ".$student["group"]."<br>";

$student["Country"] = "Ukraine";

echo "Country:"." ".$student["Country"]."<br>";
?>