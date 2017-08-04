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
-- Структура таблицы `show_fields`
--

CREATE TABLE IF NOT EXISTS `show_fields` (
  `id` int(10) unsigned NOT NULL COMMENT 'Ключ',
  `name_table` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Таблица',
  `field` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Поле(Псевдоним)',
  `visible` int(11) NOT NULL COMMENT 'Видимость по умолчанию',
  `name` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование столбца',
  `order` int(11) NOT NULL COMMENT 'Сортировка',
  `order_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Поле для сортировки по столбцу',
  `active` int(11) NOT NULL DEFAULT '1' COMMENT 'Признак использования'
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `show_fields`
--

INSERT INTO `show_fields` (`id`, `name_table`, `field`, `visible`, `name`, `order`, `order_by`, `active`) VALUES
(1, 'candidates', 'fio', 1, 'Ф.И.О.', 1, 'candidates.fio', 1),
(2, 'candidates', 'email', 0, 'email', 4, '', 1),
(3, 'candidates', 'phone', 0, 'Телефон', 5, '', 1),
(4, 'candidates', 'vip', 1, 'VIP', 10, '', 1),
(5, 'candidates', 'party', 1, 'Партийность', 11, '', 1),
(9, 'candidates', 'id', 1, 'ID', 0, 'candidates.id', 1),
(11, 'candidates', 'bdate', 0, 'Дата рождения', 14, '', 1),
(12, 'candidates', 'job', 0, 'Работа', 2, 'candidates.job', 1),
(13, 'candidates', 'job_status', 0, 'Должность', 3, 'candidates.job_status', 1),
(15, 'candidates', 'city', 0, 'Город', 14, '', 1),
(16, 'candidates', 'information', 0, 'Справка', 15, '', 1),
(19, 'candidates', 'invite', 0, 'Инициатор внесения', 22, '', 1),
(20, 'candidates', 'vk_acc', 0, 'Аккаунт вКонтакте', 23, '', 1),
(21, 'candidates', 'fb_acc', 0, 'Аккаунт Facebook', 24, '', 1),
(22, 'candidates', 'ok_acc', 0, 'Аккаунт Одноклассники', 25, '', 1),
(23, 'candidates', 'tw_acc', 0, 'Аккаунт Twitter', 26, '', 1),
(24, 'candidates', 'lj_acc', 0, 'Аккаунт LiveJournal', 27, '', 1),
(25, 'candidates', 'inst_acc', 0, 'Аккаунт Instagram', 28, '', 1),
(26, 'candidates', 'per_acc', 0, 'Аккаунт Periscope', 29, '', 1),
(27, 'candidates', 'yt_acc', 0, 'Аккаунт YouTube', 30, '', 1),
(28, 'candidates', 'personal_site', 0, 'Личный сайт', 31, '', 1),
(29, 'candidates', 'wiki', 0, 'Википедия', 32, '', 1),
(122, 'experts', 'fio', 1, 'Ф.И.О.', 1, 'fio', 1),
(123, 'candidates', 'region', 1, '', 2, 'base_regions.name', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `show_fields`
--
ALTER TABLE `show_fields`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `show_fields`
--
ALTER TABLE `show_fields`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Ключ',AUTO_INCREMENT=124;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
