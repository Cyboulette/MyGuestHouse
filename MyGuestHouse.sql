-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 19 Décembre 2016 à 13:24
-- Version du serveur :  5.7.16-0ubuntu0.16.04.1
-- Version de PHP :  7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `MyGuestHouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `GH_Avis`
--

CREATE TABLE `GH_Avis` (
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Chambres`
--

CREATE TABLE `GH_Chambres` (
  `idChambre` int(11) NOT NULL,
  `nomChambre` varchar(32) NOT NULL,
  `descriptionChambre` text NOT NULL,
  `prixChambre` float NOT NULL,
  `superficieChambre` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `GH_ChambresDetails` (
  `idChambre` int(11) NOT NULL,
  `idDetail` int(11) NOT NULL,
  `valeurDetail` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_ChambresPresta`
--

CREATE TABLE `GH_ChambresPresta` (
  `idChambre` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
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

CREATE TABLE `GH_DatesBloquees` (
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Details`
--

CREATE TABLE `GH_Details` (
  `idDetail` int(11) NOT NULL,
  `nomDetail` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_News`
--

CREATE TABLE `GH_News` (
  `idNews` int(11) NOT NULL,
  `titreNews` text NOT NULL,
  `contenuNews` longtext NOT NULL,
  `dateNews` date NOT NULL,
  `publie` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_News`
--

INSERT INTO `GH_News` (`idNews`, `titreNews`, `contenuNews`, `dateNews`, `publie`) VALUES
(1, 'Bienvenue sur MyGuestHouse', '[grand]Bienvenue à vous ![/grand]\r\nL\'installation est un grand [b]succès ![/b]\r\nVous pouvez maintenant accéder à  [lien url=index.php?controller=admin&amp;action=index]l\'administration[/lien] avec le compte crée lors de l\'installation et supprimer cette actualité de présentation.\r\n\r\n[b][u]Exemple de BBCODE :[/u][/b]\r\n[b]Gras[/b]\r\n[i]Italique[/i]\r\n[u]Souligné[/u]\r\n[lien url=https://google.fr/]Lien[/lien]\r\n[grand]Grand[/grand]\r\n[moyen]Moyen[/moyen]\r\n[petit]Petit[/petit]', '2016-12-19', 1);

-- --------------------------------------------------------

--
-- Structure de la table `GH_Options`
--

CREATE TABLE `GH_Options` (
  `idOption` int(11) NOT NULL,
  `nameOption` varchar(255) NOT NULL,
  `valueOption` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `GH_Options`
--

INSERT INTO `GH_Options` (`idOption`, `nameOption`, `valueOption`) VALUES
(1, 'nom_site', 'MyGuestHouse'),
(2, 'display_news', 'true'),
(3, 'theme_site', 'default'),
(4, 'main_color_site', '#ad1717');

-- --------------------------------------------------------

--
-- Structure de la table `GH_Prestations`
--

CREATE TABLE `GH_Prestations` (
  `idPrestation` int(11) NOT NULL,
  `nomPrestation` varchar(32) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `GH_Rangs` (
  `idRang` int(11) NOT NULL,
  `labelRang` varchar(64) NOT NULL,
  `power` int(11) NOT NULL
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

CREATE TABLE `GH_Reservations` (
  `idReservation` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `annulee` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_ReservationsPrestation`
--

CREATE TABLE `GH_ReservationsPrestation` (
  `idReservation` int(11) NOT NULL,
  `idPrestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GH_Utilisateurs`
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

CREATE TABLE `GH_VisuelsChambres` (
  `idVisuel` int(11) NOT NULL,
  `idChambre` int(11) NOT NULL,
  `urlVisuel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `GH_Avis`
--
ALTER TABLE `GH_Avis`
  ADD PRIMARY KEY (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_avisUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `GH_Chambres`
--
ALTER TABLE `GH_Chambres`
  ADD PRIMARY KEY (`idChambre`);

--
-- Index pour la table `GH_ChambresDetails`
--
ALTER TABLE `GH_ChambresDetails`
  ADD PRIMARY KEY (`idChambre`,`idDetail`),
  ADD KEY `cf_cdDetail` (`idDetail`);

--
-- Index pour la table `GH_ChambresPresta`
--
ALTER TABLE `GH_ChambresPresta`
  ADD PRIMARY KEY (`idChambre`,`idPrestation`),
  ADD KEY `cf_cpPrestation` (`idPrestation`);

--
-- Index pour la table `GH_Details`
--
ALTER TABLE `GH_Details`
  ADD PRIMARY KEY (`idDetail`);

--
-- Index pour la table `GH_News`
--
ALTER TABLE `GH_News`
  ADD PRIMARY KEY (`idNews`);

--
-- Index pour la table `GH_Options`
--
ALTER TABLE `GH_Options`
  ADD PRIMARY KEY (`idOption`);

--
-- Index pour la table `GH_Prestations`
--
ALTER TABLE `GH_Prestations`
  ADD PRIMARY KEY (`idPrestation`);

--
-- Index pour la table `GH_Rangs`
--
ALTER TABLE `GH_Rangs`
  ADD PRIMARY KEY (`idRang`);

--
-- Index pour la table `GH_Reservations`
--
ALTER TABLE `GH_Reservations`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idChambre` (`idChambre`,`idUtilisateur`),
  ADD KEY `cf_resaUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `GH_ReservationsPrestation`
--
ALTER TABLE `GH_ReservationsPrestation`
  ADD PRIMARY KEY (`idReservation`,`idPrestation`),
  ADD KEY `cf_rpPrestation` (`idPrestation`);

--
-- Index pour la table `GH_Utilisateurs`
--
ALTER TABLE `GH_Utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `rang` (`rang`);

--
-- Index pour la table `GH_VisuelsChambres`
--
ALTER TABLE `GH_VisuelsChambres`
  ADD PRIMARY KEY (`idVisuel`),
  ADD KEY `idChambre` (`idChambre`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `GH_Chambres`
--
ALTER TABLE `GH_Chambres`
  MODIFY `idChambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `GH_Details`
--
ALTER TABLE `GH_Details`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `GH_News`
--
ALTER TABLE `GH_News`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `GH_Options`
--
ALTER TABLE `GH_Options`
  MODIFY `idOption` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `GH_Prestations`
--
ALTER TABLE `GH_Prestations`
  MODIFY `idPrestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `GH_Reservations`
--
ALTER TABLE `GH_Reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `GH_Utilisateurs`
--
ALTER TABLE `GH_Utilisateurs`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `GH_VisuelsChambres`
--
ALTER TABLE `GH_VisuelsChambres`
  MODIFY `idVisuel` int(11) NOT NULL AUTO_INCREMENT;
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

--
-- Structure de la table `GH_Slides`
--

DROP TABLE IF EXISTS `GH_Slides`;
CREATE TABLE `GH_Slides` (
  `idSlide` int(11) NOT NULL,
  `urlSlide` varchar(255) NOT NULL,
  `textSlide` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `GH_Slides`
--
ALTER TABLE `GH_Slides`
  ADD PRIMARY KEY (`idSlide`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `GH_Slides`
--
ALTER TABLE `GH_Slides`
  MODIFY `idSlide` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
