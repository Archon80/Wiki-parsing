-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 25 2016 г., 00:33
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Articles table' AUTO_INCREMENT=62 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id_article`, `name`, `content`, `link`, `size`, `count`) VALUES
(60, 'СТАТЬЯ О C++', 'Ну а здесь речь пойдет о более мощном языке программирования - С++.\nМы расскажем о нем очень многое, потому что мы молодцы мы да мы.', 'temp', 256, 24),
(61, 'СТАТЬЯ О PHP', 'В данной статье мы будем очень долго говорить о PHP.', 'temp', 113, 10);

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

--
-- Дамп данных таблицы `articles_words`
--

INSERT INTO `articles_words` (`id_article`, `id_word`, `count`) VALUES
(60, 312, 1),
(60, 313, 1),
(60, 314, 1),
(60, 315, 1),
(60, 316, 1),
(60, 317, 2),
(60, 318, 1),
(60, 319, 1),
(60, 320, 1),
(60, 321, 1),
(60, 322, 1),
(60, 323, 1),
(60, 324, 1),
(60, 325, 1),
(60, 326, 1),
(60, 327, 1),
(60, 328, 1),
(60, 329, 1),
(60, 330, 3),
(60, 331, 1),
(60, 332, 1),
(61, 333, 1),
(61, 334, 1),
(61, 335, 1),
(61, 336, 1),
(61, 337, 1),
(61, 338, 1),
(61, 339, 1),
(61, 340, 1),
(61, 341, 1),
(61, 342, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `id_word` int(5) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) NOT NULL,
  PRIMARY KEY (`id_word`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Words table' AUTO_INCREMENT=343 ;

--
-- Дамп данных таблицы `words`
--

INSERT INTO `words` (`id_word`, `word`) VALUES
(312, 'Ну'),
(313, 'а'),
(314, 'здесь'),
(315, 'речь'),
(316, 'пойдет'),
(317, 'о'),
(318, 'более'),
(319, 'мощном'),
(320, 'языке'),
(321, 'программирования'),
(322, ''),
(323, 'С\nМы'),
(324, 'расскажем'),
(325, 'нем'),
(326, 'очень'),
(327, 'многое'),
(328, 'потому'),
(329, 'что'),
(330, 'мы'),
(331, 'молодцы'),
(332, 'да'),
(333, 'В'),
(334, 'данной'),
(335, 'статье'),
(336, 'мы'),
(337, 'будем'),
(338, 'очень'),
(339, 'долго'),
(340, 'говорить'),
(341, 'о'),
(342, 'php');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
