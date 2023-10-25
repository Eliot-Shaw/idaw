-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 24 oct. 2023 à 15:18
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
  `id_aliment` int NOT NULL,
  `nom_aliment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_aliment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `composition`
--

DROP TABLE IF EXISTS `composition`;
CREATE TABLE IF NOT EXISTS `composition` (
  `id_composition` int NOT NULL,
  `nom_composition` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_composition`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `niveausport`
--

DROP TABLE IF EXISTS `niveausport`;
CREATE TABLE IF NOT EXISTS `niveausport` (
  `id_niveau_sport` int NOT NULL,
  `nom_niveau_sport` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_niveau_sport`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas` (
  `id_repas` int NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  `date_mange` date DEFAULT NULL,
  PRIMARY KEY (`id_repas`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `typecomposition`
--

DROP TABLE IF EXISTS `typecomposition`;
CREATE TABLE IF NOT EXISTS `typecomposition` (
  `id_composition` int DEFAULT NULL,
  `id_aliment` int DEFAULT NULL,
  `quantite_composition` decimal(5,2) DEFAULT NULL,
  KEY `id_composition` (`id_composition`),
  KEY `id_aliment` (`id_aliment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `nom_de_famille` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `taille` decimal(5,2) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
