<?php
session_start();
require "../database/db.php";

$user = $_SESSION['user'];

if (!isset($user)) {
    echo "<script>alert('Вы не авторизованы!');location.href='../logout.php';</script>";
    exit();
}

$sql = "SELECT * FROM users WHERE id = '$user'";
$result = mysqli_query($connect, $sql);
$res = mysqli_fetch_assoc($result);

if ($res) {
    $login = $res['username'];
    $password = $res['password_hash']; // Это хэшированный пароль
    $registration_date = date('d.m.Y H:i', strtotime($res['created_at']));
} else {
    echo "<script>alert('Пользователь не найден!');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <?php if (isset($user)): ?>
        <title>Todo List | <?php echo htmlspecialchars($login); ?></title>
    <?php endif; ?>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../design/css/main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include "../includes/nav.php"; ?>
    <div id="user-profile-content">
        <h1>Ваши данные</h1>

        <form action="update_data.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Никнейм:</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo htmlspecialchars($login); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Подтвердите пароль:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" id="btn-purple" class="btn btn-primary">Обновить данные</button>
        </form>

        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Никнейм</th>
                    <th scope="col">Пароль (Хэш)</th>
                    <th scope="col">Дата и время регистрации</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td><?php echo htmlspecialchars($login); ?></td>

                    <!-- Здесь будет отображен хэш пароля -->
                    <td><?php echo htmlspecialchars($password); ?></td>

                    <td><?php echo htmlspecialchars($registration_date); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>