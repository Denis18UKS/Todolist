<?php
session_start();
require "../database/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = htmlspecialchars($_POST['new-title']);
    $desc = htmlspecialchars($_POST['desc']);
    $user = $_SESSION['user'];

    $sql = "UPDATE `tasks` SET `title` = '$title', `description` = '$desc' WHERE `id` = '$id' AND `user_id` = '$user'";

    if ($connect->query($sql)) {
        echo
        "<script>
            alert('Изменения сохранены!');
            location.href='../';
        </script>";
        exit;
    } else {
        echo "Ошибка при обновлении данных: " . $connect->error;
    }
}
