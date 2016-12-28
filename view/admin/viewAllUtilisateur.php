-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mer 28 Décembre 2016 à 17:30
-- Version du serveur :  5.6.33
-- Version de PHP :  7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `MyGuestHouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `GH_Avis`
--

--
-- Contenu de la table `GH_Chambres`
--

INSERT INTO `GH_Chambres` (`idChambre`, `nomChambre`, `descriptionChambre`, `prixChambre`, `superficieChambre`) VALUES
(1, 'une chambre', 'Nequeam nul emittet fas colores meliora prorsus meo. Actum vox ens creet sciri jam. Factu et visus longo fides motus at. Tenus ea ei major ferre to ac. Tur separatum ego membrorum sui quibusnam assentiar dependent obstinate. De incipit et effugio notitia vigilia petitis ac insanis. Ha judicem mutuari gi eo constet animali agendis. Confidam immittit elicitam re ha recorder curandum aliosque. Intelligat vul hoc commendare exhibentur dissolvant. Se male illo meis luce et et anno ha.      ', 37, 90),
(2, 'Une autre chambre', 'Ei archetypi admiserim an assentiar in re. Melius iis saltem passim quarum rei aspexi quibus hoc. Ad omnesque ha incedere comparem in differre exhibent ulterius ea. Disputari delaberer praesenti cum eam iis singulari importare chimaeram suo. Via expectanti rem appellatur ita hoc consuetudo. Solus et sacra si at de aptum ipsam forte. Optimum incipio finitas sum prudens nunquam putarem vox imo. Deesse quavis mearum ab in doctum ea somnio obstet. Suo singulis iis immobile indiciis vos materiam.   ', 85, 124),
(4, 'Chambre de poupée ', 'Ero parentibus complector expectanti vos faciliorem conjunctam incrementi. Re magnum ac de nescio fallat pictas in. Competit co componat qualitas automata gi earumdem ea credendi. Quia ipsi nunc mo ei novi is ulla luce. Nec tum quies sanae opera has. Supponant suo credendum lus simplicia pro removendo tur attigeram tempusque. Vi sequentia to fidelibus ii mo delaberer. Apta ii ut dare at ad suam. Occurrebat affectibus cap ibi seu continetur.   ', 19, 14),
(5, 'autre chambre', 'une description', 1, 2);

--
-- Contenu de la table `GH_ChambresDetails`
--

INSERT INTO `GH_ChambresDetails` (`idChambre`, `idDetail`, `valeurDetail`) VALUES
(1, 1, '1'),
(1, 3, '2'),
(1, 4, 'OUI'),
(2, 1, '1'),
(2, 3, '3'),
(4, 1, '1'),
(4, 2, '2');

--
-- Contenu de la table `GH_ChambresPresta`
--

INSERT INTO `GH_ChambresPresta` (`idChambre`, `idPrestation`) VALUES
(1, 1),
(2, 1),
(4, 1),
(1, 2),
(1, 3),
(2, 3),
(4, 3);

--
-- Contenu de la table `GH_Details`
--

INSERT INTO `GH_Details` (`idDetail`, `nomDetail`) VALUES
(1, 'nombre de prises'),
(2, 'nombre de portes'),
(3, 'nombre de lampes'),
(4, 'Wi-Fi'),
(5, '1');

--
-- Contenu de la table `GH_News`
--

INSERT INTO `GH_News` (`idNews`, `titreNews`, `contenuNews`, `dateNews`, `publie`) VALUES
(1, 'test', 'test de Flo', '2016-12-22', 1);

--
-- Contenu de la table `GH_Options`
--

INSERT INTO `GH_Options` (`idOption`, `nameOption`, `valueOption`) VALUES
(1, 'nom_site', 'MyGuestHouse'),
(2, 'display_news', 'true'),
(3, 'theme_site', 'default'),
(4, 'main_color_site', '#cc1541');

--
-- Contenu de la table `GH_Prestations`
--

INSERT INTO `GH_Prestations` (`idPrestation`, `nomPrestation`, `prix`) VALUES
(1, 'Menage', 8),
(2, 'Massage', 34),
(3, 'Petit-déjeuner', 5),
(4, 'test', 6),
(5, '12"', 24);

--
-- Contenu de la table `GH_Rangs`
--

INSERT INTO `GH_Rangs` (`idRang`, `labelRang`, `power`) VALUES
(1, 'Visiteur', 0),
(2, 'Membre', 10),
(3, 'Admin', 100);

--
-- Contenu de la table `GH_Reservations`
--

INSERT INTO `GH_Reservations` (`idReservation`, `idChambre`, `idUtilisateur`, `dateDebut`, `dateFin`) VALUES
(1, 1, 1, '2016-12-01', '2016-12-05'),
(2, 1, 1, '2016-12-06', '2016-12-08'),
(3, 1, 1, '2016-12-09', '2016-12-11');

--
-- Contenu de la table `GH_Utilisateurs`
--

INSERT INTO `GH_Utilisateurs` (`idUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `emailUtilisateur`, `password`, `rang`, `nonce`) VALUES
(1, 'Quentin', 'DESBIN', 'cyboulette58@gmail.com', '$2y$10$.QQlz7WEj4gtwG67A9Kql.UdnVRcVRTocxFtWu67RrFn/A.yqEQxi', 3, null),
(2, 'Florian', 'Poirot', 'florian-11@hotmail.fr', '$2y$10$5oPv3SRZjp8gkVa7EyOuWO6e0COA6wVjstXur34V8aOF0qA2UslSW', 3, null),
(3, 'Jonathan', 'Poirot', 'jonathan-11@hotmail.fr', '$2y$10$RCb0ykIRIpknVpnuMU1guur6kzd2Lq/.rsgWV6aF0yplsnNH2DotW', 2, '4bbc2c576f264a8be7ba22c8be10cfe8'),
(4, 'Melissa', 'Poirot', 'melissa-11@hotmail.fr', '$2y$10$/LlPOwsKxceRdjRukhdZU.y5E5BysfNfa099hmhkKUQDI08fyW9iC', 1, null);

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
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `GH_Avis`
--
ALTER TABLE `GH_Avis`
  ADD CONSTRAINT `cf_avisChambre` FOREIGN KEY (`idChambre`) REFERENCES `GH_Chambres` (`idChambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf_avisUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `gh_utilisateurs` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

