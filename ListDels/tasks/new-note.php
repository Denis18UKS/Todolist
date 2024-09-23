<?php
session_start();
require "../database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['new-task']);
    $desc = trim($_POST['desc']);
    $user = $_SESSION['user'];

    // Проверка на заполненность полей
    if (empty($title) || empty($desc)) {
        echo "<script>
                alert('Пожалуйста, заполните все поля.');
                location.href='../';
            </script>";
        exit; // Завершаем выполнение скрипта
    }

    $sql = "INSERT INTO `tasks`(
        `user_id`,
        `title`,
        `description`
    )
    VALUES(
        '$user',    
        '$title',
        '$desc'
    )";

    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo "<script>
                alert('Заметка добавлена!');
                location.href = '../';
            </script>";
    } else {
        echo "<script>
                alert('Произошла ошибка. Попробуйте еще раз.');
                location.href='../';
            </script>";
    }
}
?>