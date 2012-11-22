-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 19 Novembre 2012 à 10:47
-- Version du serveur: 5.5.28
-- Version de PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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

INSERT INTO `aeroport` (`aeroport_trigramme`, `aeroport_nom`, `aeroport_terminaux`, `aeroport_longueur_piste`) VALUES
('CDG', 'Roissy Charles de Gaulle', 25, 3000),
('JFK', 'John F. Kennedy', 35, 3500),
('LHR', 'Heathrow', 20, 3000),
('NTE', 'Nantes Atlantique', 8, 2000),
('ORY', 'Paris Orly', 15, 3000),
('SYD', 'Kingsford Smith International Airport', 3, 3962),
('YYZ', 'Toronto Pearson', 3, 2500);

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

INSERT INTO `aeroport_ville` (`aeroport_trigramme`, `id_ville`) VALUES
('CDG', 1),
('NTE', 1),
('ORY', 1),
('NTE', 2),
('LHR', 3),
('JFK', 4),
('YYZ', 7),
('SYD', 8);

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

INSERT INTO `avion` (`avion_immatriculation`, `id_modele`, `avion_heure_vol_total`, `avion_heure_vol_revision`) VALUES
(6526, 4, 2500, 300),
(566213564, 1, 200, 800),
(2147483647, 1, 200, 800);

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

--
-- Contenu de la table `certification`
--

INSERT INTO `certification` (`id_certification`, `certification_nom`, `certification_validite`) VALUES
(0, 'test2', 12);

-- --------------------------------------------------------

--
-- Structure de la table `certification_modele`
--

CREATE TABLE IF NOT EXISTS `certification_modele` (
  `id_certification` int(11) NOT NULL,
  `id_modele` int(11) NOT NULL,
  PRIMARY KEY (`id_certification`,`id_modele`),
  KEY `id_certification` (`id_certification`,`id_modele`),
  KEY `id_modele` (`id_modele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `certification_modele`
--

INSERT INTO `certification_modele` (`id_certification`, `id_modele`) VALUES
(0, 1),
(0, 4),
(0, 6);

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

INSERT INTO `modele` (`id_modele`, `modele_marque`, `modele_reference`, `modele_rayon`, `modele_piste_att`, `modele_piste_dec`, `modele_nb_passagers`, `modele_diff_revision`) VALUES
(1, 'Airbus', 'A380-800', 15200, 300, 450, 600, 800),
(4, 'Airbus', 'A320', 5950, 300, 250, 300, 600),
(5, 'Boeing', '737-600', 5970, 500, 800, 340, 700),
(6, 'Boeing', '737-800', 5765, 800, 500, 280, 300),
(7, 'Airbus', 'A330-300', 10500, 1220, 1500, 300, 500);

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

INSERT INTO `pays` (`id_pays`, `pays_nom`, `pays_continent`) VALUES
(1, 'France', 'Europe'),
(2, 'Allemagne', 'Europe'),
(3, 'Grande Bretagne', 'Europe'),
(4, 'Etats-Unis', 'AmÃ©rique'),
(5, 'Canada', 'AmÃ©rique'),
(6, 'Mexique', 'AmÃ©rique'),
(7, 'Russie', 'Asie'),
(8, 'Chine', 'Asie'),
(9, 'Inde', 'Asie'),
(10, 'Japon', 'Asie'),
(11, 'Italie', 'Europe'),
(12, 'Espagne', 'Europe'),
(13, 'Australie', 'OcÃ©anie'),
(14, 'Nouvelle ZÃ©lande', 'OcÃ©anie'),
(15, 'Suisse', 'Europe');

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
  `user_login` varchar(100) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_nom` varchar(255) NOT NULL,
  `user_prenom` varchar(255) NOT NULL,
  `user_adresse` varchar(255) NOT NULL,
  `user_telephone` varchar(12) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `user_login`, `user_password`, `user_nom`, `user_prenom`, `user_adresse`, `user_telephone`, `user_role`) VALUES
(1, 'killian', '5f4dcc3b5aa765d61d8327deb882cf99', 'BLAIS', 'Killian', '77 rue du colonel Fabien, 02100Saint Quentin', '0664817396', '');

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

INSERT INTO `ville` (`id_ville`, `ville_nom`, `id_pays`) VALUES
(1, 'Paris', 1),
(2, 'Nantes', 1),
(3, 'London', 3),
(4, 'New York', 4),
(5, 'Boston', 4),
(6, 'Berlin', 2),
(7, 'Toronto', 5),
(8, 'Sydney', 13),
(9, 'Mexico', 6),
(10, 'Moscou', 7),
(11, 'PÃ©kin', 8),
(12, 'Bombay', 9),
(13, 'Tokyo', 10),
(14, 'Rome', 11),
(15, 'Madrid', 12),
(16, 'Berne', 15),
(17, 'Aukland', 14);

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
  ADD CONSTRAINT `aeroport_ville_ibfk_3` FOREIGN KEY (`aeroport_trigramme`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aeroport_ville_ibfk_4` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avion`
--
ALTER TABLE `avion`
  ADD CONSTRAINT `avion_ibfk_2` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `certification_modele`
--
ALTER TABLE `certification_modele`
  ADD CONSTRAINT `certification_modele_ibfk_3` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certification_modele_ibfk_4` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_3` FOREIGN KEY (`id_aeroport_depart`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_ibfk_4` FOREIGN KEY (`id_aeroport_arrivee`) REFERENCES `aeroport` (`aeroport_trigramme`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD CONSTRAINT `pilote_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pilote_certification`
--
ALTER TABLE `pilote_certification`
  ADD CONSTRAINT `pilote_certification_ibfk_3` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pilote_certification_ibfk_4` FOREIGN KEY (`id_certification`) REFERENCES `certification` (`id_certification`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `vol_ibfk_4` FOREIGN KEY (`id_pilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_5` FOREIGN KEY (`id_copilote`) REFERENCES `pilote` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vol_ibfk_6` FOREIGN KEY (`id_ligne`) REFERENCES `ligne` (`id_ligne`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
