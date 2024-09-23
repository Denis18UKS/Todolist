<?php
session_start();
require "database/db.php";
$isLoggedIn = isset($_SESSION['user']);

// Проверка наличия данных в сессии
$user_id = isset($_SESSION['user']) ? intval($_SESSION['user']) : 0;

$filter = isset($_GET['filter']) ? intval($_GET['filter']) : 3; // Значение по умолчанию - "Все"
$searchQuery = isset($_POST['search']) ? trim(mysqli_real_escape_string($connect, $_POST['search'])) : ''; // Получаем строку поиска и экранируем

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <?php if (!$isLoggedIn): ?>
        <title>TODO-LIST | Регистрация</title>
    <?php else: ?>
        <title>TODO-LIST | Главная</title>
    <?php endif; ?>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='design/css/main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <? if ($isLoggedIn) { ?>
        <script src='design/js/darkTheme.js' defer></script>
    <? } ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include "includes/nav.php" ?>

    <?php if (!$isLoggedIn): ?>
        <h1>Регистрация</h1>
        <form id="forms" action="database/reg-db.php" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Логин</label>
                <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" name="password_hash" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" id="btn-purple" class="btn btn-success">Регистрация</button>
        </form>
    <?php else: ?>
        <!-- Ссылки для авторизованных пользователей -->
        <h1>TODO LIST</h1>

        <div id="contents-main">
            <div id="search-block">
                <form action="" id="form-search" method="post">
                    <div style="position: relative;">
                        <img src="img/search.svg" class="fa fa-search" style="position: absolute; top: 50%; right: 8px; transform: translateY(-50%);">
                        <input placeholder="Search note..." id="search-input" type="text" name="search" style="padding-left: 30px;" value="<?= htmlspecialchars($searchQuery) ?>">
                    </div>
                </form>

                <div id="listing-and-dark-btn">
                    <form action="" method="get">
                        <select class="form-select" id="list-select" name="filter" aria-label="Default select example">
                            <option value="3" <?= $filter == 3 ? 'selected' : '' ?>>Все</option>
                            <option value="1" <?= $filter == 1 ? 'selected' : '' ?>>Выполненные</option>
                            <option value="0" <?= $filter == 0 ? 'selected' : '' ?>>Не выполненные</option>
                        </select>
                        <button class="btn btn-dark">Применить</button>
                    </form>

                    <button id="btn-dark" onclick="toggleDarkTheme()" class="dark-moon-btn"><img src="img/moon.svg" alt=""></button>
                    <button id="btn-sun" onclick="toggleDarkTheme()" class="dark-moon-btn"><img src="img/sun.svg" alt=""></button>
                </div>
            </div>

            <div id="block-note-list">
                <?php
                // Запрос в БД
                $sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";

                // Фильтрация
                if ($filter == 1) {
                    $sql .= " AND is_completed = 1"; // Выполненные
                } elseif ($filter == 0) {
                    $sql .= " AND is_completed = 0"; // Не выполненные
                }

                // Поиск задач по введенному запросу
                if (!empty($searchQuery)) {
                    $sql .= " AND (title LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%')";
                }

                $result = mysqli_query($connect, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $num_task = $row['id'];
                        $title = $row['title'];
                        $desc = $row['description'];
                        $completed = $row['is_completed'];
                ?>
                        <div id="note" class="note1">
                            <div id="checkbox-content">
                                <div id="title-content-and-desc">
                                    <? if ($completed == 0) { ?>
                                        <input onclick="location.href='tasks/checked.php?id=<? echo $num_task ?>'" type="checkbox" name="<?php echo $num_task; ?>" id="<?php echo $num_task; ?>">
                                        <label for="<?php echo $num_task; ?>"><?php echo "NOTE #" . $num_task; ?></label>
                                    <? } else if ($completed == 1) { ?>
                                        <input checked disabled type="checkbox" name="<?php echo $num_task; ?>" id="<?php echo $num_task; ?>">
                                        <label id="checked" for="<?php echo $num_task; ?>"><?php echo "NOTE #" . $num_task; ?></label>
                                    <? } ?>
                                </div>

                                <? if (isset($_GET['edit' . $num_task])) { ?>
                                    <form action="tasks/edit-note.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $num_task; ?>">
                                        <? if ($completed == 0) { ?>
                                            <input type="text" placeholder="<? echo "Заголовок" ?>" value="<? echo $title ?>" name="new-title" id="new-title">
                                            <textarea name="desc" placeholder="<?php echo htmlspecialchars("Описание"); ?>" id="checkbox1"><? echo $desc ?></textarea>
                                            <button type="submit" id="btn-purple" class="btn btn-primary">Сохранить изменения</button>
                                            <a href="../" class="btn btn-danger">Скрыть</a>
                                        <? } else if ($completed == 1) { ?>
                                            <input readonly type="text" placeholder="<? echo "Заголовок" ?>" value="<? echo $title ?>" name="new-title" id="new-title">
                                            <textarea readonly name="desc" placeholder="<?php echo htmlspecialchars("Описание"); ?>" id="checkbox1"><? echo $desc ?></textarea>
                                        <? } ?>
                                    </form>
                                <? } ?>
                            </div>

                            <? if ($completed == 0) { ?>
                                <div id="edit-and-delete">
                                    <img onclick="location.href='?edit<? echo $num_task ?>'" id="edit" class="edit_btn" src="img/edit.svg" alt="">
                                    <img onclick="location.href='tasks/delete-note.php?id=<? echo $num_task ?>'" id="delete" class="delete_btn" src="img/delete.svg" alt="">
                                </div>
                            <? } else if ($completed == 1) { ?>
                                <div id="edit-and-delete">
                                    <div id="img-contents">
                                        <img id="edit" class="edit_btn_disabled" src="img/edit.svg" alt="">
                                        <img id="delete" class="delete_btn_disabled" src="img/delete.svg" alt="">
                                        <? if (isset($_GET['edit' . $num_task])) { ?>
                                            <a href="../" class="btn btn-danger">Скрыть</a>
                                        <? } else { ?>
                                            <button onclick="location.href='?edit<? echo $num_task ?>'" id="btn-purple" class="btn btn-dark" alt="">Показать</button>
                                        <? } ?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                <?php
                    }
                } else {
                    echo "Записей нет";
                }
                ?>
            </div>

            <div class="block-add-note">
                <button type="button" class="add-note" data-bs-toggle="modal" data-bs-target="#NewNoteModal">
                    <h1>+</h1>
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="NewNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 style="color: black;" class="modal-title fs-5" id="exampleModalLabel">NEW NOTE</h1>
                    </div>
                    <div class="modal-body">
                        <div id="new-note-contents">
                            <form action="tasks/new-note.php" method="post" id="new-note-add">
                                <input type="text" class="mb-3" placeholder="Input your note..." name="new-task" id="new-task">
                                <textarea class="mb-3" placeholder="Input your desc" name="desc" id="desc"></textarea>
                                <div id="btn-content-cancel-apply">
                                    <button id="btn-purple" class="btn btn-primary" type="button" data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                                    <button id="btn-purple" class="btn btn-primary">APPLY</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</body>

</html>