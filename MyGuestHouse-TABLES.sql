SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `GH_Avis`;
CREATE TABLE `GH_Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Chambres`;
CREATE TABLE `GH_Chambres` (
  `idChambre` int(11) NOT NULL,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_ChambresDetails`;
CREATE TABLE `GH_ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_ChambresPresta`;
CREATE TABLE `GH_ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_DatesBloquees`;
CREATE TABLE `GH_DatesBloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Details`;
CREATE TABLE `GH_Details` (
  `idDetail` int(11) NOT NULL,
  `nomDetail` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_News`;
CREATE TABLE `GH_News` (
  `idNews` int(11) NOT NULL,
  `titreNews` text NOT NULL,
  `contenuNews` longtext NOT NULL,
  `dateNews` date NOT NULL,
  `publie` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Options`;
CREATE TABLE `GH_Options` (
  `idOption` int(11) NOT NULL,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Prestations`;
CREATE TABLE `GH_Prestations` (
  `idPrestation` int(11) NOT NULL,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Rangs`;
CREATE TABLE `GH_Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Reservations`;
CREATE TABLE `GH_Reservations` (
  `idReservation` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `annulee` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_ReservationsPrestation`;
CREATE TABLE `GH_ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Slides`;
CREATE TABLE `GH_Slides` (
  `idSlide` int(11) NOT NULL,
  `urlSlide` varchar(255) NOT NULL,
  `textSlide` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_Utilisateurs`;
CREATE TABLE `GH_Utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `prenomUtilisateur` varchar(32) NOT NULL,
  `nomUtilisateur` varchar(32) NOT NULL,
  `emailUtilisateur` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rang` int(11) NOT NULL,
  `nonce` varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `GH_VisuelsChambres`;
CREATE TABLE `GH_VisuelsChambres` (
  `idVisuel` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `GH_Avis`
  ADD PRIMARY KEY (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_avisUtilisateur` (`idUtilisateur`);

ALTER TABLE `GH_Chambres`
  ADD PRIMARY KEY (`idChambre`);

ALTER TABLE `GH_ChambresDetails`
  ADD PRIMARY KEY (`idChambre`,`idDetail`),
  ADD KEY `cf_cdDetail` (`idDetail`);

ALTER TABLE `GH_ChambresPresta`
  ADD PRIMARY KEY (`idChambre`,`idPrestation`),
  ADD KEY `cf_cpPrestation` (`idPrestation`);

ALTER TABLE `GH_Details`
  ADD PRIMARY KEY (`idDetail`);

ALTER TABLE `GH_News`
  ADD PRIMARY KEY (`idNews`);

ALTER TABLE `GH_Options`
  ADD PRIMARY KEY (`idOption`);

ALTER TABLE `GH_Prestations`
  ADD PRIMARY KEY (`idPrestation`);

ALTER TABLE `GH_Rangs`
  ADD PRIMARY KEY (`idRang`);

ALTER TABLE `GH_Reservations`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idChambre` (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_resaUtilisateur` (`idUtilisateur`);

ALTER TABLE `GH_ReservationsPrestation`
  ADD PRIMARY KEY (`idReservation`,`idPrestation`),
  ADD KEY `cf_rpPrestation` (`idPrestation`);

ALTER TABLE `GH_Slides`
  ADD PRIMARY KEY (`idSlide`);

ALTER TABLE `GH_Utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `rang` (`rang`);

ALTER TABLE `GH_VisuelsChambres`
  ADD PRIMARY KEY (`idVisuel`),
  ADD KEY `idChambre` (`idChambre`);


ALTER TABLE `GH_Chambres`
  MODIFY `idChambre` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Details`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_News`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Options`
  MODIFY `idOption` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Prestations`
  MODIFY `idPrestation` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Slides`
  MODIFY `idSlide` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_Utilisateurs`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `GH_VisuelsChambres`
  MODIFY `idVisuel` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `GH_Avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_ChambresDetails`
  ADD CONSTRAINT `cf_cdChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cdDetail` FOREIGN KEY (`idDetail`) REFERENCES `GH_Details` (`idDetail`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_ChambresPresta`
  ADD CONSTRAINT `cf_cpChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_Reservations`
  ADD CONSTRAINT `cf_resaChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_resaUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_ReservationsPrestation`
  ADD CONSTRAINT `cf_rpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_rpReservation` FOREIGN KEY (`idReservation`) REFERENCES `GH_Reservations` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_Utilisateurs`
  ADD CONSTRAINT `cf_rangUtilisateur` FOREIGN KEY (`rang`) REFERENCES `GH_Rangs` (`idRang`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `GH_VisuelsChambres`
  ADD CONSTRAINT `cf_visuelChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE;

-- LES RANGS DOIVENT ÊTRE DANS LA BDD QUOIQU'IL ARRIVE

INSERT INTO `GH_Rangs` (`idRang`, `labelRang`, `power`) VALUES
(1, 'Visiteur', 0),
(2, 'Membre', 10),
(3, 'Admin', 100);

-- LES OPTIONS AUSSI

INSERT INTO `GH_Options` (`idOption`, `nameOption`, `valueOption`) VALUES
(2, 'display_news', 'true'),
(3, 'theme_site', 'default'),
(4, 'main_color_site', '#ad1717');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
