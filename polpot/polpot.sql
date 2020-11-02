-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2020 at 03:22 PM
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
-- Database: `polpot`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`) VALUES
(1, 'nomClientA', 'prenomClienA'),
(2, 'nomClientB', 'prenomClientB'),
(3, 'nomClientC', 'prenomClientC'),
(4, 'nomClientD', 'prenomClientD');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prix` float NOT NULL,
  `date` date NOT NULL,
  `id_devis` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_commande_devis` (`id_devis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `prix`, `date`, `id_devis`) VALUES
(1, 120, '2020-07-15', 1),
(2, 120, '2020-08-15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `id_client` int(11) UNSIGNED NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_devis_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devis`
--

INSERT INTO `devis` (`id`, `date`, `id_client`, `prix`) VALUES
(1, '2020-07-01', 1, 100),
(2, '2020-08-01', 2, 150);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `prix` float NOT NULL,
  `id_commande` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_facture_commande` (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id`, `date`, `prix`, `id_commande`) VALUES
(1, '2020-05-01', 160, 1),
(2, '2020-09-15', 170, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lien_commande_produit`
--

DROP TABLE IF EXISTS `lien_commande_produit`;
CREATE TABLE IF NOT EXISTS `lien_commande_produit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prix` float NOT NULL,
  `id_commande` int(11) UNSIGNED NOT NULL,
  `id_produit` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_liencp_produit` (`id_produit`),
  KEY `fk_liencp_commande` (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lien_commande_produit`
--

INSERT INTO `lien_commande_produit` (`id`, `prix`, `id_commande`, `id_produit`) VALUES
(1, 120, 1, 1),
(2, 150, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lien_devis_produit`
--

DROP TABLE IF EXISTS `lien_devis_produit`;
CREATE TABLE IF NOT EXISTS `lien_devis_produit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `qte` int(11) UNSIGNED NOT NULL,
  `lot` varchar(255) NOT NULL,
  `id_devis` int(11) UNSIGNED NOT NULL,
  `id_produit` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lot` (`lot`),
  KEY `fk_liendp_produit` (`id_produit`),
  KEY `fk_liendp_devis` (`id_devis`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lien_devis_produit`
--

INSERT INTO `lien_devis_produit` (`id`, `qte`, `lot`, `id_devis`, `id_produit`) VALUES
(1, 3, '123', 1, 1),
(2, 4, '456', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lien_facture_produit`
--

DROP TABLE IF EXISTS `lien_facture_produit`;
CREATE TABLE IF NOT EXISTS `lien_facture_produit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prix` float NOT NULL,
  `id_facture` int(11) UNSIGNED NOT NULL,
  `id_produit` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lienfp_produit` (`id_produit`),
  KEY `fk_lienfp_facture` (`id_facture`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lien_facture_produit`
--

INSERT INTO `lien_facture_produit` (`id`, `prix`, `id_facture`, `id_produit`) VALUES
(1, 150, 1, 1),
(2, 170, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `lien_production_produit`
--

DROP TABLE IF EXISTS `lien_production_produit`;
CREATE TABLE IF NOT EXISTS `lien_production_produit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `qte` int(11) NOT NULL,
  `id_produit` int(11) UNSIGNED NOT NULL,
  `id_production` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lienpp_produit` (`id_produit`),
  KEY `fk_lienpp_production` (`id_production`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lien_production_produit`
--

INSERT INTO `lien_production_produit` (`id`, `qte`, `id_produit`, `id_production`) VALUES
(1, 3, 1, 1),
(2, 4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

DROP TABLE IF EXISTS `production`;
CREATE TABLE IF NOT EXISTS `production` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_commande` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_production_commande` (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`id`, `id_commande`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `nom`) VALUES
(1, 'produitA'),
(2, 'produitB'),
(3, 'produitC'),
(4, 'produitD');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_devis` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `fk_devis_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `fk_facture_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lien_commande_produit`
--
ALTER TABLE `lien_commande_produit`
  ADD CONSTRAINT `fk_liencp_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_liencp_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lien_devis_produit`
--
ALTER TABLE `lien_devis_produit`
  ADD CONSTRAINT `fk_liendp_devis` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_liendp_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lien_facture_produit`
--
ALTER TABLE `lien_facture_produit`
  ADD CONSTRAINT `fk_lienfp_facture` FOREIGN KEY (`id_facture`) REFERENCES `facture` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lienfp_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lien_production_produit`
--
ALTER TABLE `lien_production_produit`
  ADD CONSTRAINT `fk_lienpp_production` FOREIGN KEY (`id_production`) REFERENCES `production` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lienpp_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `fk_production_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
