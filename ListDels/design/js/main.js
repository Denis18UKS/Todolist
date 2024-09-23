function DarkTheme() {
    const body = document.body;
    const isDarkMode = body.classList.contains('dark-mode');

    if (!isDarkMode) {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
    } else {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
    }
}
