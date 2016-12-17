--
-- Contenu de la table `gh_reservations`
--

INSERT INTO `gh_reservations` (`idReservation`, `idChambre`, `idUtilisateur`, `dateDebut`, `dateFin`, `annulee`) VALUES
(1, 1, 1, '2016-12-06', '2016-12-07', 1),
(2, 2, 1, '2016-12-06', '2016-12-07', 1),
(3, 3, 1, '2016-12-06', '2016-12-07', NULL),
(4, 1, 1, '2016-12-06', '2016-12-07', NULL),
(5, 2, 1, '2016-12-06', '2016-12-07', NULL),
(6, 3, 1, '2016-12-06', '2016-12-30', NULL);
