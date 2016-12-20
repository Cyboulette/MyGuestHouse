SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO `GH_Chambres` (`idChambre`, `nomChambre`, `descriptionChambre`, `prixChambre`, `superficieChambre`) VALUES
(1, 'chambre 1', 'blablablba', 100, 22),
(2, 'chambre 2', 'blablablba', 100, 22),
(3, 'chambre 3', 'blablablba', 100, 22),
(4, 'chambre 4', 'blablablba', 100, 22);

INSERT INTO `GH_ChambresPresta` (`idChambre`, `idPrestation`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2);

INSERT INTO `GH_News` (`idNews`, `titreNews`, `contenuNews`, `dateNews`, `publie`) VALUES
(1, 'Bienvenue sur MyGuestHouse', '[grand]Bienvenue à vous ![/grand]\r\nL\'installation est un grand [b]succès ![/b]\r\nVous pouvez maintenant accéder à  [lien url=index.php?controller=admin&amp;action=index]l\'administration[/lien] avec le compte crée lors de l\'installation et supprimer cette actualité de présentation.\r\n\r\n[b][u]Exemple de BBCODE :[/u][/b]\r\n[b]Gras[/b]\r\n[i]Italique[/i]\r\n[u]Souligné[/u]\r\n[lien url=https://google.fr/]Lien[/lien]\r\n[grand]Grand[/grand]\r\n[moyen]Moyen[/moyen]\r\n[petit]Petit[/petit]', '2016-12-19', 1);

INSERT INTO `GH_Options` (`idOption`, `nameOption`, `valueOption`) VALUES
(1, 'nom_site', 'MyGuestHouse'),
(2, 'display_news', 'true'),
(3, 'theme_site', 'default'),
(4, 'main_color_site', '#ad1717');

INSERT INTO `GH_Prestations` (`idPrestation`, `nomPrestation`, `prix`) VALUES
(1, 'Repassage', 23),
(2, 'Piscine', 50);

INSERT INTO `GH_Rangs` (`idRang`, `labelRang`, `power`) VALUES
(1, 'Visiteur', 0),
(2, 'Membre', 10),
(3, 'Admin', 100);

INSERT INTO `GH_Utilisateurs` (`idUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `emailUtilisateur`, `password`, `rang`, `nonce`) VALUES
(1, 'Quentin', 'DESBIN', 'cyboulette58@gmail.com', '$2y$10$.QQlz7WEj4gtwG67A9Kql.UdnVRcVRTocxFtWu67RrFn/A.yqEQxi', 3, ''),
(2, 'Clément', 'CISTERNE', 'lamouche444@hotmail.fr', '$2y$10$VJG81fns9YuJIYtPRLqUYuVq1tY/r9Esi6TZ2tjbpF01T5XpitEeO', 3, ''),
(3, 'Demo', 'USER', 'demo@yopmail.fr', '$2y$10$UDWVFDechZ0CpB5phcAZSepaPfatR57UZ/gMJK98L/RKutcxHjN3y', 3, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
