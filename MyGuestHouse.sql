-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 29 Novembre 2016 à 12:20
-- Version du serveur: 5.1.73
-- Version de PHP: 5.5.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Avis`
--

DROP TABLE IF EXISTS `GH_Avis`;
CREATE TABLE IF NOT EXISTS `GH_Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`idChambre`,`idUtilisateur`),
  KEY `cf_avisUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_Avis`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Chambres`
--

DROP TABLE IF EXISTS `GH_Chambres`;
CREATE TABLE IF NOT EXISTS `GH_Chambres` (
  `idChambre` int(11) NOT NULL AUTO_INCREMENT,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL,
  PRIMARY KEY (`idChambre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_Chambres`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_ChambresDetails`
--

DROP TABLE IF EXISTS `GH_ChambresDetails`;
CREATE TABLE IF NOT EXISTS `GH_ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL,
  PRIMARY KEY (`idChambre`,`idDetail`),
  KEY `cf_cdDetail` (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_ChambresDetails`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_ChambresPresta`
--

DROP TABLE IF EXISTS `GH_ChambresPresta`;
CREATE TABLE IF NOT EXISTS `GH_ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idChambre`,`idPrestation`),
  KEY `cf_cpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_ChambresPresta`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_DatesBloquees`
--

DROP TABLE IF EXISTS `GH_DatesBloquees`;
CREATE TABLE IF NOT EXISTS `GH_DatesBloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_DatesBloquees`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Details`
--

DROP TABLE IF EXISTS `GH_Details`;
CREATE TABLE IF NOT EXISTS `GH_Details` (
  `idDetail` int(11) NOT NULL AUTO_INCREMENT,
  `nomDetail` varchar(64) NOT NULL,
  PRIMARY KEY (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_Details`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Prestations`
--

DROP TABLE IF EXISTS `GH_Prestations`;
CREATE TABLE IF NOT EXISTS `GH_Prestations` (
  `idPrestation` int(11) NOT NULL AUTO_INCREMENT,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_Prestations`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Rangs`
--

DROP TABLE IF EXISTS `GH_Rangs`;
CREATE TABLE IF NOT EXISTS `GH_Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`idRang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_Rangs`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Reservations`
--

DROP TABLE IF EXISTS `GH_Reservations`;
CREATE TABLE IF NOT EXISTS `GH_Reservations` (
  `idReservation` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `idChambre` (`idChambre`,`idUtilisateur`),
  KEY `cf_resaUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_Reservations`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_ReservationsPrestation`
--

DROP TABLE IF EXISTS `GH_ReservationsPrestation`;
CREATE TABLE IF NOT EXISTS `GH_ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idReservation`,`idPrestation`),
  KEY `cf_rpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_ReservationsPrestation`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_Utilisateurs`
--

DROP TABLE IF EXISTS `GH_Utilisateurs`;
CREATE TABLE IF NOT EXISTS `GH_Utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `prenomUtilisateur` varchar(32) NOT NULL,
  `nomUtilisateur` varchar(32) NOT NULL,
  `emailUtilisateur` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rang` int(11) NOT NULL,
  `nonce` varchar(100) NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  KEY `rang` (`rang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_Utilisateurs`
--


-- --------------------------------------------------------

--
-- Structure de la table `GH_VisuelsChambres`
--

DROP TABLE IF EXISTS `GH_VisuelsChambres`;
CREATE TABLE IF NOT EXISTS `GH_VisuelsChambres` (
  `idVisuel` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL,
  PRIMARY KEY (`idVisuel`),
  KEY `idChambre` (`idChambre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `GH_VisuelsChambres`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `GH_Avis`
--
ALTER TABLE `GH_Avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `GH_ChambresDetails`
--
ALTER TABLE `GH_ChambresDetails`
  ADD CONSTRAINT `cf_cdChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cdDetail` FOREIGN KEY (`idDetail`) REFERENCES `GH_Details` (`idDetail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GH_ChambresPresta`
--
ALTER TABLE `GH_ChambresPresta`
  ADD CONSTRAINT `cf_cpChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GH_Reservations`
--
ALTER TABLE `GH_Reservations`
  ADD CONSTRAINT `cf_resaChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_resaUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GH_ReservationsPrestation`
--
ALTER TABLE `GH_ReservationsPrestation`
  ADD CONSTRAINT `cf_rpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_rpReservation` FOREIGN KEY (`idReservation`) REFERENCES `GH_Reservations` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GH_Utilisateurs`
--
ALTER TABLE `GH_Utilisateurs`
  ADD CONSTRAINT `cf_rangUtilisateur` FOREIGN KEY (`rang`) REFERENCES `GH_Rangs` (`idRang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `GH_VisuelsChambres`
--
ALTER TABLE `GH_VisuelsChambres`
  ADD CONSTRAINT `cf_visuelChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE;


-- --------------------------------------------------------

/* Déclencheurs
DELIMITER $$

CREATE TRIGGER `tg_chambresMax`
BEFORE INSERT ON `GH_CHAMBRES` FOR EACH ROW

BEGIN

DECLARE v_nbChambres int;

SELECT COUNT(*) INTO v_nbChambres
FROM GH_CHambres;

IF v_nbChambres > 4 THEN
RAISE_APPLICATION_ERROR(-20004, "Vous ne pouvez pas avoir plus de cinq chambres !");

ENDIF;

END;$$
DELIMITER$$

--
-- Déclencheur pour le nombre de clients maximum
--

DELIMITER $$

CREATE TRIGGER `tg_clientsMax`
BEFORE INSERT ON `GH_Reservations` FOR EACH ROW

BEGIN

DECLARE v_nbClients int;

SELECT COUNT(*) INTO v_nbClients
FROM GH_Réservations;
WHERE dateDebut <= :new.dateFin AND dateFin >= :new.dateDebut;

IF v_nbClients > 14 THEN
RAISE_APPLICATION_ERROR(-20004, "Vous ne pouvez pas loger plus de quinze clients à la fois !");

ENDIF;

END;
DELIMITER $$ */