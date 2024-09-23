-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 23 2024 г., 06:08
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `todolist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_completed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `is_completed`, `created_at`, `updated_at`) VALUES
(1, 6, 'вывц', 'вцй2121', 0, '2024-09-14 03:09:26', '2024-09-20 07:16:10'),
(2, 6, 'Note222', 'Note222', 0, '2024-09-14 03:09:41', '2024-09-19 09:42:21'),
(3, 6, 'Note333', 'Note333', 0, '2024-09-14 03:09:47', '2024-09-19 09:42:24'),
(4, 6, 'dw', 'dw', 0, '2024-09-18 05:25:14', '2024-09-19 09:42:28'),
(5, 6, '1212121', '3ddwdwdw', 1, '2024-09-19 09:41:02', '2024-09-19 09:41:26'),
(6, 6, '11221', '212121', 1, '2024-09-19 09:41:05', '2024-09-19 09:41:29'),
(7, 6, '12121', '121122121', 1, '2024-09-19 09:41:09', '2024-09-19 09:41:29'),
(8, 6, '1212121', '21212121', 1, '2024-09-19 09:41:14', '2024-09-19 09:41:30'),
(10, 6, '2e2e2e2e', 'e22e2e', 0, '2024-09-19 09:41:54', '2024-09-19 09:41:54'),
(11, 6, 'ввцвц', 'вцвцвц', 0, '2024-09-19 10:09:10', '2024-09-19 10:10:36'),
(13, 7, 'ы', 'ы', 1, '2024-09-19 10:51:09', '2024-09-19 10:51:11'),
(14, 7, 'не ыыыыыыыыыыыыыы', 'не ыыыыыыыы', 0, '2024-09-19 10:51:16', '2024-09-19 10:51:26');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','blocked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`, `role`, `status`) VALUES
(1, 'den4ik20', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-07 22:53:21', 'user', 'active'),
(2, 'Den125', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-07 23:04:54', 'user', 'active'),
(3, 'Dens123', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-11 18:54:06', 'user', 'active'),
(5, 'dens', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-12 09:43:18', 'user', 'active'),
(6, 'Tester', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-19 09:40:44', 'user', 'active'),
(7, 'test', '$2y$10$Cyf3xjbQkBuLy/bQUhIZf.ZNuSzUGRn93RjSJR7ZjE4jZ930CnTFG', '2024-09-19 10:42:37', 'user', 'active');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
