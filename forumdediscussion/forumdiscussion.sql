-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2020 at 09:44 AM
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
-- Database: `forumdiscussion`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'football'),
(2, 'voitures');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_categorie` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_user` (`id_user`),
  KEY `fk_message_categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `titre`, `text`, `date`, `id_categorie`, `id_user`) VALUES
(1, 'champion du monde 2018', 'la France  a gagné', '2020-10-18 12:54:27', 1, 10),
(2, 'man unt vs real madrid ', 'd\'est un truc de ouf.....!', '2020-10-18 13:49:45', 1, 12),
(3, 'audi', 'vraiment belles ', '2020-10-18 16:57:58', 2, 11),
(4, 'dfgggrgrg', 'rgegegegeggegegeg', '2020-10-19 10:44:33', 1, 10),
(5, 'dfgggrgrg', 'rgegegegeggegegeg', '2020-10-19 10:45:02', 1, 10),
(6, 'bmv', 'sde vgtg rrgrg ', '2020-10-19 11:41:13', 2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `motdepasse`
--

DROP TABLE IF EXISTS `motdepasse`;
CREATE TABLE IF NOT EXISTS `motdepasse` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `motdepasse` varchar(255) NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_motdepasse_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  `id_message` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reponse_message` (`id_message`),
  KEY `fk_reponse_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reponse`
--

INSERT INTO `reponse` (`id`, `date`, `text`, `id_message`, `id_user`) VALUES
(1, '2020-10-19 04:19:01', 'la france a bien joue au finale ', 1, 11),
(2, '2020-10-19 04:20:00', 'oorraaaaaaaa !on a gagne', 1, 12),
(3, '2020-10-19 05:06:04', 'efz zfz fz z f zf f f', 1, 10),
(4, '2020-10-19 09:18:39', 'wwwwwwwww', 1, 10),
(5, '2020-10-19 09:18:55', 'xxxxxxx', 1, 10),
(6, '2020-10-19 09:18:59', 'xxxxxxx', 1, 10),
(7, '2020-10-19 09:24:23', 'xxxxxxx', 1, 10),
(8, '2020-10-19 09:24:37', 'aaaaaa', 1, 10),
(9, '2020-10-19 09:24:49', 'aaaaaa', 1, 10),
(10, '2020-10-19 09:30:55', 'ssss', 1, 10),
(11, '2020-10-19 09:31:15', 'ssss', 1, 10),
(12, '2020-10-19 09:33:33', 'ssss', 1, 10),
(13, '2020-10-19 09:33:39', 'xxxxxx', 1, 10),
(14, '2020-10-19 09:33:47', 'aaaavvbnn', 1, 10),
(15, '2020-10-19 09:34:02', 'nnlnnlnln', 1, 10),
(16, '2020-10-19 09:35:44', 'eeeeeee', 1, 10),
(17, '2020-10-19 09:38:33', 'azeb', 1, 10),
(18, '2020-10-19 09:45:26', 'vvvv', 1, 10),
(19, '2020-10-19 09:45:30', 'vvvvvbbnn,,', 1, 10),
(20, '2020-10-19 09:46:02', 'efrghbn njkiu bhh', 3, 10),
(21, '2020-10-19 10:38:45', 'ssssss', 1, 10),
(22, '2020-10-19 10:41:41', 'wwwwwwwww', 1, 10),
(23, '2020-10-19 11:42:46', 'dee eeffe fefe fefef', 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `pseudo`, `motdepasse`) VALUES
(10, 'aaa@aaa.com', 'aaaaa', '$2y$10$5xfkq4qF7YcM1txVTVTfQOuGZ2vrZe4tDo0FpzZy3xjm3pwmDj06S'),
(11, 'bbb@bbb.com', 'bbb', '$2y$10$lCk.DFCJOXtrEXD59.nkEu13YhJh4LBQxwILpYZ4GXM3ymixTimGa'),
(12, 'ccc@ccc.com', 'ccc', '$2y$10$eYbdlGDIxC.AUAS1QgqUcOeEoHMqwV5.1zwFnyQxDOgaDL4CZ3WNa'),
(13, 'mmm@mmm.com', 'mmm', '$2y$10$q0WOuiAbZ.j1ZujOUgyAQet5a1grB7nM3PTAgOEaycNdYV358kyCC'),
(14, 'ppp@ppp.com', 'ppp', '$2y$10$ikVIlfPd1mseSaXd3fOg5eUYKOpJyNkU8MgL8M5VJYtSW4Js2ZorS'),
(15, 'eee@eee.com', 'eee', '$2y$10$v3b0t7DjKYxzVc3U6n2lXOBO/hDT1yYxc2qWZ6hoi/JgD70FWsnaC');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `motdepasse`
--
ALTER TABLE `motdepasse`
  ADD CONSTRAINT `fk_motdepasse_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_reponse_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reponse_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
