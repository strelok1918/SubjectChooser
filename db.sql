-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.41-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных discipline_chooser
CREATE DATABASE IF NOT EXISTS `discipline_chooser` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `discipline_chooser`;


-- Дамп структуры для таблица discipline_chooser.AttributeMapping
CREATE TABLE IF NOT EXISTS `AttributeMapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_type_id` int(11) DEFAULT NULL,
  `object_id` int(11) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `FK_AttributeMapping_AttributeType` (`attribute_type_id`),
  CONSTRAINT `FK_AttributeMapping_AttributeType` FOREIGN KEY (`attribute_type_id`) REFERENCES `AttributeType` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_AttributeMapping_Objects` FOREIGN KEY (`object_id`) REFERENCES `Objects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.AttributeMapping: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `AttributeMapping` DISABLE KEYS */;
REPLACE INTO `AttributeMapping` (`id`, `attribute_type_id`, `object_id`, `value`) VALUES
	(1, 1, 1, 'Малютин'),
	(2, 2, 1, '2'),
	(3, 1, 2, 'Кто-то'),
	(4, 2, 2, '3');
/*!40000 ALTER TABLE `AttributeMapping` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.AttributeType
CREATE TABLE IF NOT EXISTS `AttributeType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `type` varchar(50) NOT NULL DEFAULT '0',
  `is_visible` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.AttributeType: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `AttributeType` DISABLE KEYS */;
REPLACE INTO `AttributeType` (`id`, `title`, `type`, `is_visible`) VALUES
	(1, 'Преподаватель', 'text', b'1'),
	(2, 'Курс', 'text', b'1');
/*!40000 ALTER TABLE `AttributeType` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.CustomValidators
CREATE TABLE IF NOT EXISTS `CustomValidators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `action` varchar(2) NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CustomValidators_Objects` (`object_id`),
  CONSTRAINT `FK_CustomValidators_Objects` FOREIGN KEY (`object_id`) REFERENCES `Objects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.CustomValidators: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `CustomValidators` DISABLE KEYS */;
REPLACE INTO `CustomValidators` (`id`, `object_id`, `action`, `value`) VALUES
	(1, 1, '01', '(SELECT count(*) FROM StudentsSubjects WHERE object_id = 1) > 0'),
	(2, 2, '0', '(SELECT count(*)  FROM Users WHERE id = 2) > 3'),
	(3, 1, '11', 'sdfasfd'),
	(4, 1, '01', 'adfadfa');
/*!40000 ALTER TABLE `CustomValidators` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.DataTypes
CREATE TABLE IF NOT EXISTS `DataTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.DataTypes: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `DataTypes` DISABLE KEYS */;
REPLACE INTO `DataTypes` (`id`, `type`, `title`) VALUES
	(1, 'text', 'Текст');
/*!40000 ALTER TABLE `DataTypes` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.Groups
CREATE TABLE IF NOT EXISTS `Groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.Groups: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `Groups` DISABLE KEYS */;
REPLACE INTO `Groups` (`id`, `title`) VALUES
	(5, 'ИН-01'),
	(6, 'ИНм-41');
/*!40000 ALTER TABLE `Groups` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.ObjectOwners
CREATE TABLE IF NOT EXISTS `ObjectOwners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ObjectOwners_Objects` (`object_id`),
  KEY `FK_ObjectOwners_Users` (`owner_id`),
  CONSTRAINT `FK_ObjectOwners_Objects` FOREIGN KEY (`object_id`) REFERENCES `Objects` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_ObjectOwners_Users` FOREIGN KEY (`owner_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.ObjectOwners: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `ObjectOwners` DISABLE KEYS */;
REPLACE INTO `ObjectOwners` (`id`, `object_id`, `owner_id`) VALUES
	(15, 2, 3),
	(25, 1, 1);
/*!40000 ALTER TABLE `ObjectOwners` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.Objects
CREATE TABLE IF NOT EXISTS `Objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.Objects: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `Objects` DISABLE KEYS */;
REPLACE INTO `Objects` (`id`, `title`) VALUES
	(1, 'Математический анализ'),
	(2, 'Культурология');
/*!40000 ALTER TABLE `Objects` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.StudentsSubjects
CREATE TABLE IF NOT EXISTS `StudentsSubjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_object_id_year_semester` (`user_id`,`object_id`,`year`,`semester`),
  KEY `FK_StudentsSubjects_Objects` (`object_id`),
  CONSTRAINT `FK_StudentsSubjects_Objects` FOREIGN KEY (`object_id`) REFERENCES `Objects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_StudentsSubjects_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.StudentsSubjects: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `StudentsSubjects` DISABLE KEYS */;
REPLACE INTO `StudentsSubjects` (`id`, `user_id`, `object_id`, `year`, `semester`) VALUES
	(35, 1, 1, 2015, 1),
	(39, 1, 2, 2017, 1),
	(38, 3, 2, 2016, 2);
/*!40000 ALTER TABLE `StudentsSubjects` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.Users
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('Admin','User','Moderator') NOT NULL,
  `acquisition_year` year(4) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `mail` (`mail`),
  KEY `FK_Users_Groups` (`group`),
  KEY `FK_Users_Roles` (`role`),
  CONSTRAINT `groupRel` FOREIGN KEY (`group`) REFERENCES `Groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.Users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
REPLACE INTO `Users` (`id`, `role`, `acquisition_year`, `login`, `mail`, `password`, `first_name`, `second_name`, `group`) VALUES
	(1, 'Admin', '2005', 'marchenko', 's@ya.r', '12345', 'Igor', 'Marchenko', 5),
	(3, 'Moderator', '2010', 'petrov', 'serg_pet@gmail.com', '12345', 'Sergey', 'Petrov', 5),
	(115, 'User', '2005', 'strelok1', 's@ya.ru1', '12345', 'Igor', 'Marchenko', NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.ValidatorMapping
CREATE TABLE IF NOT EXISTS `ValidatorMapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `validator_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `FK_ValidatorMapping_Validators` (`validator_id`),
  CONSTRAINT `FK_ValidatorMapping_Objects` FOREIGN KEY (`object_id`) REFERENCES `Objects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_ValidatorMapping_Validators` FOREIGN KEY (`validator_id`) REFERENCES `Validators` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.ValidatorMapping: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ValidatorMapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `ValidatorMapping` ENABLE KEYS */;


-- Дамп структуры для таблица discipline_chooser.Validators
CREATE TABLE IF NOT EXISTS `Validators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Validators_AttributeType` (`attribute_id`),
  CONSTRAINT `FK_Validators_AttributeType` FOREIGN KEY (`attribute_id`) REFERENCES `AttributeType` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы discipline_chooser.Validators: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `Validators` DISABLE KEYS */;
REPLACE INTO `Validators` (`id`, `title`, `attribute_id`) VALUES
	(1, 'Course', 2),
	(2, 'Teacher', 2);
/*!40000 ALTER TABLE `Validators` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
