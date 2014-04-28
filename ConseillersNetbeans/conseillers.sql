-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 28 Avril 2014 à 00:31
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
  `date_deb` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id_enseignant_chercheur`,`id_etudiant`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`),
  KEY `id_enseignant_chercheur` (`id_enseignant_chercheur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `enseignant_chercheur`
--

INSERT INTO `enseignant_chercheur` (`id`, `id_pole`, `nom`, `prenom`, `bureau`) VALUES
(2, 2, 'jacque', 'jacque', 'N101'),
(3, 2, 'frederic', 'frederic', 'B104');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `id_programme`, `nom`, `prenom`, `semestre`) VALUES
(4, 3, 'jean ', 'jean', 1),
(5, 3, 'lili', 'lili', 2);

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

-- --------------------------------------------------------

--
-- Structure de la table `liste_pole`
--

CREATE TABLE IF NOT EXISTS `liste_pole` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liste_pole`
--

INSERT INTO `liste_pole` (`id`, `libelle`) VALUES
(2, 'TYPIQUEMENT');

-- --------------------------------------------------------

--
-- Structure de la table `liste_programme`
--

CREATE TABLE IF NOT EXISTS `liste_programme` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liste_programme`
--

INSERT INTO `liste_programme` (`id`, `libelle`) VALUES
(3, 'ISI');

-- --------------------------------------------------------

--
-- Structure de la table `liste_statut`
--

CREATE TABLE IF NOT EXISTS `liste_statut` (
  `id` tinyint(4) NOT NULL,
  `libelle` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liste_statut`
--

INSERT INTO `liste_statut` (`id`, `libelle`) VALUES
(1, 'resp'),
(2, 'drh'),
(3, 'scol');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `liste_statut` (`ID`),
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`ID_statut`) REFERENCES `liste_statut` (`ID`);

--
-- Contraintes pour la table `conseiller`
--
ALTER TABLE `conseiller`
  ADD CONSTRAINT `conseiller_ibfk_4` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`ID`),
  ADD CONSTRAINT `conseiller_ibfk_1` FOREIGN KEY (`ID_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`ID`),
  ADD CONSTRAINT `conseiller_ibfk_2` FOREIGN KEY (`ID_etudiant`) REFERENCES `etudiant` (`ID`),
  ADD CONSTRAINT `conseiller_ibfk_3` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`ID`);

--
-- Contraintes pour la table `enseignant_chercheur`
--
ALTER TABLE `enseignant_chercheur`
  ADD CONSTRAINT `enseignant_chercheur_ibfk_2` FOREIGN KEY (`id_pole`) REFERENCES `liste_pole` (`ID`),
  ADD CONSTRAINT `enseignant_chercheur_ibfk_1` FOREIGN KEY (`ID_pole`) REFERENCES `liste_pole` (`ID`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`ID`),
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`ID_programme`) REFERENCES `liste_programme` (`ID`);

--
-- Contraintes pour la table `habilitation`
--
ALTER TABLE `habilitation`
  ADD CONSTRAINT `habilitation_ibfk_4` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`ID`),
  ADD CONSTRAINT `habilitation_ibfk_1` FOREIGN KEY (`ID_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`ID`),
  ADD CONSTRAINT `habilitation_ibfk_2` FOREIGN KEY (`ID_programme`) REFERENCES `liste_programme` (`ID`),
  ADD CONSTRAINT `habilitation_ibfk_3` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
