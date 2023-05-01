-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 01 2023 г., 22:21
-- Версия сервера: 8.0.31-23
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tma`
--

-- --------------------------------------------------------

--
-- Структура таблицы `crm`
--

CREATE TABLE `crm` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `request` text NOT NULL,
  `created_at` datetime NOT NULL,
  `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `projects_has_categories_sk`
--

CREATE TABLE `projects_has_categories_sk` (
  `project_id` int NOT NULL,
  `project_category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `projects_has_categories_sk`
--

INSERT INTO `projects_has_categories_sk` (`project_id`, `project_category_id`) VALUES
(1, 1),
(6, 1),
(7, 1),
(9, 1),
(10, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(11, 2),
(2, 3),
(3, 3),
(4, 3),
(8, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `projects_sk`
--

CREATE TABLE `projects_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `intro_text` mediumtext,
  `full_text` text,
  `customer` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `image_ImageWidth` smallint DEFAULT '0',
  `image_ImageHeight` smallint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0',
  `meta_key` text,
  `meta_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `projects_sk`
--

INSERT INTO `projects_sk` (`id`, `title`, `alias`, `intro_text`, `full_text`, `customer`, `image`, `image_ImageWidth`, `image_ImageHeight`, `ordering`, `published`, `meta_key`, `meta_description`) VALUES
(1, 'Byt', 'flat', 'Dizajn interiéru bytu', '', '', 'flat.jpg', 0, 0, 0, 1, '', ''),
(2, 'Kancelária', 'office', 'Dizajn interiéru kancelárie', '', '', 'office.jpg', 0, 0, 1, 1, '', ''),
(3, 'Autosalón', 'autosalon', 'Dizajn interiéru autosalóna', '', '', 'salon.jpg', 0, 0, 2, 1, '', ''),
(4, 'Kancelária', 'office_2', 'Dizajn interiéru kancelárie', '', '', 'office2.jpg', 0, 0, 3, 1, '', ''),
(5, 'Výstava', 'exhibition', 'Projekt interiéru výstavy', '', '', 'museum2.jpg', 0, 0, 4, 1, '', ''),
(6, 'Byt', 'flat_2', 'Dizajn interiéru bytu', '', '', 'flat13a.jpg', 0, 0, 5, 1, '', ''),
(7, 'Byt', 'flat_3', 'Dizajn interiéru bytu', '', '', 'flat12b.jpg', 0, 0, 6, 1, '', ''),
(8, 'Nahrávacie štúdio', 'recording_studio', 'Projekt interiéru nahrávacieho štúdia', '', '', 'sstudio.jpg', 0, 0, 7, 1, '', ''),
(9, 'Byt', 'flat_4', 'Dizajn interiéru bytu', '', '', 'flat11b.jpg', 0, 0, 8, 1, '', ''),
(10, 'Byt', 'flat_5', 'Dizajn interiéru bytu', '', '', 'flat9a.jpg', 0, 0, 9, 1, '', ''),
(11, 'Rodinný dom', 'house', 'Dizajn interiéru rodinného domu', '', '', 'townhouse.jpg', 0, 0, 10, 1, '', ''),
(12, 'Byt', 'flat_5', 'Dizajn interiéru bytu', '', '', 'flat4.jpg', 0, 0, 11, 1, '', ''),
(13, 'Byt', 'flat_6', 'Dizajn interiéru bytu', '', '', 'flat3.jpg', 0, 0, 12, 1, '', ''),
(14, 'Byt', 'flat_7', 'Dizajn interiéru bytu', '', '', 'flat2.jpg', 0, 0, 13, 1, '', ''),
(15, 'Byt', 'flat_8', 'Dizajn interiéru bytu', '', '', 'flat5.jpg', 0, 0, 14, 1, '', ''),
(16, 'Byt', 'flat_9', 'Dizajn interiéru bytu', '', '', 'flat6.jpg', 0, 0, 15, 1, '', ''),
(17, 'Byt', 'flat_10', 'Dizajn interiéru bytu', '', '', 'flat7.jpg', 0, 0, 16, 1, '', ''),
(18, 'Byt', 'flat_11', 'Dizajn interiéru bytu', '', '', 'flat8.jpg', 0, 0, 17, 1, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `project_categories_sk`
--

CREATE TABLE `project_categories_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `enabled` tinyint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `project_categories_sk`
--

INSERT INTO `project_categories_sk` (`id`, `title`, `alias`, `description`, `enabled`, `ordering`, `published`) VALUES
(1, 'Byty', 'flats', NULL, 1, 0, 1),
(2, 'Doma', 'houses', NULL, 1, 0, 1),
(3, 'Kancelárie', 'offices', NULL, 1, 0, 1),
(4, 'Výstavy', 'exhibitions', NULL, 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `project_files_sk`
--

CREATE TABLE `project_files_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro_text` mediumtext,
  `file_name` varchar(255) NOT NULL,
  `file_ImageWidth` smallint DEFAULT '0',
  `file_ImageHeight` smallint DEFAULT '0',
  `large_file_name` varchar(255) NOT NULL,
  `large_file_ImageWidth` smallint DEFAULT '0',
  `large_file_ImageHeight` smallint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0',
  `project_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` tinyint DEFAULT '0',
  `block` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `usertype`, `block`) VALUES
(1, 'Petr', 'admin', '01b307acba4f54f55aafc33bb06bbbf6ca803e9a', 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `crm`
--
ALTER TABLE `crm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_idx` (`email`) INVISIBLE,
  ADD KEY `created_at_idx` (`created_at`),
  ADD KEY `replied_at_idx` (`replied_at`),
  ADD KEY `name_idx` (`name`) USING BTREE;

--
-- Индексы таблицы `projects_has_categories_sk`
--
ALTER TABLE `projects_has_categories_sk`
  ADD PRIMARY KEY (`project_id`,`project_category_id`),
  ADD KEY `project_category_id_idx` (`project_category_id`),
  ADD KEY `project_id_idx` (`project_id`) INVISIBLE;

--
-- Индексы таблицы `projects_sk`
--
ALTER TABLE `projects_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`);

--
-- Индексы таблицы `project_categories_sk`
--
ALTER TABLE `project_categories_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`);

--
-- Индексы таблицы `project_files_sk`
--
ALTER TABLE `project_files_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`),
  ADD KEY `project_id_idx` (`project_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_idx` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `crm`
--
ALTER TABLE `crm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `projects_sk`
--
ALTER TABLE `projects_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `project_categories_sk`
--
ALTER TABLE `project_categories_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `project_files_sk`
--
ALTER TABLE `project_files_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=684;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `projects_has_categories_sk`
--
ALTER TABLE `projects_has_categories_sk`
  ADD CONSTRAINT `projects_has_categories_sk_project_categories_sk_fkey` FOREIGN KEY (`project_category_id`) REFERENCES `project_categories_sk` (`id`),
  ADD CONSTRAINT `projects_has_categories_sk_projects_sk_fkey` FOREIGN KEY (`project_id`) REFERENCES `projects_sk` (`id`);

--
-- Ограничения внешнего ключа таблицы `project_files_sk`
--
ALTER TABLE `project_files_sk`
  ADD CONSTRAINT `project_files_sk_projects_sk_fkey` FOREIGN KEY (`project_id`) REFERENCES `projects_sk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
