<? session_start();
$isLoggedIn = isset($_SESSION['user']); ?>

<nav onkeypress="" id="navbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../img/LOGO.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            TODO-LIST
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <?php if (!$isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" accesskey="r" href="../index.php">Регистрация</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" accesskey="l" href="../login.php">Авторизация</a>
                    </li>
                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link active" accesskey="h" aria-current="page" href="../">Главная</a>
                    </li>
                    <!-- Ссылки для авторизованных пользователей -->
                    <li class="nav-item">
                        <a class="nav-link" accesskey="u" href="../user/user.php">Личный Кабинет</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" accesskey="e" href="../logout.php">Выйти</a> <!-- Ссылка для выхода из системы -->
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>