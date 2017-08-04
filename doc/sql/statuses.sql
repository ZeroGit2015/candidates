-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 15 2017 г., 15:57
-- Версия сервера: 5.5.48
-- Версия PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `inline`
--

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(10) unsigned NOT NULL COMMENT 'Ключ',
  `name` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование',
  `name_table` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Таблица',
  `id_election` int(11) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `name_table`, `id_election`) VALUES
(1, 'На рассмотрении', 'candidates', 1),
(2, 'Получено согласие кандидата', 'candidates', 1),
(3, 'Кандидат отказался', 'candidates', 1),
(4, 'Отказано в выдвижении', 'candidates', 1),
(9, 'Выдвинут', 'candidates', 1),
(10, 'Зарегистрирован', 'candidates', 1),
(11, 'Допущен к распределению мандатов', 'candidates', 1),
(12, '', 'experts', 1),
(13, 'эксперт дал согласие на участие в разработке программы', 'experts', 1),
(14, 'эксперт дал согласие на получение материалов', 'experts', 1),
(15, 'эксперт не имел переговоров с партией', 'experts', 1),
(16, '', 'candidates', 1),
(17, 'Подготовлен к выдвижению', 'candidates', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Ключ',AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
