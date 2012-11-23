-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 23 Novembre 2012 à 18:10
-- Version du serveur: 5.5.28
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `truc`
--

-- --------------------------------------------------------

--
-- Structure de la table `aeroport`
--

CREATE TABLE IF NOT EXISTS `aeroport` (
  `aeroport_trigramme` varchar(3) NOT NULL,
  `aeroport_nom` varchar(255) NOT NULL,
  `aeroport_nb_pistes` int(11) NOT NULL,
  `aeroport_longueur_piste` int(11) NOT NULL,
  PRIMARY KEY (`aeroport_trigramme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `aeroport_ville`
--

CREATE TABLE IF NOT EXISTS `aeroport_ville` (
  `aeroport_trigramme` varchar(3) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`aeroport_trigramme`,`id_ville`),
  KEY `id_ville` (`id_ville`),
  KEY `aeroport_trigramme` (`aeroport_trigramme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `avion_immatriculation` varchar(32) NOT NULL,
  `id_modele` int(11) NOT NULL,
  `avion_heure_vol_total` int(11) NOT NULL,
  `avion_heure_vol_revision` int(11) NOT NULL,
  PRIMARY KEY (`avion_immatriculation`),
  KEY `id_modele` (`id_modele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `avion`
--

INSERT INTO `avion` (`avion_immatriculation`, `id_modele`, `avion_heure_vol_total`, `avion_heure_vol_revision`) VALUES
('A320-C45', 2, 15000, 800),
('A380-45S', 1, 8000, 320);

-- --------------------------------------------------------

--
-- Structure de la table `certification`
--

CREATE TABLE IF NOT EXISTS `certification` (
  `id_certification` int(11) NOT NULL AUTO_INCREMENT,
  `certification_nom` varchar(64) NOT NULL,
  `certification_validite` int(11) NOT NULL,
  PRIMARY KEY (`id_certification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `certification_modele`
--

CREATE TABLE IF NOT EXISTS `certification_modele` (
  `id_certification` int(11) NOT NULL,
  `id_modele` int(11) NOT NULL,
  PRIMARY KEY (`id_certification`,`id_modele`),
  KEY `id_modele` (`id_modele`),
  KEY `id_certification` (`id_certification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `certification_pilote`
--

CREATE TABLE IF NOT EXISTS `certification_pilote` (
  `id_certification` int(11) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `date_certification` date NOT NULL,
  PRIMARY KEY (`id_certification`),
  KEY `certification_pilote_ibfk_2` (`user_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `client_nom` varchar(255) NOT NULL,
  `client_prenom` varchar(255) NOT NULL,
  `client_telephone` int(10) NOT NULL,
  `client_adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ligne`
--

CREATE TABLE IF NOT EXISTS `ligne` (
  `id_ligne` int(11) NOT NULL AUTO_INCREMENT,
  `trigramme_aeroport_depart` varchar(3) NOT NULL,
  `trigramme_aeroport_arrivee` varchar(3) NOT NULL,
  `ligne_periodicite` enum('unique','journaliere','hebdomadaire','mensuelle') NOT NULL,
  PRIMARY KEY (`id_ligne`),
  KEY `trigramme_aeroport_arrivee` (`trigramme_aeroport_arrivee`),
  KEY `trigramme_aeroport_depart` (`trigramme_aeroport_depart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

CREATE TABLE IF NOT EXISTS `modele` (
  `id_modele` int(11) NOT NULL AUTO_INCREMENT,
  `modele_marque` varchar(255) NOT NULL,
  `modele_reference` varchar(255) NOT NULL,
  `modele_rayon` int(11) NOT NULL,
  `modele_piste_att` int(11) NOT NULL,
  `modele_piste_dec` int(11) NOT NULL,
  `modele_nb_passagers` int(11) NOT NULL,
  `modele_diff_revision` int(11) NOT NULL,
  PRIMARY KEY (`id_modele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `modele`
--

INSERT INTO `modele` (`id_modele`, `modele_marque`, `modele_reference`, `modele_rayon`, `modele_piste_att`, `modele_piste_dec`, `modele_nb_passagers`, `modele_diff_revision`) VALUES
(1, 'Airbus', 'A380-800', 15400, 2200, 2000, 525, 800),
(2, 'Airbus', 'A320 NEO', 6150, 2090, 2000, 180, 900),
(3, 'Boeing', '747-400', 13450, 2500, 2200, 524, 750),
(4, 'Boeing', '747-200', 9700, 2000, 2530, 440, 1000);

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
-- Structure de la table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `reservation_nb_place` int(11) NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_login` varchar(50) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_nom` varchar(255) NOT NULL,
  `user_prenom` varchar(255) NOT NULL,
  `user_adresse` varchar(255) NOT NULL,
  `user_telephone` int(10) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  PRIMARY KEY (`user_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_login`, `user_password`, `user_nom`, `user_prenom`, `user_adresse`, `user_telephone`, `user_role`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'admin', 0, 'admin'),
('direction', 'ef72c37be9d1b9e6e5bbd6ef09448abe', 'direction', 'direction', 'direction', 0, 'direction'),
('drh', '147de4c9d38de7fc9029aafbf0cc25a1', 'drh', 'drh', 'drh', 0, 'drh'),
('pilote', '7e7842781c2cc8a4cb7c037222a2799c', 'pilote', 'pilote', 'pilote', 0, 'pilote');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id_ville` int(11) NOT NULL AUTO_INCREMENT,
  `ville_nom` varchar(255) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `vol`
--

CREATE TABLE IF NOT EXISTS `vol` (
  `id_vol` int(11) NOT NULL AUTO_INCREMENT,
  `id_pilote` varchar(50) NOT NULL,
  `id_copilote` varchar(50) NOT NULL,
  `id_avion` varchar(32) NOT NULL,
  `vol_informations` int(11) NOT NULL,
  `vol_depart_prevu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vol_arrivee_prevue` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_ligne` int(11) NOT NULL,
  `vol_arrivee_effective` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_vol`),
  KEY `id_avion` (`id_avion`),
  KEY `id_copilote` (`id_copilote`),
  KEY `id_ligne` (`id_ligne`),
  KEY `id_pilote` (`id_pilote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `aeroport_ville`
--
ALTER TABLE `aeroport_ville`
  ADD CONSTRAINT `aeroport_ville_ibfk_1` FOREIGN KEY (`aeroport_trigramme`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aeroport_ville_ibfk_2` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_1` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_modele`
--
ALTER TABLE `certification_modele`
  ADD CONSTRAINT `certification_modele_ibfk_1` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_modele_ibfk_2` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_pilote`
--
ALTER TABLE `certification_pilote`
  ADD CONSTRAINT `certification_pilote_ibfk_1` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_pilote_ibfk_2` FOREIGN KEY (`user_login`) REFERENCES `user` (`user_login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_1` FOREIGN KEY (`trigramme_aeroport_depart`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_ibfk_2` FOREIGN KEY (`trigramme_aeroport_arrivee`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vol`
--
ALTER TABLE `vol`
  ADD CONSTRAINT `vol_ibfk_1` FOREIGN KEY (`id_pilote`) REFERENCES `user` (`user_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_2` FOREIGN KEY (`id_copilote`) REFERENCES `user` (`user_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_3` FOREIGN KEY (`id_avion`) REFERENCES `avion` (`avion_immatriculation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_4` FOREIGN KEY (`id_ligne`) REFERENCES `ligne` (`id_ligne`) ON DELETE CASCADE ON UPDATE CASCADE;
