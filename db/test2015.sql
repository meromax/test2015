-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 13 2015 г., 00:17
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test2015`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `title`) VALUES
(1, 'Минск'),
(2, 'Москва'),
(3, 'Брест'),
(4, 'Киев'),
(5, 'Вильнюс'),
(6, 'Литва'),
(7, 'Варшава'),
(8, 'Могилев');

-- --------------------------------------------------------

--
-- Структура таблицы `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `education`
--

INSERT INTO `education` (`id`, `title`) VALUES
(1, 'Бакалавр'),
(2, 'Магистр'),
(3, 'Кандидат наук'),
(4, 'Доктор наук');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'Иван Иванов'),
(2, 'Алексей Петров'),
(3, 'Регина Марковна'),
(4, 'Петр Леонидович'),
(5, 'Анастасия петровна'),
(6, 'Арнольд Федорович'),
(7, 'Леонид Арнольдович'),
(8, 'Равшан Джумшутавич'),
(9, 'Галина Федоровна');

-- --------------------------------------------------------

--
-- Структура таблицы `users_cities`
--

DROP TABLE IF EXISTS `users_cities`;
CREATE TABLE IF NOT EXISTS `users_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `users_cities`
--

INSERT INTO `users_cities` (`id`, `user_id`, `city_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 3),
(5, 3, 1),
(6, 4, 4),
(7, 5, 5),
(8, 6, 6),
(9, 7, 7),
(10, 7, 1),
(11, 8, 1),
(12, 8, 6),
(13, 8, 3),
(14, 9, 2),
(15, 9, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `users_education`
--

DROP TABLE IF EXISTS `users_education`;
CREATE TABLE IF NOT EXISTS `users_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `education_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `users_education`
--

INSERT INTO `users_education` (`id`, `user_id`, `education_id`) VALUES
(1, 1, 3),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 2),
(6, 6, 3),
(7, 7, 2),
(8, 8, 3),
(9, 9, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
