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

    // SQL-запрос для удаления заметки
    $sql = "DELETE FROM tasks WHERE id = '$task_id' AND user_id = '" . intval($_SESSION['user']) . "'";

    if (mysqli_query($connect, $sql)) {
        // Успешное удаление
        echo
            "<script>
                alert('Заметка успешно удалена');
                location.href='../';
            </script>";
    } else {
        // Ошибка выполнения запроса
        echo
            "<script>
                alert('Ошибка! Попробуйте ещё раз!');
                location.href='../';
            </script>";
    }
} else {
    echo
        "<script>
            alert('Ошбика! Попробуйте ещё раз!');
            location.href='../';
        </script>";
}
