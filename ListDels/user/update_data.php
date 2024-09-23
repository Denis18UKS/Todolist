<?php
session_start();
require "../database/db.php";

$user = $_SESSION['user'];

if (!isset($user)) {
    echo "<script>alert('Вы не авторизованы!');location.href='../logout.php';</script>";
    exit();
}

// Получаем данные из POST-запроса
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Проверка: совпадают ли введенные пароли
if ($password !== $confirm_password) {
    echo "<script>alert('Пароли не совпадают!');location.href='user.php';</script>";
    exit();
}

// Хешируем новый пароль
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Обновляем данные пользователя в базе данных
$sql = "UPDATE users SET username = ?, password_hash = ? WHERE id = ?";
$stmt = mysqli_prepare($connect, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ssi', $username, $password_hash, $user);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Данные успешно обновлены!'); location.href='user.php';</script>";
    } else {
        echo "<script>alert('Ошибка обновления данных. Попробуйте снова.');</script>";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Ошибка подготовки запроса.');</script>";
}

mysqli_close($connect);