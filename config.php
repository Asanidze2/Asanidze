<?php
$host = "localhost";
$user = "root"; // Пользователь по умолчанию
$password = ""; // Пароль по умолчанию пустой
$dbname = "todo_list"; // Имя вашей базы данных

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
