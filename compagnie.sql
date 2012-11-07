-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 07 Novembre 2012 à 20:38
-- Version du serveur: 5.5.28
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

--
-- Contenu de la table `aeroport`
--

INSERT INTO `aeroport` VALUES('CDG', 'Roissy Charles de Gaulle', 25, 3000);
INSERT INTO `aeroport` VALUES('JFK', 'John F. Kennedy', 35, 3500);
INSERT INTO `aeroport` VALUES('LHR', 'Heathrow', 20, 3000);
INSERT INTO `aeroport` VALUES('NTE', 'Nantes Atlantique', 8, 2000);
INSERT INTO `aeroport` VALUES('ORY', 'Paris Orly', 15, 3000);
INSERT INTO `aeroport` VALUES('SYD', 'Kingsford Smith International Airport', 3, 3962);
INSERT INTO `aeroport` VALUES('YYZ', 'Toronto Pearson', 3, 2500);

-- --------------------------------------------------------

--
-- Structure de la table `aeroport_ville`
--

CREATE TABLE IF NOT EXISTS `aeroport_ville` (
  `aeroport_trigramme` varchar(3) NOT NULL,
  `id_ville` int(11) NOT NULL,
  PRIMARY KEY (`aeroport_trigramme`,`id_ville`),
  KEY `id_aeroport` (`aeroport_trigramme`,`id_ville`),
  KEY `id_ville` (`id_ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `aeroport_ville`
--

INSERT INTO `aeroport_ville` VALUES('CDG', 1);
INSERT INTO `aeroport_ville` VALUES('ORY', 1);
INSERT INTO `aeroport_ville` VALUES('NTE', 2);
INSERT INTO `aeroport_ville` VALUES('LHR', 3);
INSERT INTO `aeroport_ville` VALUES('JFK', 4);
INSERT INTO `aeroport_ville` VALUES('YYZ', 7);
INSERT INTO `aeroport_ville` VALUES('SYD', 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2147483647 ;

--
-- Contenu de la table `avion`
--

INSERT INTO `avion` VALUES(6526, 4, 2500, 300);
INSERT INTO `avion` VALUES(566213564, 1, 200, 800);
INSERT INTO `avion` VALUES(2147483647, 1, 200, 800);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `modele`
--

INSERT INTO `modele` VALUES(1, 'Airbus', 'A380-800', 15200, 300, 450, 600, 800);
INSERT INTO `modele` VALUES(4, 'Airbus', 'A320', 5950, 300, 250, 300, 600);
INSERT INTO `modele` VALUES(5, 'Boeing', '737-600', 5970, 500, 800, 340, 700);
INSERT INTO `modele` VALUES(6, 'Boeing', '737-800', 5765, 800, 500, 280, 300);
INSERT INTO `modele` VALUES(7, 'Airbus', 'A330-300', 10500, 1220, 1500, 300, 500);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) NOT NULL AUTO_INCREMENT,
  `pays_nom` varchar(255) NOT NULL,
  `pays_continent` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` VALUES(1, 'France', 'Europe');
INSERT INTO `pays` VALUES(2, 'Allemagne', 'Europe');
INSERT INTO `pays` VALUES(3, 'Grande Bretagne', 'Europe');
INSERT INTO `pays` VALUES(4, 'Etats-Unis', 'Amérique');
INSERT INTO `pays` VALUES(5, 'Canada', 'Amérique');
INSERT INTO `pays` VALUES(6, 'Mexique', 'Amérique');
INSERT INTO `pays` VALUES(7, 'Russie', 'Asie');
INSERT INTO `pays` VALUES(8, 'Chine', 'Asie');
INSERT INTO `pays` VALUES(9, 'Inde', 'Asie');
INSERT INTO `pays` VALUES(10, 'Japon', 'Asie');
INSERT INTO `pays` VALUES(11, 'Italie', 'Europe');
INSERT INTO `pays` VALUES(12, 'Espagne', 'Europe');
INSERT INTO `pays` VALUES(13, 'Australie', 'Océanie');
INSERT INTO `pays` VALUES(14, 'Nouvelle Zélande', 'Océanie');
INSERT INTO `pays` VALUES(15, 'Suisse', 'Europe');

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
  `ville_nom` varchar(255) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_ville`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `ville`
--

INSERT INTO `ville` VALUES(1, 'Paris', 1);
INSERT INTO `ville` VALUES(2, 'Nantes', 1);
INSERT INTO `ville` VALUES(3, 'London', 3);
INSERT INTO `ville` VALUES(4, 'New York', 4);
INSERT INTO `ville` VALUES(5, 'Boston', 4);
INSERT INTO `ville` VALUES(6, 'Berlin', 2);
INSERT INTO `ville` VALUES(7, 'Toronto', 5);
INSERT INTO `ville` VALUES(8, 'Sydney', 13);
INSERT INTO `ville` VALUES(9, 'Mexico', 6);
INSERT INTO `ville` VALUES(10, 'Moscou', 7);
INSERT INTO `ville` VALUES(11, 'PÃ©kin', 8);
INSERT INTO `ville` VALUES(12, 'Bombay', 9);
INSERT INTO `ville` VALUES(13, 'Tokyo', 10);
INSERT INTO `ville` VALUES(14, 'Rome', 11);
INSERT INTO `ville` VALUES(15, 'Madrid', 12);
INSERT INTO `ville` VALUES(16, 'Berne', 15);
INSERT INTO `ville` VALUES(17, 'Aukland', 14);

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
  ADD CONSTRAINT `aeroport_ville_ibfk_4` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aeroport_ville_ibfk_3` FOREIGN KEY (`aeroport_trigramme`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_2` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_modele`
--
ALTER TABLE `certification_modele`
  ADD CONSTRAINT `certification_modele_ibfk_4` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_modele_ibfk_3` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_4` FOREIGN KEY (`id_aeroport_arrivee`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_ibfk_3` FOREIGN KEY (`id_aeroport_depart`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD CONSTRAINT `pilote_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pilote_certification`
--
ALTER TABLE `pilote_certification`
  ADD CONSTRAINT `pilote_certification_ibfk_4` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pilote_certification_ibfk_3` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD CONSTRAINT `technicien_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_2` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vol`
--
ALTER TABLE `vol`
  ADD CONSTRAINT `vol_ibfk_6` FOREIGN KEY (`id_ligne`) REFERENCES `ligne` (`id_ligne`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_4` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_5` FOREIGN KEY (`id_copilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE;
