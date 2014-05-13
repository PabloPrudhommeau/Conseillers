-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 12 Mai 2014 à 09:42
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
CREATE DATABASE IF NOT EXISTS `conseillers` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `conseillers`;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_statut` tinyint(4) NOT NULL,
  PRIMARY KEY (`login`),
  KEY `id_statut` (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`login`, `password`, `id_statut`) VALUES
('drh', '147de4c9d38de7fc9029aafbf0cc25a1', 2),
('resp', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('scol', '0edc047e1c7b53cd3e0c7e05bd3cff91', 3);

-- --------------------------------------------------------

--
-- Structure de la table `conseiller`
--

CREATE TABLE IF NOT EXISTS `conseiller` (
  `id_enseignant_chercheur` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  PRIMARY KEY (`id_enseignant_chercheur`,`id_etudiant`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`),
  KEY `id_enseignant_chercheur` (`id_enseignant_chercheur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conseiller`
--

INSERT INTO `conseiller` (`id_enseignant_chercheur`, `id_etudiant`) VALUES
(1, 1),
(10, 3),
(2, 4),
(8, 5),
(3, 6),
(6, 7),
(52, 8),
(4, 9),
(4, 10),
(1, 11),
(5, 12),
(8, 13),
(3, 14),
(7, 15),
(5, 16),
(5, 17),
(8, 18),
(9, 19),
(6, 21),
(10, 22),
(2, 23),
(6, 24),
(3, 25),
(7, 26),
(1, 27),
(4, 28),
(7, 29),
(9, 30);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant_chercheur`
--

CREATE TABLE IF NOT EXISTS `enseignant_chercheur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pole` tinyint(4) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `bureau` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pole` (`id_pole`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Contenu de la table `enseignant_chercheur`
--

INSERT INTO `enseignant_chercheur` (`id`, `id_pole`, `nom`, `prenom`, `bureau`) VALUES
(1, 1, 'LEMERCIER', 'Marc', 'T122'),
(2, 1, 'CORPEL', 'Alain', 'T111'),
(3, 1, 'BENEL', 'Aurelien', 'T107'),
(4, 2, 'BIRREGAH', 'Babiga', 'H107'),
(5, 3, 'JOSHUA', 'Marvin', 'T202'),
(6, 4, 'ENHE', 'Alric', 'H112'),
(7, 4, 'APOLIN', 'Sylvain', 'T201'),
(8, 3, 'SOARES', 'Amirez', 'H012'),
(9, 2, 'VOSISOV', 'Vladimir', 'H151'),
(10, 4, 'SAUTRANT', 'Angeline', 'T137'),
(52, 2, 'APACHE', 'Maverick', 'S122');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_programme` tinyint(4) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `semestre` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_programme` (`id_programme`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `id_programme`, `nom`, `prenom`, `semestre`) VALUES
(1, 5, 'VENANT', 'Philippes', 4),
(2, 4, 'SYRIAN', 'Hafar', 1),
(3, 5, 'GUSTAVE', 'Nathanaël', 3),
(4, 4, 'HODUAR', 'Ulysse', 2),
(5, 7, 'STENSON', 'Emerique', 6),
(6, 2, 'ALFONSO', 'Ernesto', 4),
(7, 6, 'GULLIVE', 'Olivier', 2),
(8, 1, 'SPRECY', 'Elise', 4),
(9, 5, 'AUTRAN', 'Nathan', 2),
(10, 3, 'AVARE', 'Jerôme', 1),
(11, 5, 'HARAJ', 'Mathis', 2),
(12, 5, 'GAUMONT', 'Paul', 2),
(13, 7, 'PASSANT', 'Guy', 1),
(14, 3, 'SULIVAN', 'Esther', 3),
(15, 4, 'NAUDIN', 'Claire', 1),
(16, 3, 'MAX', 'Julie', 1),
(17, 3, 'LAMERIQUE', 'Xavier', 3),
(18, 2, 'THIERRY', 'Martin', 3),
(19, 2, 'CARTHY', 'Mathiew', 1),
(20, 1, 'DIRAC', 'Paul', 6),
(21, 4, 'TESON', 'Melodie', 5),
(22, 4, 'ASFALD', 'François', 2),
(23, 5, 'SPENCER', 'Oliver', 4),
(24, 2, 'EASTWOOD', 'Clint', 5),
(25, 4, 'BOYLE', 'Stefano', 4),
(26, 6, 'OSPAQUE', 'Anthony', 2),
(27, 4, 'SOURP', 'Gaspard', 2),
(28, 4, 'AUTHE', 'Alan', 1),
(29, 5, 'BENCK', 'Kevin', 3),
(30, 1, 'ORTHODOXE', 'Iclesiaste', 2);

-- --------------------------------------------------------

--
-- Structure de la table `habilitation`
--

CREATE TABLE IF NOT EXISTS `habilitation` (
  `id_enseignant_chercheur` int(11) NOT NULL,
  `id_programme` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_enseignant_chercheur`,`id_programme`),
  KEY `id_programme` (`id_programme`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `habilitation`
--

INSERT INTO `habilitation` (`id_enseignant_chercheur`, `id_programme`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(52, 1),
(1, 2),
(8, 2),
(9, 2),
(3, 3),
(6, 3),
(8, 3),
(10, 3),
(6, 4),
(8, 4),
(10, 4),
(52, 4),
(1, 5),
(6, 5),
(52, 5),
(6, 6),
(8, 7);

-- --------------------------------------------------------

--
-- Structure de la table `liste_pole`
--

CREATE TABLE IF NOT EXISTS `liste_pole` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `liste_pole`
--

INSERT INTO `liste_pole` (`id`, `libelle`) VALUES
(1, 'HETIC'),
(2, 'ROSAS'),
(3, 'P2MN'),
(4, 'SUEL');

-- --------------------------------------------------------

--
-- Structure de la table `liste_programme`
--

CREATE TABLE IF NOT EXISTS `liste_programme` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `liste_programme`
--

INSERT INTO `liste_programme` (`id`, `libelle`) VALUES
(1, 'TC'),
(2, 'ISI'),
(3, 'SRT'),
(4, 'MTE'),
(5, 'SI'),
(6, 'SIT'),
(7, 'SM');

-- --------------------------------------------------------

--
-- Structure de la table `liste_statut`
--

CREATE TABLE IF NOT EXISTS `liste_statut` (
  `id` tinyint(4) NOT NULL,
  `libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liste_statut`
--

INSERT INTO `liste_statut` (`id`, `libelle`) VALUES
(1, 'responsable_programme'),
(2, 'directeur_ressources_humaine'),
(3, 'service_scolarite');

-- --------------------------------------------------------

--
-- Structure de la table `resp_programme`
--

CREATE TABLE IF NOT EXISTS `resp_programme` (
  `identifiant` varchar(50) NOT NULL,
  `id_programme` tinyint(4) NOT NULL,
  PRIMARY KEY (`identifiant`),
  KEY `id_programme` (`id_programme`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `resp_programme`
--

INSERT INTO `resp_programme` (`identifiant`, `id_programme`) VALUES
('resp', 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`id_statut`) REFERENCES `liste_statut` (`id`),
  ADD CONSTRAINT `compte_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `liste_statut` (`id`);

--
-- Contraintes pour la table `conseiller`
--
ALTER TABLE `conseiller`
  ADD CONSTRAINT `conseiller_ibfk_1` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_3` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_4` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id`);

--
-- Contraintes pour la table `enseignant_chercheur`
--
ALTER TABLE `enseignant_chercheur`
  ADD CONSTRAINT `enseignant_chercheur_ibfk_1` FOREIGN KEY (`id_pole`) REFERENCES `liste_pole` (`id`),
  ADD CONSTRAINT `enseignant_chercheur_ibfk_2` FOREIGN KEY (`id_pole`) REFERENCES `liste_pole` (`id`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`),
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`);

--
-- Contraintes pour la table `habilitation`
--
ALTER TABLE `habilitation`
  ADD CONSTRAINT `habilitation_ibfk_1` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`),
  ADD CONSTRAINT `habilitation_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`),
  ADD CONSTRAINT `habilitation_ibfk_3` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`),
  ADD CONSTRAINT `habilitation_ibfk_4` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`);

--
-- Contraintes pour la table `resp_programme`
--
ALTER TABLE `resp_programme`
  ADD CONSTRAINT `resp_programme_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`),
  ADD CONSTRAINT `resp_programme_ibfk_1` FOREIGN KEY (`identifiant`) REFERENCES `compte` (`login`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
