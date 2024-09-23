<?php
require "db.php";

$login = isset($_POST["login"]) ? $_POST["login"] : '';
$password = isset($_POST["password_hash"]) ? $_POST["password_hash"] : ''; // изменяем на password

if (empty($login) || empty($password)) {
    echo "<script>alert('Заполните все поля!');location.href='../index.php';</script>";
} else {
    $sql = "SELECT * FROM users WHERE `username` = '$login'";
    $result = mysqli_query($connect, $sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Данный логин занят!');location.href='../index.php';</script>";
    } else {
        // Используем password_hash для хэширования пароля
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (
            `username`,
            `password_hash`
        ) VALUES (
            '$login',
            '$password_hash'
        )";

        $result = mysqli_query($connect, $sql);
        echo "<script>alert('Регистрация успешна!');location.href='../login.php';</script>";
    }
}
?>