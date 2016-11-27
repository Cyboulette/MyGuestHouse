-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Ven 04 Novembre 2016 à 13:13
-- Version du serveur :  5.6.33
-- Version de PHP :  7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `MyGuestHouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `Avis`
--

CREATE TABLE `GH_Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Chambres`
--

CREATE TABLE `GH_Chambres` (
  `idChambre` int(11) NOT NULL,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ChambresDetails`
--

CREATE TABLE `GH_ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ChambresPresta`
--

CREATE TABLE `GH_ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Details`
--

CREATE TABLE `GH_Details` (
  `idDetail` int(11) NOT NULL,
  `nomDetail` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Prestations`
--

CREATE TABLE `GH_Prestations` (
  `idPrestation` int(11) NOT NULL,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Rangs`
--

CREATE TABLE `GH_Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Reservations`
--

CREATE TABLE `GH_Reservations` (
  `idReservation` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ReservationsPrestation`
--

CREATE TABLE `GH_ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `GH_Utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `prenomUtilisateur` varchar(32) NOT NULL,
  `nomUtilisateur` varchar(32) NOT NULL,
  `emailUtilisateur` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rang` int(11) NOT NULL,
  `nonce` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `VisuelsChambres`
--

CREATE TABLE `GH_VisuelsChambres` (
  `idVisuel` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DatesBloquees`
--

CREATE TABLE `GH_DatesBloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Avis`
--
ALTER TABLE `GH_Avis`
  ADD PRIMARY KEY (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_avisUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `Chambres`
--
ALTER TABLE `GH_Chambres`
  ADD PRIMARY KEY (`idChambre`);

--
-- Index pour la table `ChambresDetails`
--
ALTER TABLE `GH_ChambresDetails`
  ADD PRIMARY KEY (`idChambre`,`idDetail`),
  ADD KEY `cf_cdDetail` (`idDetail`);

--
-- Index pour la table `ChambresPresta`
--
ALTER TABLE `GH_ChambresPresta`
  ADD PRIMARY KEY (`idChambre`,`idPrestation`),
  ADD KEY `cf_cpPrestation` (`idPrestation`);

--
-- Index pour la table `Details`
--
ALTER TABLE `GH_Details`
  ADD PRIMARY KEY (`idDetail`);

--
-- Index pour la table `Prestations`
--
ALTER TABLE `GH_Prestations`
  ADD PRIMARY KEY (`idPrestation`);

--
-- Index pour la table `Rangs`
--
ALTER TABLE `GH_Rangs`
  ADD PRIMARY KEY (`idRang`);

--
-- Index pour la table `Reservations`
--
ALTER TABLE `GH_Reservations`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idChambre` (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_resaUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `ReservationsPrestation`
--
ALTER TABLE `GH_ReservationsPrestation`
  ADD PRIMARY KEY (`idReservation`,`idPrestation`),
  ADD KEY `cf_rpPrestation` (`idPrestation`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `GH_Utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `rang` (`rang`);

--
-- Index pour la table `VisuelsChambres`
--
ALTER TABLE `GH_VisuelsChambres`
  ADD PRIMARY KEY (`idVisuel`),
  ADD KEY `idChambre` (`idChambre`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Reservations`
--
ALTER TABLE `GH_Reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Avis`
--
ALTER TABLE `GH_Avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ChambresDetails`
--
ALTER TABLE `GH_ChambresDetails`
  ADD CONSTRAINT `cf_cdChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cdDetail` FOREIGN KEY (`idDetail`) REFERENCES `GH_Details` (`idDetail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ChambresPresta`
--
ALTER TABLE `GH_ChambresPresta`
  ADD CONSTRAINT `cf_cpChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Reservations`
--
ALTER TABLE `GH_Reservations`
  ADD CONSTRAINT `cf_resaChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_resaUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `GH_Utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ReservationsPrestation`
--
ALTER TABLE `GH_ReservationsPrestation`
  ADD CONSTRAINT `cf_rpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `GH_Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_rpReservation` FOREIGN KEY (`idReservation`) REFERENCES `GH_Reservations` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `GH_Utilisateurs`
  ADD CONSTRAINT `cf_rangUtilisateur` FOREIGN KEY (`rang`) REFERENCES `GH_Rangs` (`idRang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `VisuelsChambres`
--
ALTER TABLE `GH_VisuelsChambres`
  ADD CONSTRAINT `cf_visuelChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------

--
-- Déclencheurs
--

-- Déclencheur pour le nombre maximum ed chambres

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
DELIMITER $$
