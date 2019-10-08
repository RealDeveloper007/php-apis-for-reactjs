

-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `auth_contact`;
CREATE TABLE `auth_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `auth_contact` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(20,	'exam',	'diwakarsharma603@gmail.com',	'ads fsc Zcz C',	'zc adc ZCXZ czCXz ',	1,	'2019-10-08 15:40:34'),
(21,	'exam',	'diwakarsharma603@gmail.com',	'sACX C',	'',	1,	'2019-10-08 15:41:37'),
(22,	'exam',	'',	'',	'',	1,	'2019-10-08 15:44:30'),
(23,	'exam',	'diwakarsharma603@gmail.com',	'subject',	' bcb cb',	1,	'2019-10-08 19:15:53');

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE `auth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `auth_users` (`id`, `email`, `password`, `full_name`, `phone`, `image`, `status`, `created_on`) VALUES
(2,	'superadmin@demo.com',	'e10adc3949ba59abbe56e057f20f883e',	'Andrew',	4574574574,	NULL,	'active',	'2019-10-08 15:10:43');

-- 2019-10-08 16:12:44
