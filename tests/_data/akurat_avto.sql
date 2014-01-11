-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 11 2014 г., 11:54
-- Версия сервера: 5.5.24-log
-- Версия PHP: 5.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `akurat_avto`
--
CREATE DATABASE IF NOT EXISTS `akurat_avto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `akurat_avto`;

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `regnum` varchar(100) NOT NULL COMMENT 'car registration number',
  `owner_id` mediumint(9) unsigned NOT NULL COMMENT 'owner id',
  `model` varchar(255) NOT NULL COMMENT 'car model',
  `bodynumber` varchar(255) NOT NULL COMMENT 'car body number',
  `enginenumber` varchar(255) NOT NULL COMMENT 'car engine number',
  `regdate` date NOT NULL COMMENT 'registration date',
  `year` year(4) NOT NULL COMMENT 'year in xx or xxxx format',
  `milage` mediumint(9) NOT NULL COMMENT 'integer number total milage in km',
  `dailymilage` smallint(6) NOT NULL COMMENT 'integer number of daily milage in km',
  `moreinfo` text NOT NULL COMMENT 'more info',
  `mlgdate` date NOT NULL COMMENT 'When milage was last updated',
  PRIMARY KEY (`id`),
  UNIQUE KEY `regnum` (`regnum`),
  UNIQUE KEY `id` (`id`),
  KEY `model` (`model`,`bodynumber`,`enginenumber`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `regnum`, `owner_id`, `model`, `bodynumber`, `enginenumber`, `regdate`, `year`, `milage`, `dailymilage`, `moreinfo`, `mlgdate`) VALUES
(5, 'F321BA', 3, 'Skoda', '481094329809', '213340957806', '2013-10-24', 2009, 20000, 10, 'Красного цвета в хорошем состоянии', '0000-00-00'),
(6, 'F312TA', 2, 'Нексия', '3214892347907', '9812310473210', '2013-12-13', 2007, 50201, 17, 'Белая, двигатель изношен', '2014-01-11'),
(7, 'X820BA', 1, 'Матиз', '3479870348987', '8921743287432', '2013-12-12', 2011, 10000, 10, 'Цвет салатовый, в хорошем состоянии', '0000-00-00'),
(8, 'F121XA', 2, 'Lacetti', '34546786535', '12354354656', '2013-12-10', 2013, 3000, 13, 'Новенькая', '2014-01-09');

-- --------------------------------------------------------

--
-- Структура таблицы `carservices`
--

CREATE TABLE IF NOT EXISTS `carservices` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `carservice` varchar(255) NOT NULL COMMENT 'service name',
  `moreinfo` text NOT NULL COMMENT 'more info about service',
  PRIMARY KEY (`id`),
  UNIQUE KEY `carservice` (`carservice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `carservices`
--

INSERT INTO `carservices` (`id`, `carservice`, `moreinfo`) VALUES
(19, 'Аккумулятор', 'Замена'),
(20, 'Амортизаторы', 'Замена'),
(21, 'Воздушный фильтр', 'Замена'),
(22, 'Давление в Шинах', 'Проверка'),
(23, 'Другое', 'Виды услуг'),
(24, 'Замена тормозов', 'Замена'),
(25, 'Масляный Фильтр', 'Замена'),
(26, 'Осмотр', 'Комплексный'),
(27, 'Замена Масла двигателя', 'Замена');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment id',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL COMMENT 'full name of the owner',
  `contactemail` varchar(255) NOT NULL COMMENT 'contact email',
  `contactphone` varchar(255) NOT NULL COMMENT 'contact phone numbers',
  `regdate` date NOT NULL COMMENT 'start date of using services',
  `moreinfo` text NOT NULL COMMENT 'more information',
  `remind` tinyint(1) NOT NULL COMMENT 'Client status to recieve reminders, 0 is no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fullname` (`fullname`,`regdate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `username`, `password`, `fullname`, `contactemail`, `contactphone`, `regdate`, `moreinfo`, `remind`) VALUES
(1, 'anvar', '$2a$08$GXcxPDochIra7bvNvvjSYe8RnmGvGSHM0FeIFjfi4aiOD80bbpeoy', 'Анвар Анваров', 'exmpl@mail.com', '(99893) 567-12-32', '2013-12-12', 'Матиз, цвет салат "X 820 BA"', 0),
(2, 'valentin', '$2a$08$gMOad4plEGMKHcgpT4aVMORqhZruew0FgZHAQq.zW5bU1tVcPX7jW', 'Валентин Ан', 'mail7@gmail.ru', '(99893) 567-12-36', '2013-12-13', 'Нексия, белая "F 312 TA"', 1),
(3, 'sanjar', '$2a$08$FMa2OMhYX1e5xPyWstG1EuhxGLRwZqzcAtoME8ZO9JLSnolWMHCFm', 'Санжар Абдурахманов', 'mail@g.ru', '(99890) 124-96-01', '2013-10-24', 'Shkoda, красная "F321BA"', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto incremental id',
  `username` varchar(255) NOT NULL COMMENT 'Unique username for login',
  `password` varchar(255) NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL COMMENT 'Role id',
  `fullname` varchar(255) NOT NULL COMMENT 'first, middle and last name',
  `job` varchar(255) NOT NULL COMMENT 'Job title / description',
  `contacts` text NOT NULL COMMENT 'Contant data',
  `moreinfo` text NOT NULL COMMENT 'Additional information',
  `date` date NOT NULL COMMENT 'Started working',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `role_id`, `fullname`, `job`, `contacts`, `moreinfo`, `date`) VALUES
