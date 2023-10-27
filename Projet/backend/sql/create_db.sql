-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 27 oct. 2023 à 07:22
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `idaw_projet-food_tracker`
--

-- --------------------------------------------------------

--
-- Structure de la table `aliments`
--

DROP TABLE IF EXISTS `aliments`;
CREATE TABLE IF NOT EXISTS `aliments` (
  `id_aliment` int NOT NULL AUTO_INCREMENT,
  `nom_aliment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_aliment`),
  KEY `nom_aliment` (`nom_aliment`(3))
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `aliments`
--

INSERT INTO `aliments` (`id_aliment`, `nom_aliment`) VALUES
(1, 'Pomme'),
(2, 'Poulet'),
(3, 'Riz'),
(4, 'Carotte'),
(5, 'Saumon'),
(6, 'Brocoli'),
(7, 'Banane'),
(8, 'Boeuf'),
(9, 'Pain'),
(10, 'Tomate'),
(11, 'Pâtes'),
(12, 'Poire'),
(13, 'Thon'),
(14, 'Courgette'),
(15, 'Fromage'),
(16, 'Lait'),
(17, 'Haricots'),
(18, 'Cerise'),
(19, 'Chocolat'),
(20, 'Amandes'),
(21, 'Salade de poulet'),
(22, 'Pizza au fromage'),
(23, 'Salade de fruits'),
(24, 'Sandwich au thon'),
(25, 'Hamburger');

-- --------------------------------------------------------

--
-- Structure de la table `aliment_categories`
--

DROP TABLE IF EXISTS `aliment_categories`;
CREATE TABLE IF NOT EXISTS `aliment_categories` (
  `id_aliment` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_aliment`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `aliment_categories`
--

INSERT INTO `aliment_categories` (`id_aliment`, `id_categorie`) VALUES
(1, 7),
(2, 86),
(3, 90),
(4, 87),
(5, 91),
(6, 87),
(7, 88),
(8, 86),
(9, 101),
(10, 87),
(11, 95),
(12, 88),
(13, 96),
(14, 87),
(15, 89),
(16, 89),
(17, 98),
(18, 88),
(19, 100),
(20, 97),
(21, 102),
(22, 103),
(23, 104),
(24, 105),
(25, 106);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom_categorie`) VALUES
(1, 'France'),
(2, 'Allemagne'),
(3, 'Espagne'),
(4, 'Italie'),
(5, 'États-Unis'),
(6, 'Canada'),
(7, 'Royaume-Uni'),
(99, 'Condiments'),
(9, 'Australie'),
(98, 'Légumineuses'),
(13, 'Mexique'),
(97, 'Noix et graines'),
(15, 'Russie'),
(96, 'Fruits de mer'),
(17, 'Nouvelle-Zélande'),
(18, 'Suède'),
(19, 'Norvège'),
(95, 'Pâtes'),
(21, 'Brésil'),
(22, 'Argentine'),
(23, 'Pérou'),
(24, 'Colombie'),
(25, 'Venezuela'),
(26, 'Chili'),
(27, 'Équateur'),
(28, 'Bolivie'),
(29, 'Paraguay'),
(30, 'Uruguay'),
(31, 'Chine'),
(32, 'Inde'),
(33, 'Japon'),
(34, 'Corée du Sud'),
(94, 'Soupes'),
(93, 'Desserts'),
(92, 'Boissons'),
(91, 'Poissons'),
(90, 'Céréales'),
(41, 'Arabie saoudite'),
(42, 'Israël'),
(43, 'Émirats arabes unis'),
(44, 'Qatar'),
(45, 'Turquie'),
(46, 'Iran'),
(47, 'Irak'),
(48, 'Koweït'),
(49, 'Liban'),
(50, 'Jordanie'),
(51, 'Nigéria'),
(52, 'Égypte'),
(53, 'Afrique du Sud'),
(54, 'Kenya'),
(55, 'Ghana'),
(56, 'Sénégal'),
(57, 'Côte d\'Ivoire'),
(89, 'Produits laitiers'),
(59, 'Maroc'),
(60, 'Tunisie'),
(61, 'Thaïlande'),
(62, 'Vietnam'),
(63, 'Indonésie'),
(64, 'Malaisie'),
(65, 'Singapour'),
(88, 'Fruits'),
(87, 'Légumes'),
(86, 'Viandes'),
(69, 'Philippines'),
(70, 'Brunei'),
(71, 'Bangladesh'),
(72, 'Pakistan'),
(73, 'Sri Lanka'),
(74, 'Népal'),
(75, 'Cambodge'),
(76, 'Laos'),
(77, 'Myanmar (Birmanie)'),
(78, 'Mongolie'),
(79, 'Madagascar'),
(80, 'Ouganda'),
(81, 'Tanzanie'),
(82, 'Rwanda'),
(83, 'Honduras'),
(84, 'Nicaragua'),
(85, 'Éthiopie'),
(100, 'Collations'),
(101, 'Produits de boulangerie'),
(102, 'Salades'),
(103, 'Pizzas'),
(104, 'Salades de fruits'),
(105, 'Sandwiches'),
(106, 'Burgers');

