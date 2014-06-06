-- phpMyAdmin SQL Dump
-- version 2.11.11.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 06 Juin 2014 à 09:33
-- Version du serveur: 5.5.25
-- Version de PHP: 5.3.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `serrajon`
--

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
('respISI', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respMTE', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respSI', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respSIT', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respSM', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respSRT', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('respTC', 'bd86bced84fb3aef951fb07de8c533c7', 1),
('scol', '0edc047e1c7b53cd3e0c7e05bd3cff91', 3);

-- --------------------------------------------------------

--
-- Structure de la table `conseiller`
--

CREATE TABLE IF NOT EXISTS `conseiller` (
  `id_enseignant_chercheur` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  PRIMARY KEY (`id_etudiant`),
  KEY `id_enseignant_chercheur` (`id_enseignant_chercheur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conseiller`
--


-- --------------------------------------------------------

--
-- Structure de la table `enseignant_chercheur`
--

CREATE TABLE IF NOT EXISTS `enseignant_chercheur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pole` tinyint(4) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `bureau` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pole` (`id_pole`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `enseignant_chercheur`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45222 ;

--
-- Contenu de la table `etudiant`
--


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
('respTC', 1),
('respISI', 2),
('respSRT', 3),
('respMTE', 4),
('respSI', 5),
('respSIT', 6),
('respSM', 7);

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
  ADD CONSTRAINT `conseiller_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id`),
  ADD CONSTRAINT `conseiller_ibfk_2` FOREIGN KEY (`id_enseignant_chercheur`) REFERENCES `enseignant_chercheur` (`id`);

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
  ADD CONSTRAINT `resp_programme_ibfk_1` FOREIGN KEY (`identifiant`) REFERENCES `compte` (`login`),
  ADD CONSTRAINT `resp_programme_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `liste_programme` (`id`);