(9, 'mirodil', '$2a$08$GhZN5HJ5g47aSIymoRiPXufcilZit0ThOgZAS4AtKjj/DfIR3VqCe', 2, 'Миродил Мирзахмедов', 'Директор', '(99893) 395-96-52', 'Доп. информация', '2013-07-26'),
(10, 'dima', '$2a$08$fUnEBwUBR6rUrrajyBvIuu8rbdjlYCkxHc/glyIUBMXOFtjvoLGRe', 3, 'Дима Д', 'Механик', '(99893) 125-54-12', 'Доп. информация', '2013-07-30'),
(11, 'mahmud', '$2a$08$JsOaRYJ6nTXBrkbrCShgiO0uLBs1n1/rJU05CZ3w1.Ymux3Om.hke', 4, 'Махмуд М', 'Механик', '(99890) 125-95-47', 'Доп. информация', '2013-07-30'),
(13, 'iamadmin', '$2a$08$nEXNW2UOq7qP88kKkc2xCOwG3SSBqHQZQevOaScguWTWa200QiBJK', 1, 'Incognito', 'Admin', 'ss@ss.ss', 'Some data', '2014-01-08');

-- --------------------------------------------------------

--
-- Структура таблицы `providedservices`
--

CREATE TABLE IF NOT EXISTS `providedservices` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `car_id` mediumint(9) unsigned NOT NULL COMMENT 'car id',
  `work_id` tinyint(4) unsigned NOT NULL COMMENT 'work id',
  `master_id` smallint(6) unsigned NOT NULL COMMENT 'master id',
  `cost` mediumint(9) unsigned NOT NULL COMMENT 'cost of service',
  `startdate` date NOT NULL COMMENT 'date of work started',
  `finishdate` date NOT NULL COMMENT 'date of work finished',
  `milage` mediumint(9) NOT NULL COMMENT 'car milage on a date of service in km',
  `reminddate` date NOT NULL COMMENT 'remind at x date',
  `remindkm` mediumint(9) unsigned NOT NULL COMMENT 'remind after x km',
  `remind` tinyint(1) NOT NULL COMMENT '1 or 0, yes or no if already reminded service provided',
  `moreinfo` text NOT NULL COMMENT 'more info',
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`,`work_id`,`master_id`),
  KEY `work_id` (`work_id`),
  KEY `master_id` (`master_id`),
  KEY `remind` (`remind`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `providedservices`
--

INSERT INTO `providedservices` (`id`, `car_id`, `work_id`, `master_id`, `cost`, `startdate`, `finishdate`, `milage`, `reminddate`, `remindkm`, `remind`, `moreinfo`) VALUES
(1, 6, 19, 11, 120000, '2013-12-14', '2013-12-15', 50000, '2014-12-15', 10000, 1, 'Good quality korean battery installed'),
(2, 6, 20, 10, 50000, '2013-12-14', '2013-12-14', 50000, '2014-06-20', 200, 1, 'Настройка'),
(3, 6, 27, 11, 30000, '2013-12-15', '2013-12-15', 50000, '2014-06-15', 5000, 1, 'Синтетика'),
(4, 5, 21, 10, 20000, '2013-10-24', '2013-10-24', 20000, '2030-00-00', 3000, 1, 'Доп. информация'),
(5, 5, 22, 10, 5000, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 5000, 1, 'Доп. информация'),
(6, 5, 25, 10, 20000, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 3000, 1, 'Доп. информация'),
(7, 5, 27, 10, 35000, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 3000, 1, 'Доп. информация'),
(8, 7, 24, 10, 50000, '2013-12-12', '2013-12-12', 10000, '2014-12-12', 5000, 1, 'Доп. информация'),
(9, 8, 27, 10, 20000, '2013-12-12', '2013-12-14', 2100, '2014-06-12', 3000, 1, ''),
(10, 8, 26, 11, 15000, '2013-12-20', '2013-12-20', 2500, '2014-01-07', 200, 1, 'Нужен осмотр'),
(11, 8, 22, 11, 10000, '2013-12-12', '2013-12-12', 2100, '2013-12-22', 150, 0, 'Давление нормальное'),
(12, 6, 22, 10, 25000, '2013-12-16', '2013-12-17', 50100, '2014-01-14', 50, 0, 'Filter from Ztech korea'),
(13, 6, 24, 10, 50000, '2013-12-16', '2013-12-17', 50100, '2014-02-20', 3000, 1, 'Syntetics'),
(14, 6, 23, 10, 45000, '2014-01-01', '2014-01-01', 50110, '2014-01-10', 2000, 1, 'Проверка электроники');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `role` varchar(255) NOT NULL COMMENT 'Role defines access level',
  `moreinfo` varchar(255) NOT NULL COMMENT 'Short description',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`, `moreinfo`) VALUES
(1, 'Admin', 'Admin has full access'),
(2, 'Boss', 'Boss of employees and has full non technical access'),
(3, 'Master', 'Master has access personal data and can alter users data'),
(4, 'Employee', 'Employee has access to general user data and own account'),
(5, 'Client', 'Client has access to public data and own account');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `providedservices`
--
ALTER TABLE `providedservices`
  ADD CONSTRAINT `providedservices_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `carservices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `providedservices_ibfk_2` FOREIGN KEY (`master_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `providedservices_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
