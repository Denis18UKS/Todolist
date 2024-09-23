// Функция для применения темы при загрузке страницы
function applyTheme() {
    const savedTheme = localStorage.getItem('theme');
    const body = document.body;

    const btn_dark = document.getElementById("btn-dark");
    const btn_sun = document.getElementById("btn-sun");

    const edit_btn = document.getElementById("edit");
    const delete_btn = document.getElementById("delete");

    const edit_btn_dark = document.getElementById("edit-dark");
    const delete_dark = document.getElementById("delete-dark");

    const container_btn = document.getElementById("edit-and-delete")
    const container_btn_dark = document.getElementById("edit-and-delete-dark")

    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        body.classList.remove('light-mode');
        btn_sun.style.display = "block";
        btn_dark.style.display = "none";
        document.querySelector('.navbar').style.backgroundColor = '#000';

    } else {
        body.classList.add('light-mode');
        body.classList.remove('dark-mode');
        btn_sun.style.display = "none";
        btn_dark.style.display = "block";
        document.querySelector('.navbar').style.backgroundColor = '#6c63ff';

    }
}

// Функция для переключения темной и светлой темы
function toggleDarkTheme() {
    const body = document.body;
    const isDarkMode = body.classList.contains('dark-mode');

    const btn_dark = document.getElementById("btn-dark");
    const btn_sun = document.getElementById("btn-sun");

    if (!isDarkMode) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        btn_sun.style.display = "block";
        btn_dark.style.display = "none";
        document.querySelector('.navbar').style.backgroundColor = '#000';
        changeIcons('edit', 'delete', 'moon.svg', 'sun.svg');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light');
        btn_sun.style.display = "none";
        btn_dark.style.display = "block";
        document.querySelector('.navbar').style.backgroundColor = '#6c63ff';
    }
}

// Вызываем applyTheme при загрузке страницы
window.onload = applyTheme;

// Подписка на событие клика по кнопке
document.getElementById("btn-toggle").addEventListener("click", toggleDarkTheme);