-- --------------------------------------------------------

--
-- Structure de la table `compositionaliment`
--

DROP TABLE IF EXISTS `compositionaliment`;
CREATE TABLE IF NOT EXISTS `compositionaliment` (
  `id_aliment_parent` int DEFAULT NULL,
  `id_aliment_compose` int DEFAULT NULL,
  `pourcentage_aliment` decimal(5,2) DEFAULT NULL,
  KEY `id_aliment_parent` (`id_aliment_parent`),
  KEY `id_aliment_compose` (`id_aliment_compose`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compositionaliment`
--

INSERT INTO `compositionaliment` (`id_aliment_parent`, `id_aliment_compose`, `pourcentage_aliment`) VALUES
(21, 2, '50.00'),
(21, 6, '50.00'),
(22, 9, '40.00'),
(22, 15, '30.00'),
(22, 10, '30.00'),
(23, 7, '40.00'),
(23, 1, '40.00'),
(23, 18, '20.00'),
(24, 13, '40.00'),
(24, 9, '30.00'),
(24, 10, '30.00'),
(25, 8, '40.00'),
(25, 9, '20.00'),
(25, 15, '20.00'),
(25, 10, '20.00');

-- --------------------------------------------------------

--
-- Structure de la table `compositionrepas`
--

DROP TABLE IF EXISTS `compositionrepas`;
CREATE TABLE IF NOT EXISTS `compositionrepas` (
  `id_repas` int DEFAULT NULL,
  `id_aliment` int DEFAULT NULL,
  `quantite` decimal(5,2) DEFAULT NULL,
  KEY `id_repas` (`id_repas`),
  KEY `id_aliment` (`id_aliment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compositionrepas`
--

INSERT INTO `compositionrepas` (`id_repas`, `id_aliment`, `quantite`) VALUES
(1, 1, '200.00'),
(1, 2, '150.00'),
(1, 10, '100.00'),
(2, 4, '100.00'),
(2, 6, '75.00'),
(2, 13, '120.00'),
(3, 5, '180.00'),
(3, 7, '90.00'),
(3, 11, '160.00');

-- --------------------------------------------------------

--
-- Structure de la table `composition_val_nutritionnelles`
--

DROP TABLE IF EXISTS `composition_val_nutritionnelles`;
CREATE TABLE IF NOT EXISTS `composition_val_nutritionnelles` (
  `id_val_nutritionnelle` int DEFAULT NULL,
  `id_aliment` int DEFAULT NULL,
  `quantite_composition` decimal(5,2) DEFAULT NULL,
  KEY `id_aliment_cplx` (`id_val_nutritionnelle`),
  KEY `id_aliment` (`id_aliment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `composition_val_nutritionnelles`
--

INSERT INTO `composition_val_nutritionnelles` (`id_val_nutritionnelle`, `id_aliment`, `quantite_composition`) VALUES
(1, 1, '100.00'),
(2, 1, '0.30'),
(3, 1, '0.10'),
(4, 1, '14.00'),
(5, 1, '9.00'),
(6, 1, '2.00'),
(7, 1, '0.60'),
(8, 1, '0.00'),
(1, 2, '165.00'),
(2, 2, '3.60'),
(3, 2, '1.00'),
(4, 2, '0.00'),
(5, 2, '0.00'),
(6, 2, '0.00'),
(7, 2, '31.00'),
(8, 2, '0.07'),
(1, 3, '130.00'),
(2, 3, '0.30'),
(3, 3, '0.10'),
(4, 3, '28.70'),
(5, 3, '0.10'),
(6, 3, '1.30'),
(7, 3, '2.70'),
(8, 3, '0.00'),
(1, 4, '41.00'),
(2, 4, '0.20'),
(3, 4, '0.00'),
(4, 4, '10.00'),
(5, 4, '4.70'),
(6, 4, '2.80'),
(7, 4, '0.90'),
(8, 4, '0.08'),
(1, 5, '206.00'),
(2, 5, '13.40'),
(3, 5, '2.20'),
(4, 5, '0.00'),
(5, 5, '0.00'),
(6, 5, '0.00'),
(7, 5, '20.40'),
(8, 5, '0.06'),
(1, 6, '100.00'),
(2, 6, '0.70'),
(3, 6, '0.10'),
(4, 6, '5.50'),
(5, 6, '0.60'),
(6, 6, '3.70'),
(7, 6, '0.60'),
(8, 6, '0.02'),
(9, 6, '30.00'),
(1, 7, '100.00'),
(2, 7, '0.30'),
(3, 7, '0.00'),
(4, 7, '14.00'),
(5, 7, '9.00'),
(6, 7, '2.00'),
(7, 7, '0.30'),
(8, 7, '0.00'),
(9, 7, '0.00'),
(10, 7, '0.00'),
(1, 8, '100.00'),
(2, 8, '2.60'),
(3, 8, '1.10'),
(4, 8, '0.00'),
(5, 8, '0.00'),
(6, 8, '0.00'),
(7, 8, '26.50'),
(8, 8, '0.00'),
(9, 8, '0.00'),
(10, 8, '0.00'),
(1, 9, '100.00'),
(2, 9, '2.60'),
(3, 9, '1.10'),
(4, 9, '55.30'),
(5, 9, '0.70'),
(6, 9, '2.50'),
(7, 9, '11.20'),
(8, 9, '0.00'),
(9, 9, '0.00'),
(10, 9, '0.00'),
(1, 10, '100.00'),
(2, 10, '0.20'),
(3, 10, '0.10'),
(4, 10, '3.50'),
(5, 10, '2.60'),
(6, 10, '1.20'),
(7, 10, '1.30'),
(8, 10, '0.30'),
(9, 10, '0.01'),
(10, 10, '0.02'),
(1, 11, '65.00'),
(2, 11, '0.40'),
(3, 11, '0.00'),
(4, 11, '13.80'),
(5, 11, '9.18'),
(6, 11, '2.10'),
(7, 11, '1.60'),
(8, 11, '0.02'),
(9, 11, '0.00'),
(10, 11, '0.29'),
(1, 12, '130.00'),
(2, 12, '0.90'),
(3, 12, '0.30'),
(4, 12, '0.00'),
(5, 12, '0.00'),
(6, 12, '0.00'),
(7, 12, '29.00'),
(8, 12, '0.60'),
(9, 12, '0.00'),
(10, 12, '56.00'),
(1, 13, '13.00'),
(2, 13, '0.30'),
(3, 13, '0.10'),
(4, 13, '2.20'),
(5, 13, '1.70'),
(6, 13, '1.00'),
(7, 13, '1.20'),
(8, 13, '0.03'),
(9, 13, '0.00'),
(10, 13, '30.00'),
(1, 14, '999.99'),
(2, 14, '34.00'),
(3, 14, '21.10'),
(4, 14, '0.50'),
(5, 14, '0.00'),
(6, 14, '0.00'),
(7, 14, '25.00'),
(8, 14, '1.50'),
(9, 14, '0.00'),
(10, 14, '190.00'),
(1, 15, '200.00'),
(2, 15, '10.40'),
(3, 15, '6.70'),
(4, 15, '12.20'),
(5, 15, '12.20'),
(6, 15, '0.00'),
(7, 15, '6.40'),
(8, 15, '0.10'),
(9, 15, '0.00'),
(10, 15, '10.40'),
(1, 16, '131.00'),
(2, 16, '0.60'),
(3, 16, '0.20'),
(4, 16, '6.80'),
(5, 16, '1.20'),
(6, 16, '2.30'),
(7, 16, '8.20'),
(8, 16, '0.03'),
(9, 16, '0.00'),
(10, 16, '24.00'),
(1, 17, '263.00'),
(2, 17, '0.50'),
(3, 17, '0.10'),
(4, 17, '16.10'),
(5, 17, '13.90'),
(6, 17, '1.60'),
(7, 17, '1.10'),
(8, 17, '0.03'),
(9, 17, '0.00'),
(10, 17, '11.00'),
(1, 18, '999.99'),
(2, 18, '28.00'),
(3, 18, '18.00'),
(4, 18, '58.00'),
(5, 18, '56.00'),
(6, 18, '7.00'),
(7, 18, '5.00'),
(8, 18, '0.01'),
(9, 18, '0.00'),
(10, 18, '109.00'),
(1, 19, '999.99'),
(2, 19, '54.00'),
(3, 19, '4.00'),
(4, 19, '4.90'),
(5, 19, '4.40'),
(6, 19, '12.00'),
(7, 19, '21.00'),
(8, 19, '0.01'),
(9, 19, '0.00'),
(10, 19, '268.00'),
(1, 20, '999.99'),
(2, 20, '14.80'),
(3, 20, '3.50'),
(4, 20, '1.20'),
(5, 20, '0.00'),
(6, 20, '1.30'),
(7, 20, '21.00'),
(8, 20, '0.70'),
(9, 20, '0.00'),
(10, 20, '19.00');

-- --------------------------------------------------------

--
-- Structure de la table `niveausport`
--

DROP TABLE IF EXISTS `niveausport`;
CREATE TABLE IF NOT EXISTS `niveausport` (
  `id_niveau_sport` int NOT NULL AUTO_INCREMENT,
  `nom_niveau_sport` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_niveau_sport`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `niveausport`
--

INSERT INTO `niveausport` (`id_niveau_sport`, `nom_niveau_sport`) VALUES
(1, 'Faible'),
(2, 'Moyenne'),
(3, 'Forte'),
(0, 'Nulle');

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas` (
  `id_repas` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `date_mange` date DEFAULT NULL,
  PRIMARY KEY (`id_repas`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `repas`
--

INSERT INTO `repas` (`id_repas`, `id_utilisateur`, `date_mange`) VALUES
(1, 2, '2023-10-25'),
(2, 3, '2023-10-25'),
(3, 4, '2023-10-25');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `id_niveau_sport` int DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `identifiant` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nom_de_famille` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `taille` decimal(5,2) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `identifiant` (`identifiant`),
  KEY `id_niveau_sport` (`id_niveau_sport`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `id_niveau_sport`, `role`, `identifiant`, `mdp`, `nom_de_famille`, `prenom`, `genre`, `age`, `taille`, `poids`) VALUES
(0, NULL, 'admin', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'membre', 'utilisateur1', 'mdp1', 'Smith', 'John', 'homme', 30, '170.50', '70.00'),
(3, 3, 'membre', 'utilisateur2', 'mdp2', 'Johnson', 'Emily', 'femme', 35, '165.00', '65.00'),
(4, 0, 'membre', 'utilisateur3', 'mdp3', 'Brown', 'Alex', 'autre', 28, '180.00', '80.00'),
(5, 2, 'membre', 'utilisateur4', 'mdp4', 'Davis', 'Oliver', 'homme', 32, '175.00', '75.00'),
(6, 1, 'membre', 'utilisateur5', 'mdp5', 'Martinez', 'Sophia', 'femme', 29, '160.00', '60.00'),
(7, 3, 'membre', 'utilisateur6', 'mdp6', 'Miller', 'Mason', 'homme', 34, '172.00', '70.00'),
(8, 0, 'membre', 'utilisateur7', 'mdp7', 'Wilson', 'Harper', 'autre', 31, '168.00', '68.00'),
(9, 2, 'membre', 'utilisateur8', 'mdp8', 'Lee', 'Ella', 'homme', 27, '176.00', '72.00'),
(10, 1, 'membre', 'utilisateur9', 'mdp9', 'Garcia', 'Avery', 'femme', 33, '162.00', '62.00'),
(11, 3, 'membre', 'utilisateur10', 'mdp10', 'Taylor', 'Noah', 'homme', 30, '170.00', '70.00'),
(12, 0, 'membre', 'utilisateur11', 'mdp11', 'Hernandez', 'Liam', 'femme', 35, '165.00', '65.00'),
(13, 2, 'membre', 'utilisateur12', 'mdp12', 'Perez', 'Quinn', 'autre', 28, '180.00', '80.00'),
(14, 1, 'membre', 'utilisateur13', 'mdp13', 'Turner', 'Evelyn', 'homme', 32, '175.00', '75.00'),
(15, 3, 'membre', 'utilisateur14', 'mdp14', 'King', 'Zoe', 'femme', 29, '160.00', '60.00'),
(16, 0, 'membre', 'utilisateur15', 'mdp15', 'Adams', 'Aiden', 'homme', 34, '172.00', '70.00'),
(17, 2, 'membre', 'utilisateur16', 'mdp16', 'Wright', 'Aria', 'autre', 31, '168.00', '68.00'),
(18, 1, 'membre', 'utilisateur17', 'mdp17', 'Green', 'Emma', 'homme', 27, '176.00', '72.00'),
(19, 3, 'membre', 'utilisateur18', 'mdp18', 'Collins', 'Liam', 'femme', 33, '162.00', '62.00'),
(20, 0, 'membre', 'utilisateur19', 'mdp19', 'Clark', 'Madison', 'homme', 30, '170.00', '70.00'),
(21, 2, 'membre', 'utilisateur20', 'mdp20', 'Taylor', 'Riley', 'autre', 35, '165.00', '65.00');

-- --------------------------------------------------------

--
-- Structure de la table `valeurs_nutritionnelles`
--

DROP TABLE IF EXISTS `valeurs_nutritionnelles`;
CREATE TABLE IF NOT EXISTS `valeurs_nutritionnelles` (
  `id_composition` int NOT NULL AUTO_INCREMENT,
  `nom_composition` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_composition`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `valeurs_nutritionnelles`
--

INSERT INTO `valeurs_nutritionnelles` (`id_composition`, `nom_composition`) VALUES
(1, 'Énergie'),
(2, 'Matières grasses'),
(3, 'Acides gras saturés'),
(4, 'Glucides'),
(5, 'Sucres'),
(6, 'Fibres alimentaires'),
(7, 'Protéines'),
(8, 'Sel'),
(9, 'Vitamines'),
(10, 'Magnésium');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
