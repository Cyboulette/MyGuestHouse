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
-- Base de données :  `MyGestHouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `Avis`
--

CREATE TABLE `Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Chambres`
--

CREATE TABLE `Chambres` (
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

CREATE TABLE `ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ChambresPresta`
--

CREATE TABLE `ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Structure de la table `Details`
--

CREATE TABLE `Details` (
  `idDetail` int(11) NOT NULL,
  `nomDetail` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Prestations`
--

CREATE TABLE `Prestations` (
  `idPrestation` int(11) NOT NULL,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Rangs`
--

CREATE TABLE `Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Reservations`
--

CREATE TABLE `Reservations` (
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

CREATE TABLE `ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `prenomUtilisateur` varchar(32) NOT NULL,
  `nomUtlisateur` varchar(32) NOT NULL,
  `emailUtilisateur` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `rang` int(11) NOT NULL,
  `nonce` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `VisuelsChambres`
--

CREATE TABLE `VisuelsChambres` (
  `idVisuel` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD PRIMARY KEY (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_avisUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `Chambres`
--
ALTER TABLE `Chambres`
  ADD PRIMARY KEY (`idChambre`);

--
-- Index pour la table `ChambresDetails`
--
ALTER TABLE `ChambresDetails`
  ADD PRIMARY KEY (`idChambre`,`idDetail`),
  ADD KEY `cf_cdDetail` (`idDetail`);

--
-- Index pour la table `ChambresPresta`
--
ALTER TABLE `ChambresPresta`
  ADD PRIMARY KEY (`idChambre`,`idPrestation`),
  ADD KEY `cf_cpPrestation` (`idPrestation`);

--
-- Index pour la table `Details`
--
ALTER TABLE `Details`
  ADD PRIMARY KEY (`idDetail`);

--
-- Index pour la table `Prestations`
--
ALTER TABLE `Prestations`
  ADD PRIMARY KEY (`idPrestation`);

--
-- Index pour la table `Rangs`
--
ALTER TABLE `Rangs`
  ADD PRIMARY KEY (`idRang`);

--
-- Index pour la table `Reservations`
--
ALTER TABLE `Reservations`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idChambre` (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_resaUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `ReservationsPrestation`
--
ALTER TABLE `ReservationsPrestation`
  ADD PRIMARY KEY (`idReservation`,`idPrestation`),
  ADD KEY `cf_rpPrestation` (`idPrestation`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `rang` (`rang`);

--
-- Index pour la table `VisuelsChambres`
--
ALTER TABLE `VisuelsChambres`
  ADD PRIMARY KEY (`idVisuel`),
  ADD KEY `idChambre` (`idChambre`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Reservations`
--
ALTER TABLE `Reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ChambresDetails`
--
ALTER TABLE `ChambresDetails`
  ADD CONSTRAINT `cf_cdChambre` FOREIGN KEY (`idChambre`) REFERENCES `Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cdDetail` FOREIGN KEY (`idDetail`) REFERENCES `Details` (`idDetail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ChambresPresta`
--
ALTER TABLE `ChambresPresta`
  ADD CONSTRAINT `cf_cpChambre` FOREIGN KEY (`idChambre`) REFERENCES `Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_cpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Reservations`
--
ALTER TABLE `Reservations`
  ADD CONSTRAINT `cf_resaChambre` FOREIGN KEY (`idChambre`) REFERENCES `Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_resaUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ReservationsPrestation`
--
ALTER TABLE `ReservationsPrestation`
  ADD CONSTRAINT `cf_rpPrestation` FOREIGN KEY (`idPrestation`) REFERENCES `Prestations` (`idPrestation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_rpReservation` FOREIGN KEY (`idReservation`) REFERENCES `Reservations` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD CONSTRAINT `cf_rangUtilisateur` FOREIGN KEY (`rang`) REFERENCES `Rangs` (`idRang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `VisuelsChambres`
--
ALTER TABLE `VisuelsChambres`
  ADD CONSTRAINT `cf_visuelChambre` FOREIGN KEY (`idChambre`) REFERENCES `Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE;
