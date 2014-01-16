-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 16 2014 г., 18:51
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
  `vin` varchar(100) NOT NULL COMMENT 'vin of a car',
  `registration_number` varchar(100) NOT NULL COMMENT 'car registration number',
  `owner_id` mediumint(9) unsigned NOT NULL COMMENT 'owner id',
  `model_id` smallint(5) unsigned NOT NULL COMMENT 'car model id',
  `registered_date` date NOT NULL COMMENT 'registration date',
  `year` date NOT NULL COMMENT 'format Y-m-d',
  `milage` mediumint(9) NOT NULL COMMENT 'integer number total milage in km',
  `daily_milage` smallint(6) NOT NULL COMMENT 'integer number of daily milage in km',
  `more_info` text NOT NULL COMMENT 'more info',
  `milage_date` date NOT NULL COMMENT 'When milage was last updated',
  `when_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `regnum` (`registration_number`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `vin` (`vin`),
  KEY `owner_id` (`owner_id`),
  KEY `when_updated` (`when_updated`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `vin`, `registration_number`, `owner_id`, `model_id`, `registered_date`, `year`, `milage`, `daily_milage`, `more_info`, `milage_date`, `when_updated`) VALUES
(8, 'KLAF69ZEV012345', 'F121XA', 2, 1, '2013-12-10', '2013-08-10', 3001, 14, 'Новенькая', '2014-01-15', '2014-01-16 18:00:53'),
(6, 'AZAF69ZEV016666', 'F312TA', 2, 2, '2013-12-13', '2010-01-12', 50204, 15, 'Белая, двигатель изношен', '2014-01-15', '2014-01-16 18:00:53'),
(5, 'FGFF69ZEV017877', 'F321BA', 3, 4, '2013-10-24', '2011-12-01', 20000, 10, 'Красного цвета в хорошем состоянии', '2013-10-24', '2014-01-16 18:03:34'),
(7, 'WZAF69ZEV012567', 'X820BA', 1, 3, '2013-12-12', '2013-04-21', 10000, 10, 'Цвет салатовый, в хорошем состоянии', '2013-12-12', '2014-01-16 18:03:34');

-- --------------------------------------------------------

--
-- Структура таблицы `car_brands`
--

CREATE TABLE IF NOT EXISTS `car_brands` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) NOT NULL COMMENT 'Brand name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `car_brands`
--

INSERT INTO `car_brands` (`id`, `name`) VALUES
(1, 'Chevrolet');

-- --------------------------------------------------------

--
-- Структура таблицы `car_models`
--

CREATE TABLE IF NOT EXISTS `car_models` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` tinyint(3) unsigned NOT NULL COMMENT 'Brand id',
  `name` varchar(50) NOT NULL COMMENT 'Model-MYYYY format',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `car_models`
--

INSERT INTO `car_models` (`id`, `brand_id`, `name`) VALUES
(1, 1, 'Lacetti седан 2013'),
(2, 1, 'Nexia 2009'),
(3, 1, 'Spark 2013'),
(4, 1, 'Matiz Best 2011');

-- --------------------------------------------------------

--
-- Структура таблицы `car_services`
--

