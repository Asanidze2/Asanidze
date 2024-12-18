<?php
require 'config.php';

// Добавление новой задачи
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
    }
}

// Получение списка задач
$stmt = $pdo->query("SELECT * FROM tasks");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
</head>
<body>
    <h1>Список задач</h1>

    <!-- Форма для добавления задачи -->
    <form action="" method="POST">
        <label for="title">Новая задача:</label>
        <input type="text" name="title" id="title" required>
        <button type="submit">Добавить</button>
    </form>

    <!-- Вывод списка задач -->
    <h2>Ваши задачи:</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['title']) ?>
                - <?= $task['completed'] ? 'Выполнено' : 'Не выполнено' ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
<?php
// Удаление задачи
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; // Получаем ID задачи из URL и приводим его к числу
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id"); // SQL-запрос на удаление
    $stmt->execute(['id' => $id]); // Выполнение запроса с передачей ID
    header("Location: index.php"); // Перенаправление на главную страницу
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список задач</title>
</head>
<body>
    <h2>Ваши задачи:</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['title']) ?>
                - <?= $task['completed'] ? 'Выполнено' : 'Не выполнено' ?>
                <a href="?delete=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?');">[Удалить]</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
<?php
require 'config.php'; // Подключение к базе данных

// Обновление статуса задачи
if (isset($_GET['complete'])) {
    $id = (int)$_GET['complete']; // Получаем ID задачи из URL и приводим его к числу
    $stmt = $pdo->prepare("UPDATE tasks SET completed = NOT completed WHERE id = :id");
    $stmt->execute(['id' => $id]); // Выполняем запрос для изменения статуса
    header("Location: index.php"); // Перенаправляем на главную страницу
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список задач</title>
</head>
<body>
    <h2>Ваши задачи:</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['title']) ?> 
                - <?= $task['completed'] ? 'Выполнено' : 'Не выполнено' ?>
                <a href="?complete=<?= $task['id'] ?>">[Изменить статус]</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>






