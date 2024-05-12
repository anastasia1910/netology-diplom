-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 12 2024 г., 20:24
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cinema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `halls`
--

CREATE TABLE `halls` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `activity` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `halls`
--

INSERT INTO `halls` (`id`, `name`, `activity`) VALUES
(78, 'Зал 1', 1),
(79, 'Зал 2', 0),
(80, 'Зал 3', 0),
(81, 'Зал 4', 0),
(82, 'Зал 5', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int NOT NULL,
  `description` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `poster` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `movies`
--

INSERT INTO `movies` (`id`, `name`, `duration`, `description`, `country`, `poster`) VALUES
(34, 'Фильм 1', 120, 'Описание фильма 1', 'США', '../posters/poster.png'),
(48, 'Фильм 1', 120, 'Описание фильма 1', 'США', '../posters/poster.png');

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int NOT NULL,
  `hall_id` int NOT NULL,
  `standart_price` decimal(10,2) NOT NULL,
  `vip_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `prices`
--

INSERT INTO `prices` (`id`, `hall_id`, `standart_price`, `vip_price`) VALUES
(9, 78, '100.00', '250.00'),
(10, 79, '100.00', '250.00'),
(11, 80, '1000.00', '2500.00'),
(12, 81, '100.00', '250.00'),
(13, 82, '100.00', '250.00');

-- --------------------------------------------------------

--
-- Структура таблицы `seances`
--

CREATE TABLE `seances` (
  `id` int NOT NULL,
  `hall_id` int DEFAULT NULL,
  `movie_id` int DEFAULT NULL,
  `start_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `seances`
--

INSERT INTO `seances` (`id`, `hall_id`, `movie_id`, `start_time`) VALUES
(23, 78, 34, '12:00:00'),
(33, 80, 34, '12:00:00'),
(35, 80, 48, '15:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `hall_id` int NOT NULL,
  `row_num` int NOT NULL,
  `seat_num` int NOT NULL,
  `type` enum('standart','vip','disabled') NOT NULL DEFAULT 'standart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `seats`
--

INSERT INTO `seats` (`id`, `hall_id`, `row_num`, `seat_num`, `type`) VALUES
(176, 79, 1, 1, 'standart'),
(177, 79, 1, 2, 'standart'),
(178, 79, 1, 3, 'standart'),
(179, 79, 1, 4, 'standart'),
(180, 79, 1, 5, 'standart'),
(181, 79, 1, 6, 'standart'),
(182, 79, 1, 7, 'standart'),
(183, 79, 1, 8, 'standart'),
(184, 79, 2, 1, 'standart'),
(185, 79, 2, 2, 'standart'),
(186, 79, 2, 3, 'standart'),
(187, 79, 2, 4, 'standart'),
(188, 79, 2, 5, 'standart'),
(189, 79, 2, 6, 'standart'),
(190, 79, 2, 7, 'standart'),
(191, 79, 2, 8, 'standart'),
(192, 79, 3, 1, 'standart'),
(193, 79, 3, 2, 'standart'),
(194, 79, 3, 3, 'standart'),
(195, 79, 3, 4, 'standart'),
(196, 79, 3, 5, 'standart'),
(197, 79, 3, 6, 'standart'),
(198, 79, 3, 7, 'standart'),
(199, 79, 3, 8, 'standart'),
(200, 79, 4, 1, 'standart'),
(201, 79, 4, 2, 'standart'),
(202, 79, 4, 3, 'standart'),
(203, 79, 4, 4, 'standart'),
(204, 79, 4, 5, 'standart'),
(205, 79, 4, 6, 'standart'),
(206, 79, 4, 7, 'standart'),
(207, 79, 4, 8, 'standart'),
(208, 79, 5, 1, 'standart'),
(209, 79, 5, 2, 'standart'),
(210, 79, 5, 3, 'standart'),
(211, 79, 5, 4, 'standart'),
(212, 79, 5, 5, 'standart'),
(213, 79, 5, 6, 'standart'),
(214, 79, 5, 7, 'standart'),
(215, 79, 5, 8, 'standart'),
(216, 79, 6, 1, 'standart'),
(217, 79, 6, 2, 'standart'),
(218, 79, 6, 3, 'standart'),
(219, 79, 6, 4, 'standart'),
(220, 79, 6, 5, 'standart'),
(221, 79, 6, 6, 'standart'),
(222, 79, 6, 7, 'standart'),
(223, 79, 6, 8, 'standart'),
(224, 79, 7, 1, 'standart'),
(225, 79, 7, 2, 'standart'),
(226, 79, 7, 3, 'standart'),
(227, 79, 7, 4, 'standart'),
(228, 79, 7, 5, 'standart'),
(229, 79, 7, 6, 'standart'),
(230, 79, 7, 7, 'standart'),
(231, 79, 7, 8, 'standart'),
(232, 79, 8, 1, 'standart'),
(233, 79, 8, 2, 'standart'),
(234, 79, 8, 3, 'standart'),
(235, 79, 8, 4, 'standart'),
(236, 79, 8, 5, 'standart'),
(237, 79, 8, 6, 'standart'),
(238, 79, 8, 7, 'standart'),
(239, 79, 8, 8, 'standart'),
(352, 81, 1, 1, 'standart'),
(353, 81, 1, 2, 'standart'),
(354, 81, 2, 1, 'vip'),
(355, 81, 2, 2, 'vip'),
(468, 78, 1, 1, 'standart'),
(469, 78, 1, 2, 'standart'),
(470, 78, 1, 3, 'standart'),
(471, 78, 1, 4, 'standart'),
(472, 78, 1, 5, 'standart'),
(473, 78, 1, 6, 'standart'),
(474, 78, 1, 7, 'standart'),
(475, 78, 1, 8, 'standart'),
(476, 78, 2, 1, 'standart'),
(477, 78, 2, 2, 'standart'),
(478, 78, 2, 3, 'standart'),
(479, 78, 2, 4, 'standart'),
(480, 78, 2, 5, 'standart'),
(481, 78, 2, 6, 'standart'),
(482, 78, 2, 7, 'standart'),
(483, 78, 2, 8, 'standart'),
(484, 78, 3, 1, 'standart'),
(485, 78, 3, 2, 'standart'),
(486, 78, 3, 3, 'standart'),
(487, 78, 3, 4, 'standart'),
(488, 78, 3, 5, 'standart'),
(489, 78, 3, 6, 'standart'),
(490, 78, 3, 7, 'standart'),
(491, 78, 3, 8, 'standart'),
(492, 78, 4, 1, 'standart'),
(493, 78, 4, 2, 'standart'),
(494, 78, 4, 3, 'standart'),
(495, 78, 4, 4, 'standart'),
(496, 78, 4, 5, 'standart'),
(497, 78, 4, 6, 'standart'),
(498, 78, 4, 7, 'standart'),
(499, 78, 4, 8, 'standart'),
(500, 78, 5, 1, 'standart'),
(501, 78, 5, 2, 'standart'),
(502, 78, 5, 3, 'standart'),
(503, 78, 5, 4, 'standart'),
(504, 78, 5, 5, 'standart'),
(505, 78, 5, 6, 'standart'),
(506, 78, 5, 7, 'standart'),
(507, 78, 5, 8, 'standart'),
(508, 78, 6, 1, 'standart'),
(509, 78, 6, 2, 'standart'),
(510, 78, 6, 3, 'standart'),
(511, 78, 6, 4, 'standart'),
(512, 78, 6, 5, 'standart'),
(513, 78, 6, 6, 'standart'),
(514, 78, 6, 7, 'standart'),
(515, 78, 6, 8, 'standart'),
(516, 78, 7, 1, 'vip'),
(517, 78, 7, 2, 'vip'),
(518, 78, 7, 3, 'vip'),
(519, 78, 7, 4, 'vip'),
(520, 78, 7, 5, 'vip'),
(521, 78, 7, 6, 'vip'),
(522, 78, 7, 7, 'vip'),
(523, 78, 7, 8, 'vip'),
(524, 80, 1, 1, 'standart'),
(525, 80, 1, 2, 'standart'),
(526, 80, 1, 3, 'standart'),
(527, 80, 2, 1, 'standart'),
(528, 80, 2, 2, 'standart'),
(529, 80, 2, 3, 'standart'),
(530, 80, 3, 1, 'vip'),
(531, 80, 3, 2, 'vip'),
(532, 80, 3, 3, 'vip'),
(533, 82, 1, 1, 'vip'),
(534, 82, 1, 2, 'disabled'),
(535, 82, 2, 1, 'vip'),
(536, 82, 2, 2, 'vip'),
(537, 82, 3, 1, 'vip'),
(538, 82, 3, 2, 'vip'),
(539, 82, 4, 1, 'disabled'),
(540, 82, 4, 2, 'vip');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` int NOT NULL,
  `seance_id` int DEFAULT NULL,
  `seat_ids` varchar(255) DEFAULT NULL,
  `movie_name` varchar(255) DEFAULT NULL,
  `hall_name` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `ticket_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `seance_id`, `seat_ids`, `movie_name`, `hall_name`, `start_time`, `total_cost`, `ticket_code`) VALUES
(35, 23, '468,469', 'Фильм 1', 'Зал 1', '2024-05-12 12:00:00', '200.00', '499850');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@example.com', '$2y$10$qs6lxZcaD8/5YKpDtTfVBeLSLLZ48dxGul32k/JBEeFfqn0GHiM22');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_hall` (`hall_id`);

--
-- Индексы таблицы `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Индексы таблицы `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seats_halls` (`hall_id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seance_id` (`seance_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`);

--
-- Ограничения внешнего ключа таблицы `seances`
--
ALTER TABLE `seances`
  ADD CONSTRAINT `seances_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`),
  ADD CONSTRAINT `seances_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Ограничения внешнего ключа таблицы `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_seats_halls` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`seance_id`) REFERENCES `seances` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