CREATE TABLE IF NOT EXISTS `car_services` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `service` varchar(255) NOT NULL COMMENT 'service name',
  `more_info` text NOT NULL COMMENT 'more info about service',
  `when_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carservice` (`service`),
  KEY `when_updated` (`when_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `car_services`
--

INSERT INTO `car_services` (`id`, `service`, `more_info`, `when_updated`) VALUES
(19, 'Аккумулятор', 'Замена', '0000-00-00 00:00:00'),
(20, 'Амортизаторы', 'Замена', '0000-00-00 00:00:00'),
(21, 'Воздушный фильтр', 'Замена', '0000-00-00 00:00:00'),
(22, 'Давление в Шинах', 'Проверка', '0000-00-00 00:00:00'),
(23, 'Другое', 'Виды услуг', '0000-00-00 00:00:00'),
(24, 'Замена тормозов', 'Замена', '0000-00-00 00:00:00'),
(25, 'Масляный Фильтр', 'Замена', '0000-00-00 00:00:00'),
(26, 'Осмотр', 'Комплексный', '0000-00-00 00:00:00'),
(27, 'Замена Масла двигателя', 'Замена', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment id',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL COMMENT 'full name of the owner',
  `contact_email` varchar(255) NOT NULL COMMENT 'contact email',
  `contact_phone` varchar(255) NOT NULL COMMENT 'contact phone numbers',
  `registered_date` date NOT NULL COMMENT 'start date of using services',
  `more_info` text NOT NULL COMMENT 'more information',
  `notification_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Client status to recieve reminders, 0 is no',
  `when_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fullname` (`fullname`,`registered_date`),
  KEY `when_updated` (`when_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `username`, `password`, `fullname`, `contact_email`, `contact_phone`, `registered_date`, `more_info`, `notification_status`, `when_updated`) VALUES
(1, 'anvar', '$2a$08$GXcxPDochIra7bvNvvjSYe8RnmGvGSHM0FeIFjfi4aiOD80bbpeoy', 'Анвар Анваров', 'exmpl@mail.com', '(99893) 567-12-32', '2013-12-12', 'Матиз, цвет салат "X 820 BA"', 0, '0000-00-00 00:00:00'),
(2, 'valentin', '$2a$08$xn0TpNtbbpqNGxlnElV95emMw/DE5f7BvG/OXwlyUT4PVKXqCNhQi', 'Валентин Ан', 'mail7@gmail.ru', '(99893) 567-12-35', '2013-12-13', 'Белая', 1, '2014-01-15 14:32:46'),
(3, 'sanjar', '$2a$08$FMa2OMhYX1e5xPyWstG1EuhxGLRwZqzcAtoME8ZO9JLSnolWMHCFm', 'Санжар Абдурахманов', 'mail@g.ru', '(99890) 124-96-01', '2013-10-24', 'Shkoda, красная "F321BA"', 0, '0000-00-00 00:00:00');

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
  `more_info` text NOT NULL COMMENT 'Additional information',
  `works_since` date NOT NULL COMMENT 'Started working',
  `when_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  KEY `when_updated` (`when_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `role_id`, `fullname`, `job`, `contacts`, `more_info`, `works_since`, `when_updated`) VALUES
(9, 'mirodil', '$2a$08$GhZN5HJ5g47aSIymoRiPXufcilZit0ThOgZAS4AtKjj/DfIR3VqCe', 2, 'Миродил Мирзахмедов', 'Директор', '(99893) 395-96-52', 'Доп. информация', '2013-07-26', '0000-00-00 00:00:00'),
(10, 'dima', '$2a$08$fUnEBwUBR6rUrrajyBvIuu8rbdjlYCkxHc/glyIUBMXOFtjvoLGRe', 3, 'Дима Д', 'Механик', '(99893) 125-54-12', 'Доп. информация', '2013-07-30', '0000-00-00 00:00:00'),
(11, 'mahmud', '$2a$08$JsOaRYJ6nTXBrkbrCShgiO0uLBs1n1/rJU05CZ3w1.Ymux3Om.hke', 4, 'Махмуд М', 'Механик', '(99890) 125-95-47', 'Доп. информация', '2013-07-30', '0000-00-00 00:00:00'),
(13, 'iamadmin', '$2a$08$nEXNW2UOq7qP88kKkc2xCOwG3SSBqHQZQevOaScguWTWa200QiBJK', 1, 'Incognito', 'Admin', 'ss@ss.ss', 'Some data', '2014-01-08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `maintenance_schedule`
--

CREATE TABLE IF NOT EXISTS `maintenance_schedule` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` smallint(5) unsigned NOT NULL COMMENT 'model it related to',
  `configuration` varchar(7000) NOT NULL COMMENT 'Serialized php array of schedule',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `provided_services`
--

CREATE TABLE IF NOT EXISTS `provided_services` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `car_id` mediumint(9) unsigned NOT NULL COMMENT 'car id',
  `service_id` tinyint(4) unsigned NOT NULL COMMENT 'work id',
  `master_id` smallint(6) unsigned NOT NULL COMMENT 'master id',
  `start_date` date NOT NULL COMMENT 'date of work started',
  `finish_date` date NOT NULL COMMENT 'date of work finished',
  `milage` mediumint(9) NOT NULL COMMENT 'car milage on a date of service in km',
  `remind_date` date NOT NULL COMMENT 'remind at x date',
  `remind_km` mediumint(9) unsigned NOT NULL COMMENT 'remind after x km',
  `remind_status` tinyint(1) NOT NULL COMMENT '1 or 0, yes or no if already reminded service provided',
  `more_info` text NOT NULL COMMENT 'more info',
  `when_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`,`service_id`,`master_id`),
  KEY `work_id` (`service_id`),
  KEY `master_id` (`master_id`),
  KEY `remind` (`remind_status`),
  KEY `when_updated` (`when_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `provided_services`
--

INSERT INTO `provided_services` (`id`, `car_id`, `service_id`, `master_id`, `start_date`, `finish_date`, `milage`, `remind_date`, `remind_km`, `remind_status`, `more_info`, `when_updated`) VALUES
(1, 6, 19, 11, '2013-12-14', '2013-12-15', 50000, '2014-12-15', 10000, 1, 'Good quality korean battery installed', '0000-00-00 00:00:00'),
(2, 6, 20, 10, '2013-12-14', '2013-12-14', 50000, '2014-06-20', 200, 1, 'Настройка', '0000-00-00 00:00:00'),
(3, 6, 27, 11, '2013-12-15', '2013-12-15', 50000, '2014-06-15', 5000, 1, 'Синтетика', '0000-00-00 00:00:00'),
(4, 5, 21, 10, '2013-10-24', '2013-10-24', 20000, '2030-00-00', 3000, 1, 'Доп. информация', '0000-00-00 00:00:00'),
(5, 5, 22, 10, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 5000, 1, 'Доп. информация', '0000-00-00 00:00:00'),
(6, 5, 25, 10, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 3000, 1, 'Доп. информация', '0000-00-00 00:00:00'),
(7, 5, 27, 10, '2013-10-24', '2013-10-24', 20000, '2014-06-15', 3000, 1, 'Доп. информация', '0000-00-00 00:00:00'),
(8, 7, 24, 10, '2013-12-12', '2013-12-12', 10000, '2014-12-12', 5000, 1, 'Доп. информация', '0000-00-00 00:00:00'),
(9, 8, 27, 10, '2013-12-12', '2013-12-14', 2100, '2014-06-12', 3000, 1, '', '0000-00-00 00:00:00'),
(10, 8, 26, 11, '2013-12-20', '2013-12-20', 2500, '2014-01-07', 200, 1, 'Нужен осмотр', '0000-00-00 00:00:00'),
(11, 8, 22, 11, '2013-12-12', '2013-12-12', 2100, '2013-12-22', 150, 0, 'Давление нормальное', '0000-00-00 00:00:00'),
(12, 6, 22, 10, '2013-12-16', '2013-12-17', 50100, '2014-01-14', 50, 0, 'Filter from Ztech korea', '0000-00-00 00:00:00'),
(13, 6, 24, 10, '2013-12-16', '2013-12-17', 50100, '2014-02-20', 3000, 1, 'Syntetics', '0000-00-00 00:00:00'),
(14, 6, 23, 10, '2014-01-01', '2014-01-01', 50110, '2014-01-10', 2000, 1, 'Проверка электроники', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'auto increment',
  `role` varchar(255) NOT NULL COMMENT 'Role defines access level',
  `more_info` varchar(255) NOT NULL COMMENT 'Short description',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`, `more_info`) VALUES
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
  ADD CONSTRAINT `cars_ibfk_3` FOREIGN KEY (`model_id`) REFERENCES `car_models` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `car_models_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `car_brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `provided_services`
--
ALTER TABLE `provided_services`
  ADD CONSTRAINT `provided_services_ibfk_2` FOREIGN KEY (`master_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `provided_services_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `provided_services_ibfk_4` FOREIGN KEY (`service_id`) REFERENCES `car_services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
