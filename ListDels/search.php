<?php
session_start();
require "database/db.php";
// Проверка авторизации
$isLoggedIn = isset($_SESSION['user']);
$user_id = $isLoggedIn ? intval($_SESSION['user']) : 0;

// Подключение к базе данных

if (!$connect) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Получение строк поиска и фильтрации
$searchQuery = isset($_POST['search']) ? trim(mysqli_real_escape_string($connect, $_POST['search'])) : '';
$filter = isset($_POST['filter']) ? intval($_POST['filter']) : null;

$sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";

// Добавление условий фильтрации по завершенности задач
if ($filter === 1) {
    $sql .= " AND is_completed = 1"; // Выполненные
} elseif ($filter === 0) {
    $sql .= " AND is_completed = 0"; // Не выполненные
}

// Добавление условия поиска, если строка не пустая
if (!empty($searchQuery)) {
    $sql .= " AND (title LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%')";
}

$result = mysqli_query($connect, $sql);

// Проверка на наличие ошибок в запросе
if (!$result) {
    die("Ошибка выполнения запроса: " . mysqli_error($connect));
}

// Вывод результатов поиска
echo "<h1>Результаты поиска</h1>";
if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li><strong>" . htmlspecialchars($row['title']) . "</strong>: " . htmlspecialchars($row['description']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>По вашему запросу ничего не найдено.</p>";
}

// Закрытие соединения с базой данных
mysqli_close($connect);
