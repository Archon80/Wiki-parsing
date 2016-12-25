-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 25 2016 г., 23:11
-- Версия сервера: 5.5.53-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `CUBA`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Articles table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `articles_words`
--

CREATE TABLE IF NOT EXISTS `articles_words` (
  `id_article` int(5) NOT NULL,
  `id_word` int(5) NOT NULL,
  `count` int(5) DEFAULT NULL,
  UNIQUE KEY `article_word` (`id_article`,`id_word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Articles_words table';

-- --------------------------------------------------------

--
-- Структура таблицы `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `id_word` int(5) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) NOT NULL,
  PRIMARY KEY (`id_word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Words table' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
