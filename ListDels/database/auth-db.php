<?php
session_start();
require "db.php"; // Подключение к базе данных

// Получение данных пользователя из POST-запроса
$login = isset($_POST["login"]) ? $_POST["login"] : '';
$password = isset($_POST["password_hash"]) ? $_POST["password_hash"] : ''; // Изменено на password

if (empty($login) || empty($password)) {
    echo "<script>alert('Заполните все поля!');location.href='../login.php';</script>";
    exit; // Завершаем выполнение скрипта
} else {
    // Получаем хэш пароля пользователя по логину
    $sql = "SELECT * FROM users WHERE username='$login'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $res = mysqli_fetch_assoc($result);
        $hashedPassword = $res['password_hash']; // Получаем хэш из базы данных

        // Проверяем введенный пароль с помощью password_verify
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user"] = $res['id'];
            echo "<script>alert('Вы вошли как пользователь $login');location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Неверный логин или пароль');location.href='../login.php';</script>";
        }
    } else {
        echo "<script>alert('Неверный логин или пароль');location.href='../login.php';</script>";
    }
}
?>