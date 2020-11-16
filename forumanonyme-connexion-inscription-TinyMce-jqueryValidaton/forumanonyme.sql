-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2020 at 04:13 PM
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
-- Database: `forumanonyme`
--

-- --------------------------------------------------------

--
-- Table structure for table `likedislike`
--

DROP TABLE IF EXISTS `likedislike`;
CREATE TABLE IF NOT EXISTS `likedislike` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_reation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `value` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `nombre_likes` int(10) NOT NULL DEFAULT '0',
  `nombre_dislikes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `id_message` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Fk_likedislike_message` (`id_message`),
  KEY `FK_likedislike_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likedislike`
--

INSERT INTO `likedislike` (`id`, `date_reation`, `value`, `nombre_likes`, `nombre_dislikes`, `id_utilisateur`, `id_message`) VALUES
(1, '2020-11-14 14:57:56', 1, 1, 0, 1, 5),
(2, '2020-11-14 14:57:56', 0, 0, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_message_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `contenu`, `date_creation`, `id_utilisateur`) VALUES
(1, 'fff hhh kk ll', '2020-11-13 17:09:07', 1),
(4, 'hkrphkr prhkrpk hr h', '2020-11-14 14:54:47', 1),
(5, 'hejhorhjo oejo e', '2020-11-14 14:54:47', 2),
(6, 'hhhrhrhrh', '2020-11-15 09:36:44', 1),
(7, 'kkkkkkk', '2020-11-15 09:36:55', 1),
(8, 'test 2', '2020-11-15 12:26:35', 2),
(9, 'jjjjjjjjjj', '2020-11-15 13:04:34', 1),
(10, 'eegegegegegegegeg', '2020-11-15 19:27:51', 5),
(12, 'fzffzfzfzffz', '2020-11-15 19:33:33', 5),
(15, 'fzfzfzzfzfzfzfzfzff', '2020-11-16 09:14:34', 5),
(31, 'hhhhhhhhh', '2020-11-16 11:54:17', 5),
(32, 'frfrfrfrfrfr', '2020-11-16 11:55:11', 5),
(33, 'uuuuuuuuu', '2020-11-16 11:57:05', 5),
(52, '<span style=\"text-decoration: line-through;\">fffffffff</span>', '2020-11-16 12:56:09', 5),
(55, 'kkkkkkkkkkkkkkk', '2020-11-16 12:58:54', 5),
(65, 'gggggggggggg', '2020-11-16 15:35:02', 5),
(66, '<h2><strong>ggggggggggggg</strong></h2>', '2020-11-16 15:36:30', 5),
(67, '<strong>kkkkkkkk</strong>', '2020-11-16 15:36:54', 5),
(68, 'mmmmmmm', '2020-11-16 15:37:15', 5);

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
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reponse_utilisateur` (`id_utilisateur`),
  KEY `FK_reponse_message` (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reponse`
--

INSERT INTO `reponse` (`id`, `contenu_reponse`, `date_reponse`, `id_message`, `id_utilisateur`) VALUES
(1, 'pkfzpkz pkzpkpfzk fz ', '2020-11-14 14:55:23', 1, 2),
(2, 'eogeoej oegoe g', '2020-11-14 14:55:23', 5, 1),
(3, 'ddddddddddd', '2020-11-16 10:24:51', 5, 5),
(4, '<span style=\"text-decoration: line-through;\"><strong>rrrrrrrrrr</strong></span>', '2020-11-16 15:56:15', 52, 5),
(5, 'ergergggeg', '2020-11-16 15:56:34', 52, 5);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `pseudo`, `motDePasse`) VALUES
(1, 'utilisateur_1@xxx.com', 'utilisateur_1', 'utilisateur_1'),
(2, 'utilisateur_2@xxx.com', 'utilisateur_2', 'utilisateur_2'),
(5, 'utilisateur_3@xxx.com', 'utilsateur_3', '$2y$10$wJRC.GKtArCjLm21nnH6t.3QSuYcBiG9YmQ5bscEcyx9Y4M30REf.');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likedislike`
--
ALTER TABLE `likedislike`
  ADD CONSTRAINT `FK_likedislike_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Fk_likedislike_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_message_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_reponse_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_reponse_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
