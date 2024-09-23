<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);

if (!$isLoggedIn) {
    header("Location: ../index.php");
    exit();
}

// Подключаемся к базе данных
include "../database/db.php";

// Проверяем, был ли передан ID заметки
if (isset($_GET['id'])) {
    $task_id = intval($_GET['id']); // Получаем ID заметки

    $sql = "UPDATE `tasks` 
    SET `is_completed` = '1'
    WHERE `id` = '$task_id' 
    AND user_id = '" . intval($_SESSION['user']) . "'";

    $result = mysqli_query($connect, $sql);
    if ($result) {
        // Успешное обновление
        header("Location: ../index.php");
    } else {
        // Ошибка выполнения запроса
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
