-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 21, 2020 at 08:13 PM
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
-- Database: `gestion_eleves`
--

-- --------------------------------------------------------

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classe`
--

INSERT INTO `classe` (`id`, `nom_classe`) VALUES
(1, 'classe_1'),
(2, 'classe_2');

-- --------------------------------------------------------

--
-- Table structure for table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` datetime NOT NULL,
  `moyen` double UNSIGNED DEFAULT NULL,
  `appreciation` varchar(20) DEFAULT NULL,
  `id_classe` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_eleve_classe` (`id_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `date_naissance`, `moyen`, `appreciation`, `id_classe`) VALUES
(19, 'fffs', 'ffffffsddddd', '2000-01-01 00:00:00', 77, 'Tres bien', 1),
(20, 'sdsdd', 'dsdsdsdsdsdsssd', '2020-10-07 00:00:00', 70, 'moyen', 1),
(23, 'aaa', 'aaaa', '2020-11-01 00:00:00', 44, 'moyen', 1),
(24, 'ccc', 'ccc', '2020-11-01 00:00:00', 66, 'bien', 1),
(25, 'vvv', 'vvv', '2020-11-01 00:00:00', 55, 'bien', 1),
(26, 'eee', 'eeee', '2002-06-04 00:00:00', 80, 'Tres bien', 1),
(27, 'qq', 'qq', '1996-01-09 00:00:00', 60, 'bien', 1),
(34, 'rrrr', 'rrrrrr', '2000-06-21 00:00:00', 50, 'bien', 1),
(35, 'vvvv', 'vvvvv', '2014-02-03 00:00:00', 0, '', 1),
(39, 'ccc', 'ccc', '2020-11-21 00:00:00', 0, '', 2),
(40, 'zzzz', 'zzzz', '2020-11-16 00:00:00', 0, '', 1),
(43, 'ee', 'ee', '2020-11-21 00:00:00', 0, '', 2),
(44, 'xx', 'xx', '2020-11-21 00:00:00', 88, 'Tres bien', 2),
(45, 'mm', 'mm', '2020-11-14 00:00:00', 0, '', 2),
(46, 'ccccx', 'ccccx', '2020-11-02 00:00:00', 50, 'moyen', 2),
(47, 'xxx', 'xxx', '2020-11-03 00:00:00', 77, 'Tres bien', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `FK_eleve_classe` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
