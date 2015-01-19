-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Січ 19 2015 р., 08:54
-- Версія сервера: 5.6.21
-- Версія PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: `movie_db`
--

-- --------------------------------------------------------

--
-- Структура таблиці `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `year` int(10) unsigned NOT NULL,
  `format` set('VHS','DVD','Blu-Ray') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `movie_star`
--

CREATE TABLE IF NOT EXISTS `movie_star` (
`id` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `id_star` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=609 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `stars`
--

CREATE TABLE IF NOT EXISTS `stars` (
`id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `movies`
--
ALTER TABLE `movies`
 ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `movie_star`
--
ALTER TABLE `movie_star`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_movie` (`id_movie`,`id_star`);

--
-- Індекси таблиці `stars`
--
ALTER TABLE `stars`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `first_name` (`first_name`,`last_name`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `movies`
--
ALTER TABLE `movies`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT для таблиці `movie_star`
--
ALTER TABLE `movie_star`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=609;
--
-- AUTO_INCREMENT для таблиці `stars`
--
ALTER TABLE `stars`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=313;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
