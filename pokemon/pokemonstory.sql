-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2020 at 10:55 AM
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
-- Database: `pokemonstory`
--

-- --------------------------------------------------------

--
-- Table structure for table `combat`
--

DROP TABLE IF EXISTS `combat`;
CREATE TABLE IF NOT EXISTS `combat` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_combat` date NOT NULL,
  `id_pok1` int(10) UNSIGNED NOT NULL,
  `id_pok2` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_combat_pokemon1` (`id_pok1`),
  KEY `fk_combat_pokemon2` (`id_pok2`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `combat`
--

INSERT INTO `combat` (`id`, `date_combat`, `id_pok1`, `id_pok2`) VALUES
(1, '2020-10-03', 1, 4),
(2, '2020-10-04', 2, 3),
(3, '2020-10-05', 4, 2),
(4, '2020-10-06', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `dresseur`
--

DROP TABLE IF EXISTS `dresseur`;
CREATE TABLE IF NOT EXISTS `dresseur` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dresseur`
--

INSERT INTO `dresseur` (`id`, `nom`) VALUES
(1, 'dresseurA'),
(2, 'dresseurB'),
(3, 'dresseurC'),
(4, 'dresseurD');

-- --------------------------------------------------------

--
-- Table structure for table `pokedex`
--

DROP TABLE IF EXISTS `pokedex`;
CREATE TABLE IF NOT EXISTS `pokedex` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pokedex`
--

INSERT INTO `pokedex` (`id`, `nom`) VALUES
(1, 'pokedexA'),
(2, 'pokedexB'),
(3, 'pokedexC'),
(4, 'pokedexD');

-- --------------------------------------------------------

--
-- Table structure for table `pokemon`
--

DROP TABLE IF EXISTS `pokemon`;
CREATE TABLE IF NOT EXISTS `pokemon` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `energie` int(10) UNSIGNED NOT NULL DEFAULT '50',
  `id_pokedex` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pokemon_pokedex` (`id_pokedex`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pokemon`
--

INSERT INTO `pokemon` (`id`, `nom`, `energie`, `id_pokedex`) VALUES
(1, 'pokemonA', 79, 2),
(2, 'pokemonC', 44, 4),
(3, 'pokemonD', 77, 3),
(4, 'pokemonB', 65, 2),
(5, 'pokemonE', 43, 3);

-- --------------------------------------------------------

--
-- Table structure for table `relation_p_d`
--

DROP TABLE IF EXISTS `relation_p_d`;
CREATE TABLE IF NOT EXISTS `relation_p_d` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `id_dresseur` int(10) UNSIGNED NOT NULL,
  `id_pokemon` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_relation_pokemon` (`id_dresseur`),
  KEY `fk_relation_dresseur` (`id_pokemon`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relation_p_d`
--

INSERT INTO `relation_p_d` (`id`, `date_debut`, `date_fin`, `id_dresseur`, `id_pokemon`) VALUES
(1, '2020-01-01', '2020-02-01', 1, 1),
(2, '2020-02-01', '2020-03-01', 2, 4),
(3, '2020-06-01', '2020-08-01', 3, 2),
(4, '2020-08-01', '2020-10-01', 4, 3),
(5, '2020-10-01', NULL, 1, 4),
(6, '2020-10-01', NULL, 2, 1),
(7, '2020-10-01', NULL, 3, 3),
(8, '2020-10-01', NULL, 4, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `combat`
--
ALTER TABLE `combat`
  ADD CONSTRAINT `fk_combat_pokemon1` FOREIGN KEY (`id_pok1`) REFERENCES `pokemon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_combat_pokemon2` FOREIGN KEY (`id_pok2`) REFERENCES `pokemon` (`id`);

--
-- Constraints for table `pokemon`
--
ALTER TABLE `pokemon`
  ADD CONSTRAINT `fk_pokemon_pokedex` FOREIGN KEY (`id_pokedex`) REFERENCES `pokedex` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `relation_p_d`
--
ALTER TABLE `relation_p_d`
  ADD CONSTRAINT `fk_relation_dresseur` FOREIGN KEY (`id_pokemon`) REFERENCES `pokemon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_relation_pokemon` FOREIGN KEY (`id_dresseur`) REFERENCES `dresseur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
