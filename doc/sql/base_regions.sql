-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2016 at 07:41 PM
-- Server version: 5.5.47-0+deb7u1-log
-- PHP Version: 5.6.11-1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yabloko`
--

-- --------------------------------------------------------

--
-- Table structure for table `base_regions`
--

CREATE TABLE IF NOT EXISTS `base_regions` (
  `id` int(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `taxonomy_id` int(4) NOT NULL,
  `name_eng` varchar(50) NOT NULL,
  `site` varchar(255) NOT NULL,
  `site_isactive` int(11) NOT NULL DEFAULT '0',
  `map_id` int(11) NOT NULL,
  `okrug` int(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `base_regions`
--

INSERT INTO `base_regions` (`id`, `name`, `active`, `taxonomy_id`, `name_eng`, `site`, `site_isactive`, `map_id`, `okrug`) VALUES
(0, '', 0, 0, '', '', 0, 0, 0),
(22, 'Алтайский край', 1, 27, 'Altai', 'yabloko-altai.ru', 1, 33, 5),
(28, 'Амурская область', 1, 57, 'Amur', 'amur.yabloko.ru', 0, 25, 4),
(29, 'Архангельская область', 1, 259, 'Arh', 'arh-yabloko.ru', 1, 7, 3),
(30, 'Астраханская область', 1, 165, 'Astrahan', 'astrahan.yabloko.ru', 0, 72, 2),
(31, 'Белгородская область', 1, 137, 'belgorod', '', 0, 67, 1),
(32, 'Брянская область', 1, 52, 'Bryansk', '', 0, 57, 1),
(4, 'Бурятская Республика', 1, 65, 'Buryatiya', 'buryatia.yabloko.ru', 0, 28, 5),
(33, 'Владимирская область', 1, 20, 'Vladimir', 'yabloko33.ru', 0, 52, 1),
(34, 'Волгоградская область', 1, 30, 'Volgograd', 'volgograd.yabloko.ru', 1, 69, 2),
(35, 'Вологодская область', 1, 272, 'Vologda', 'яблоковологда.рф', 0, 5, 3),
(36, 'Воронежская область', 1, 68, 'voronezh', 'www.yablokovrn.ru', 1, 68, 1),
(77, 'Город Москва', 1, 13, 'Moscow', 'mosyabloko.ru', 1, 83, 1),
(78, 'Город Санкт-Петербург', 1, 14, 'Spb', 'spb.yabloko.ru', 1, 82, 3),
(79, 'Еврейская автономная область', 0, 0, '', '', 0, 26, 4),
(37, 'Ивановская область', 1, 326, 'Ivanovo', '', 0, 11, 1),
(6, 'Республика Ингушетия', 1, 114, 'Ingushetiya', '', 0, 78, 8),
(38, 'Иркутская область', 1, 196, 'Irkutsk', 'irkutsk.yabloko.ru', 0, 29, 5),
(7, 'Кабардино-Балкарская Республика', 1, 0, 'Kbr', '', 0, 77, 8),
(8, 'Республика Калмыкия', 1, 70, 'kalmykiya', 'kalmykia.yabloko.ru', 0, 71, 2),
(39, 'Калининградская область', 1, 35, 'Kaliningrad', 'kaliningrad.yabloko.ru', 0, 1, 3),
(51, 'Мурманская область', 1, 58, 'Murmansk', '', 0, 8, 3),
(40, 'Калужская область', 1, 32, 'Kaluga', '', 0, 58, 1),
(41, 'Камчатский край', 0, 0, '', '', 0, 21, 4),
(9, 'Карачаево-Черкесская Республика', 1, 271, 'kchr', 'kchr.yabloko.ru', 0, 75, 8),
(10, 'Республика Карелия', 1, 37, 'Karelia', '', 0, 6, 3),
(42, 'Кемеровская область', 1, 154, 'kemerovo', 'kemerovo.yabloko.ru', 1, 32, 5),
(43, 'Кировская область', 1, 39, 'Kirov', 'kirov.yabloko.ru', 1, 12, 7),
(44, 'Костромская область', 1, 237, 'Kostroma', 'kostroma.yabloko.ru', 1, 51, 1),
(23, 'Краснодарский край', 1, 59, 'Krasnodar', 'krasnodar.yabloko.ru', 0, 73, 2),
(24, 'Красноярский край', 1, 153, 'krasnoyarsk', 'krasnoyarsk.yabloko.ru', 1, 17, 5),
(45, 'Курганская область', 1, 155, 'kurgan', 'kurgan.yabloko.ru', 1, 38, 6),
(46, 'Курская область', 1, 269, 'Kursk', '', 0, 66, 1),
(47, 'Ленинградская область', 1, 200, 'lo', 'lo.yabloko.ru', 1, 3, 3),
(48, 'Липецкая область', 1, 54, 'Lipetsk', 'lipetsk.yabloko.ru', 0, 64, 1),
(49, 'Магаданская область', 0, 0, '', '', 0, 19, 4),
(13, 'Республика Мордовия', 1, 38, 'Mordovia', 'mordovia.yabloko.ru', 0, 61, 7),
(50, 'Московская область', 1, 31, 'Mosobl', 'mosobl.yabloko.ru', 1, 53, 1),
(1, 'Республика Адыгея', 1, 233, 'Adygeya', '', 0, 74, 2),
(3, 'Республика Башкортостан', 1, 24, 'Bashkiria', 'bash.yabloko.ru', 1, 41, 5),
(2, 'Республика Алтай', 1, 48, 'Resp_Altai', '', 0, 31, 7),
(5, 'Республика Дагестан', 1, 170, 'Dagestan', 'dagestan.yabloko.ru', 1, 81, 8),
(11, 'Республика Коми', 1, 322, 'Komi', '', 0, 10, 3),
(12, 'Республика Марий Эл', 1, 323, 'Mari-el', '', 0, 49, 7),
(14, 'Республика Саха (Якутия)', 1, 324, 'Yakutia', '', 0, 18, 4),
(15, 'Республика Северная Осетия', 1, 69, 'severnaya_osetiya', '', 0, 79, 8),
(16, 'Республика Татарстан', 1, 33, 'Tatarstan', 'tat.yabloko.ru', 0, 44, 7),
(17, 'Республика Тыва', 1, 268, 'Tuva', '', 0, 30, 5),
(18, 'Удмуртская Республика', 1, 267, 'Udmurtia', 'yabloko18.ru', 1, 43, 7),
(19, 'Республика Хакасия', 1, 325, 'Hakasiya', '', 0, 84, 5),
(20, 'Чеченская Республика', 1, 266, 'Chechnya', '', 0, 80, 8),
(21, 'Чувашская Республика', 1, 199, 'chuvashiya', 'chuvashia.yabloko.ru', 1, 48, 7),
(25, 'Приморский край', 1, 232, 'primorye', 'primorye.yabloko.ru', 0, 23, 4),
(26, 'Ставропольский край', 1, 61, 'Stavropol', 'stavropol.yabloko.ru', 1, 76, 8),
(27, 'Хабаровский край', 1, 19, 'Habarovsk', 'khb.yabloko.ru', 1, 22, 4),
(52, 'Нижегородская область', 1, 26, 'NNov', 'nn.yabloko.ru', 1, 50, 7),
(53, 'Новгородская область', 1, 311, 'Novgorod', 'vnovgorod-yabloko.ru', 1, 4, 3),
(54, 'Новосибирская область', 1, 25, 'Novosib', 'yablokosibir.ru', 1, 34, 5),
(55, 'Омская область', 1, 36, 'Omsk', 'omsk.yabloko.ru', 1, 36, 5),
(56, 'Оренбургская область', 1, 157, 'orenburg', 'orenburg.yabloko.ru', 0, 42, 7),
(57, 'Орловская область', 1, 258, 'Orel', '', 0, 65, 1),
(58, 'Пензенская область', 1, 71, 'Penza', 'penza.yabloko.ru', 1, 62, 7),
(59, 'Пермский край', 1, 63, 'Perm', 'perm.yabloko.ru', 0, 13, 7),
(60, 'Псковская область', 1, 17, 'Pskov', 'pskov.yabloko.ru', 1, 2, 3),
(61, 'Ростовская область', 1, 171, 'Rostov', '', 0, 70, 2),
(62, 'Рязанская область', 1, 23, 'Ryazan', 'ryazan.yabloko.ru', 1, 60, 1),
(63, 'Самарская область', 1, 55, 'samara', 'samara.yabloko.ru', 0, 45, 7),
(64, 'Саратовская область', 1, 18, 'Saratov', 'yabloko-saratov.ru', 0, 46, 7),
(65, 'Сахалинская область', 1, 270, 'Sakhalin', 'sakhalin.yabloko.ru', 0, 24, 4),
(66, 'Свердловская область', 1, 34, 'Ekb', 'ekb.yabloko.ru', 1, 39, 6),
(67, 'Смоленская область', 1, 64, 'Smolensk', 'smolensk.yabloko.ru', 0, 54, 1),
(68, 'Тамбовская область', 1, 29, 'Tambov', 'tambov.yabloko.ru', 1, 63, 1),
(69, 'Тверская область', 1, 22, 'Tver', 'tver.yabloko.ru', 1, 55, 1),
(70, 'Томская область', 1, 28, 'Tomsk', 'tomsk.yabloko.ru', 0, 35, 5),
(71, 'Тульская область', 1, 21, 'Tula', 'yatula.org', 0, 59, 1),
(72, 'Тюменская область', 1, 321, 'Tyumen', '72.yabloko.ru', 0, 37, 6),
(73, 'Ульяновская область', 1, 264, 'Ulyanovsk', '', 0, 47, 7),
(74, 'Челябинская область', 1, 16, 'Chel', 'chel.yabloko.ru', 1, 40, 6),
(75, 'Забайкальский край', 1, 158, 'chita', 'chita.yabloko.ru', 0, 27, 5),
(76, 'Ярославская область', 1, 67, 'yaroslavl', 'yaroslavl.yabloko.ru', 0, 56, 1),
(86, 'Ханты-Мансийский автономный округ', 1, 319, 'HMAO', '', 0, 15, 6),
(87, 'Чукотский автономный округ', 0, 0, '', '', 0, 20, 4),
(89, 'Ямало-Ненецкий автономный округ', 0, 0, '', '', 0, 16, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
