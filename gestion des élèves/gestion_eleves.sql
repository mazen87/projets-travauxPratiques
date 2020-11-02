-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2020 at 02:39 PM
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `date_naissance`, `moyen`, `appreciation`) VALUES
(7, 'aaaaaaa', 'aaaa', '1987-10-04 00:00:00', 88.8, 'très bien'),
(19, 'fffs', 'ffffffsddddd', '2000-01-01 00:00:00', 77, 'très bien'),
(20, 'sdsdd', 'dsdsdsdsdsdsssd', '2020-10-06 00:00:00', 77, 'moyen'),
(21, 'wwww', 'wwwwwwww', '1975-10-14 00:00:00', 33.22, 'pas bien'),
(22, 'bbbb', 'bbbbbb', '1990-02-14 00:00:00', 87, 'très Bien'),
(23, 'aaa', 'aaaa', '2020-11-01 00:00:00', 44, 'moyen'),
(24, 'ccc', 'ccc', '2020-11-01 00:00:00', 66, 'bien'),
(25, 'vvv', 'vvv', '2020-11-01 00:00:00', 55, 'bien'),
(26, 'eee', 'eeee', '2002-06-04 00:00:00', 80, 'très bien'),
(27, 'qq', 'qq', '1996-01-09 00:00:00', 60, 'bien');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
