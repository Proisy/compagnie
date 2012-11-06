-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 06 Novembre 2012 à 10:15
-- Version du serveur: 5.5.24
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `compagnie`
--

-- --------------------------------------------------------

--
-- Structure de la table `aeroport`
--

CREATE TABLE IF NOT EXISTS `aeroport` (
  `aeroport_trigramme` varchar(3) NOT NULL,
  `aeroport_nom` varchar(255) NOT NULL,
  `aeroport_terminaux` int(11) NOT NULL COMMENT 'Nombre de terminaux de l''aéroport',
  `aeroport_longueur_piste` int(11) NOT NULL COMMENT 'Longueur de piste maximale',
  PRIMARY KEY (`aeroport_trigramme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `aeroport_ville`
--

CREATE TABLE IF NOT EXISTS `aeroport_ville` (
  `id_aeroport_ville` int(11) NOT NULL AUTO_INCREMENT,
  `aeroport_trigramme` varchar(3) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`id_aeroport_ville`),
  KEY `id_aeroport` (`aeroport_trigramme`,`id_ville`),
  KEY `id_ville` (`id_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE IF NOT EXISTS `agence` (
  `id_agence` int(11) NOT NULL AUTO_INCREMENT,
  `agence_nom` varchar(255) NOT NULL,
  `agence_adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id_agence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `avion`
--

CREATE TABLE IF NOT EXISTS `avion` (
  `avion_immatriculation` int(11) NOT NULL AUTO_INCREMENT,
  `id_modele` int(11) NOT NULL,
  `avion_heure_vol_total` int(11) NOT NULL COMMENT 'Nombre d''heure de vol total de l''avion',
  `avion_heure_vol_revision` int(11) NOT NULL COMMENT 'Nombre d''heure de vol avant la prochaine revision',
  PRIMARY KEY (`avion_immatriculation`),
  KEY `id_modele` (`id_modele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `certification`
--

CREATE TABLE IF NOT EXISTS `certification` (
  `id_certification` int(11) NOT NULL,
  `certification_nom` varchar(255) NOT NULL,
  `certification_validite` int(11) NOT NULL,
  PRIMARY KEY (`id_certification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `certification_modele`
--

CREATE TABLE IF NOT EXISTS `certification_modele` (
  `id_certification_modele` int(11) NOT NULL AUTO_INCREMENT,
  `id_certification` int(11) NOT NULL,
  `id_modele` int(11) NOT NULL,
  PRIMARY KEY (`id_certification_modele`),
  KEY `id_certification` (`id_certification`,`id_modele`),
  KEY `id_modele` (`id_modele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(255) NOT NULL,
  `client_prenom` varchar(255) NOT NULL,
  `client_telephone` varchar(12) NOT NULL,
  `client_adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ligne`
--

CREATE TABLE IF NOT EXISTS `ligne` (
  `id_ligne` int(11) NOT NULL,
  `id_aeroport_depart` varchar(3) NOT NULL,
  `id_aeroport_arrivee` varchar(3) NOT NULL,
  `ligne_periodicité` enum('unique','journaliere','hebdomadaire','mensuelle') NOT NULL COMMENT 'Périodicité de la ligne',
  PRIMARY KEY (`id_ligne`),
  KEY `id_aeroport_depart` (`id_aeroport_depart`,`id_aeroport_arrivee`),
  KEY `id_aeroport_arrivee` (`id_aeroport_arrivee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

CREATE TABLE IF NOT EXISTS `modele` (
  `id_modele` int(10) NOT NULL AUTO_INCREMENT,
  `modele_marque` varchar(255) NOT NULL,
  `modele_reference` varchar(255) NOT NULL,
  `modele_rayon` int(11) NOT NULL COMMENT 'Rayon d''action',
  `modele_piste_att` int(11) NOT NULL COMMENT 'longueur de piste pour l''atterissage',
  `modele_piste_dec` int(11) NOT NULL COMMENT 'longueur de piste pour le décollage',
  `modele_nb_passagers` int(11) NOT NULL,
  `modele_diff_revision` int(11) NOT NULL COMMENT 'Durée entre 2 grandes révisions',
  PRIMARY KEY (`id_modele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `modele`
--

INSERT INTO `modele` VALUES(1, 'Airbus', 'A380', 2500, 300, 450, 600, 800);
INSERT INTO `modele` VALUES(2, 'Boeing', 'A380', 2500, 300, 450, 600, 800);
INSERT INTO `modele` VALUES(4, 'Airbus', 'A310', 1900, 300, 250, 300, 600);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) NOT NULL AUTO_INCREMENT,
  `pays_nom` varchar(255) NOT NULL,
  `pays_continent` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `pilote`
--

CREATE TABLE IF NOT EXISTS `pilote` (
  `id_pilote` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_pilote`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pilote_certification`
--

CREATE TABLE IF NOT EXISTS `pilote_certification` (
  `id_pilote_certification` int(11) NOT NULL AUTO_INCREMENT,
  `id_pilote` int(11) NOT NULL,
  `id_certification` int(11) NOT NULL,
  PRIMARY KEY (`id_pilote_certification`),
  KEY `id_pilote` (`id_pilote`,`id_certification`),
  KEY `id_certification` (`id_certification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

CREATE TABLE IF NOT EXISTS `technicien` (
  `id_technicien` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_technicien`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `user_nom` varchar(255) NOT NULL,
  `user_prenom` varchar(255) NOT NULL,
  `user_adresse` varchar(255) NOT NULL,
  `user_telephone` varchar(12) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(255) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `vol`
--

CREATE TABLE IF NOT EXISTS `vol` (
  `id_vol` int(11) NOT NULL,
  `id_pilote` int(11) NOT NULL,
  `id_copilote` int(11) NOT NULL,
  `vol_informations` varchar(255) NOT NULL,
  `vol_date` date NOT NULL,
  `vol_depart_prevu` time NOT NULL,
  `vol_arrivee_prevue` time NOT NULL,
  `id_ligne` int(11) NOT NULL,
  PRIMARY KEY (`id_vol`),
  KEY `id_pilote` (`id_pilote`,`id_copilote`),
  KEY `id_copilote` (`id_copilote`),
  KEY `id_ligne` (`id_ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `aeroport_ville`
--
ALTER TABLE `aeroport_ville`
  ADD CONSTRAINT `aeroport_ville_ibfk_1` FOREIGN KEY (`aeroport_trigramme`) REFERENCES `aeroport` (`aeroport_trigramme`),
  ADD CONSTRAINT `aeroport_ville_ibfk_2` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_1` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`);

--
-- Contraintes pour la table `certification_modele`
--
ALTER TABLE `certification_modele`
  ADD CONSTRAINT `certification_modele_ibfk_1` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`),
  ADD CONSTRAINT `certification_modele_ibfk_2` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`);

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_1` FOREIGN KEY (`id_aeroport_depart`) REFERENCES `aeroport` (`aeroport_trigramme`),
  ADD CONSTRAINT `ligne_ibfk_2` FOREIGN KEY (`id_aeroport_arrivee`) REFERENCES `aeroport` (`aeroport_trigramme`);

--
-- Contraintes pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD CONSTRAINT `pilote_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `pilote_certification`
--
ALTER TABLE `pilote_certification`
  ADD CONSTRAINT `pilote_certification_ibfk_1` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`),
  ADD CONSTRAINT `pilote_certification_ibfk_2` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `vol`
--
ALTER TABLE `vol`
  ADD CONSTRAINT `vol_ibfk_1` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`),
  ADD CONSTRAINT `vol_ibfk_2` FOREIGN KEY (`id_copilote`) REFERENCES `pilote` (`id_pilote`),
  ADD CONSTRAINT `vol_ibfk_3` FOREIGN KEY (`id_ligne`) REFERENCES `ligne` (`id_ligne`);
