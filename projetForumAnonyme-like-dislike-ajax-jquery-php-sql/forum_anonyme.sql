-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2020 at 07:22 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum_anonyme`
--

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_utilisateur` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `nombre_likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nombre_dislikes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `ip_utilisateur`, `contenu`, `nombre_likes`, `nombre_dislikes`, `date_creation`) VALUES
(1, '3456', 'kfzfkzf zkfhzkfhzk hfzk hkzehkzh f', 8, 0, '2020-11-06 11:39:21'),
(2, '::1', 'dzdzdz', 0, 0, '2020-11-06 11:39:49'),
(16, '::1', 'zdzdzdzdzdz efefef', 0, 0, '2020-11-06 11:59:41'),
(17, '::1', 'dzdzddzdz', 0, 0, '2020-11-06 12:01:36'),
(18, '::1', 'test test', 0, 0, '2020-11-08 08:48:51'),
(19, '::1', 'test2', 0, 0, '2020-11-08 08:50:45'),
(20, '::1', 'test3', 0, 0, '2020-11-08 08:53:04'),
(21, '::1', 'test4', 0, 0, '2020-11-08 08:54:06'),
(22, '::1', 'test5', 0, 0, '2020-11-08 09:00:54'),
(23, '::1', 'test6', 0, 0, '2020-11-08 09:02:08'),
(24, '::1', 'test7', 0, 0, '2020-11-08 09:05:16'),
(26, '::1', 'test8', 0, 0, '2020-11-08 09:06:41'),
(27, '::1', 'test9', 0, 0, '2020-11-08 09:08:24'),
(28, '::1', 'test10', 3, 0, '2020-11-08 09:11:35'),
(29, '::1', 'test11', 0, 0, '2020-11-08 09:19:40'),
(30, '::1', 'test12', 1, 0, '2020-11-08 09:21:47'),
(31, '::1', 'test13', 0, 0, '2020-11-08 10:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contenu_reponse` text NOT NULL,
  `date_reponse` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_message` int(10) UNSIGNED NOT NULL,
  `createur_reponse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reponse_message` (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reponse`
--

INSERT INTO `reponse` (`id`, `contenu_reponse`, `date_reponse`, `id_message`, `createur_reponse`) VALUES
(7, 'reponse1', '2020-11-08 15:49:51', 22, '::1'),
(8, 'adadadadadada', '2020-11-08 15:54:38', 22, '::1'),
(9, 'dzfzfezfzfzf', '2020-11-08 16:01:44', 27, '::1'),
(10, 'ddd jjgjgjgjgj', '2020-11-08 16:03:59', 27, '::1'),
(11, 'qqqqq', '2020-11-08 16:26:46', 27, '::1'),
(12, 'egegegegeg', '2020-11-09 14:27:58', 1, '::1'),
(13, 'dggdgdg', '2020-11-09 15:35:38', 29, '::1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_reponse_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
