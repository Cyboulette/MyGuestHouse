-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 17 Décembre 2016 à 17:37
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `MyGuestHouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `GH_Avis`
--

CREATE TABLE IF NOT EXISTS `GH_Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`idChambre`,`idUtilisateur`),
  KEY `cf_avisUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Chambres`
--

CREATE TABLE IF NOT EXISTS `GH_Chambres` (
  `idChambre` int(11) NOT NULL AUTO_INCREMENT,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL,
  PRIMARY KEY (`idChambre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `GH_Chambres`
--

INSERT INTO `GH_Chambres` (`idChambre`, `nomChambre`, `descriptionChambre`, `prixChambre`, `superficieChambre`) VALUES
(1, 'chambre 1', 'blablablba', 100, 22),
(2, 'chambre 2', 'blablablba', 100, 22),
(3, 'chambre 3', 'blablablba', 100, 22),
(4, 'chambre 4', 'blablablba', 100, 22);

-- --------------------------------------------------------

--
-- Structure de la table `GH_ChambresDetails`
--

CREATE TABLE IF NOT EXISTS `GH_ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL,
  PRIMARY KEY (`idChambre`,`idDetail`),
  KEY `cf_cdDetail` (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_ChambresPresta`
--

CREATE TABLE IF NOT EXISTS `GH_ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idChambre`,`idPrestation`),
  KEY `cf_cpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_ChambresPresta`
--

INSERT INTO `GH_ChambresPresta` (`idChambre`, `idPrestation`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `GH_DatesBloquees`
--

CREATE TABLE IF NOT EXISTS `GH_DatesBloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Details`
--

CREATE TABLE IF NOT EXISTS `GH_Details` (
  `idDetail` int(11) NOT NULL AUTO_INCREMENT,
  `nomDetail` varchar(64) NOT NULL,
  PRIMARY KEY (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Options`
--

CREATE TABLE IF NOT EXISTS `GH_Options` (
  `idOption` int(11) NOT NULL AUTO_INCREMENT,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idOption`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `GH_Options`
--

INSERT INTO `GH_Options` (`idOption`, `nameOption`, `valueOption`) VALUES
(1, 'nom_site', 'MyGuestHouse'),
(2, 'display_news', 'false'),
(3, 'theme_site', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `GH_Prestations`
--

CREATE TABLE IF NOT EXISTS `GH_Prestations` (
  `idPrestation` int(11) NOT NULL AUTO_INCREMENT,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`idPrestation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `GH_Prestations`
--

INSERT INTO `GH_Prestations` (`idPrestation`, `nomPrestation`, `prix`) VALUES
(1, 'repassage', 23),
(2, 'piscine', 50);

-- --------------------------------------------------------

--
-- Structure de la table `GH_Rangs`
--

CREATE TABLE IF NOT EXISTS `GH_Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`idRang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_Rangs`
--

INSERT INTO `GH_Rangs` (`idRang`, `labelRang`, `power`) VALUES
(1, 'Visiteur', 0),
(2, 'Membre', 10),
(3, 'Admin', 100);

-- --------------------------------------------------------

--
-- Structure de la table `GH_Reservations`
--

CREATE TABLE IF NOT EXISTS `GH_Reservations` (
  `idReservation` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `annulee` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `idChambre` (`idChambre`,`idUtilisateur`),
  KEY `cf_resaUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;



-- --------------------------------------------------------

--
-- Structure de la table `GH_ReservationsPrestation`
--

CREATE TABLE IF NOT EXISTS `GH_ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idReservation`,`idPrestation`),
  KEY `cf_rpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Utilisateurs`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `GH_Utilisateurs`
--

INSERT INTO `GH_Utilisateurs` (`idUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `emailUtilisateur`, `password`, `rang`, `nonce`) VALUES
(1, 'Quentin', 'DESBIN', 'cyboulette58@gmail.com', '$2y$10$.QQlz7WEj4gtwG67A9Kql.UdnVRcVRTocxFtWu67RrFn/A.yqEQxi', 3, ''),
(2, 'clement', 'cisterne', 'lamouche444@hotmail.fr', '$2y$10$VJG81fns9YuJIYtPRLqUYuVq1tY/r9Esi6TZ2tjbpF01T5XpitEeO', 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `GH_VisuelsChambres`
--

CREATE TABLE IF NOT EXISTS `GH_VisuelsChambres` (
  `idVisuel` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL,
  PRIMARY KEY (`idVisuel`),
  KEY `idChambre` (`idChambre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
