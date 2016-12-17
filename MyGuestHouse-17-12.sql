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
-- Base de données :  `myguesthouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `gh_avis`
--

CREATE TABLE IF NOT EXISTS `gh_avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`idChambre`,`idUtilisateur`),
  KEY `cf_avisUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gh_chambres`
--

CREATE TABLE IF NOT EXISTS `gh_chambres` (
  `idChambre` int(11) NOT NULL AUTO_INCREMENT,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL,
  PRIMARY KEY (`idChambre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `gh_chambres`
--

INSERT INTO `gh_chambres` (`idChambre`, `nomChambre`, `descriptionChambre`, `prixChambre`, `superficieChambre`) VALUES
(1, 'chambre 1', 'blablablba', 100, 22),
(2, 'chambre 2', 'blablablba', 100, 22),
(3, 'chambre 3', 'blablablba', 100, 22),
(4, 'chambre 4', 'blablablba', 100, 22);

-- --------------------------------------------------------

--
-- Structure de la table `gh_chambresdetails`
--

CREATE TABLE IF NOT EXISTS `gh_chambresdetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL,
  PRIMARY KEY (`idChambre`,`idDetail`),
  KEY `cf_cdDetail` (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gh_chambrespresta`
--

CREATE TABLE IF NOT EXISTS `gh_chambrespresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idChambre`,`idPrestation`),
  KEY `cf_cpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gh_chambrespresta`
--

INSERT INTO `gh_chambrespresta` (`idChambre`, `idPrestation`) VALUES
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
-- Structure de la table `gh_datesbloquees`
--

CREATE TABLE IF NOT EXISTS `gh_datesbloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gh_details`
--

CREATE TABLE IF NOT EXISTS `gh_details` (
  `idDetail` int(11) NOT NULL AUTO_INCREMENT,
  `nomDetail` varchar(64) NOT NULL,
  PRIMARY KEY (`idDetail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `gh_options`
--

CREATE TABLE IF NOT EXISTS `gh_options` (
  `idOption` int(11) NOT NULL AUTO_INCREMENT,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idOption`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `gh_options`
--

INSERT INTO `gh_options` (`idOption`, `nameOption`, `valueOption`) VALUES
(1, 'nom_site', 'MyGuestHouse'),
(2, 'display_news', 'false'),
(3, 'theme_site', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `gh_prestations`
--

CREATE TABLE IF NOT EXISTS `gh_prestations` (
  `idPrestation` int(11) NOT NULL AUTO_INCREMENT,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`idPrestation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `gh_prestations`
--

INSERT INTO `gh_prestations` (`idPrestation`, `nomPrestation`, `prix`) VALUES
(1, 'repassage', 23),
(2, 'piscine', 50);

-- --------------------------------------------------------

--
-- Structure de la table `gh_rangs`
--

CREATE TABLE IF NOT EXISTS `gh_rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`idRang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gh_rangs`
--

INSERT INTO `gh_rangs` (`idRang`, `labelRang`, `power`) VALUES
(1, 'Visiteur', 0),
(2, 'Membre', 10),
(3, 'Admin', 100);

-- --------------------------------------------------------

--
-- Structure de la table `gh_reservations`
--

CREATE TABLE IF NOT EXISTS `gh_reservations` (
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
-- Structure de la table `gh_reservationsprestation`
--

CREATE TABLE IF NOT EXISTS `gh_reservationsprestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL,
  PRIMARY KEY (`idReservation`,`idPrestation`),
  KEY `cf_rpPrestation` (`idPrestation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gh_utilisateurs`
--

CREATE TABLE IF NOT EXISTS `gh_utilisateurs` (
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
-- Contenu de la table `gh_utilisateurs`
--

INSERT INTO `gh_utilisateurs` (`idUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `emailUtilisateur`, `password`, `rang`, `nonce`) VALUES
(1, 'Quentin', 'DESBIN', 'cyboulette58@gmail.com', '$2y$10$.QQlz7WEj4gtwG67A9Kql.UdnVRcVRTocxFtWu67RrFn/A.yqEQxi', 3, ''),
(2, 'clement', 'cisterne', 'lamouche444@hotmail.fr', '$2y$10$VJG81fns9YuJIYtPRLqUYuVq1tY/r9Esi6TZ2tjbpF01T5XpitEeO', 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `gh_visuelschambres`
--

CREATE TABLE IF NOT EXISTS `gh_visuelschambres` (
  `idVisuel` int(11) NOT NULL AUTO_INCREMENT,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL,
  PRIMARY KEY (`idVisuel`),
  KEY `idChambre` (`idChambre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `gh_avis`
--
ALTER TABLE `gh_avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `gh_chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `gh_utilisateurs` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `gh_chambresdetails`
--
ALTER TABLE `gh_chambresdetails`
  ADD CONSTRAINT `cf_cdChambre` FOREIGN KEY (`idChambre`) REFERENCES `gh_chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cdDetail` FOREIGN KEY (`idDetail`) REFERENCES `gh_details` (`idDetail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gh_chambrespresta`
--
ALTER TABLE `gh_chambrespresta`
  ADD CONSTRAINT `cf_cpChambre` FOREIGN KEY (`idChambre`) REFERENCES `gh_chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `gh_prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gh_reservations`
--
ALTER TABLE `gh_reservations`
  ADD CONSTRAINT `cf_resaChambre` FOREIGN KEY (`idChambre`) REFERENCES `gh_chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_resaUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `gh_utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gh_reservationsprestation`
--
ALTER TABLE `gh_reservationsprestation`
  ADD CONSTRAINT `cf_rpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `gh_prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_rpReservation` FOREIGN KEY (`idReservation`) REFERENCES `gh_reservations` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gh_utilisateurs`
--
ALTER TABLE `gh_utilisateurs`
  ADD CONSTRAINT `cf_rangUtilisateur` FOREIGN KEY (`rang`) REFERENCES `gh_rangs` (`idRang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gh_visuelschambres`
--
ALTER TABLE `gh_visuelschambres`
  ADD CONSTRAINT `cf_visuelChambre` FOREIGN KEY (`idChambre`) REFERENCES `gh_chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
