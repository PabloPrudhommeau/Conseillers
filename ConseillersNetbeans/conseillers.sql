-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 28 Avril 2014 à 21:19
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `conseillers`
--

-- --------------------------------------------------------

--
-- Structure de la table `conseiller`
--

CREATE TABLE IF NOT EXISTS `conseiller` (
  `id_enseignant_chercheur` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `date_deb` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id_enseignant_chercheur`,`id_etudiant`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`),
  KEY `id_enseignant_chercheur` (`id_enseignant_chercheur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conseiller`
--

INSERT INTO `conseiller` (`id_enseignant_chercheur`, `id_etudiant`, `date_deb`, `date_fin`) VALUES
(1, 1, '2014-04-01', '2014-04-30'),
(1, 11, '2014-04-20', '2014-10-09'),
(2, 23, '2014-04-01', '2014-04-30'),
(3, 6, '2014-04-01', '2014-05-17'),
(4, 9, '2014-04-21', '2014-08-06'),
(4, 10, '2014-04-21', '2015-03-12'),
(5, 16, '2014-08-04', '2015-08-05'),
(6, 21, '2014-08-12', '2014-09-12'),
(6, 24, '2014-04-22', '2014-09-12'),
(7, 15, '2014-04-21', '2014-12-16'),
(7, 29, '2014-04-21', '2014-11-01'),
(8, 18, '2014-04-06', '2014-11-15'),
(9, 30, '2014-04-05', '2014-07-10'),
(10, 22, '2014-04-08', '2014-08-08');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `conseiller`
--
ALTER TABLE `conseiller`
  ADD CONSTRAINT `conseiller_ibfk_4` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_1` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_3` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
