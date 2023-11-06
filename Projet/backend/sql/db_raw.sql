-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 04 nov. 2023 à 14:37
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
);

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
);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categorie`)
);

-- --------------------------------------------------------

--
-- Structure de la table `composition_aliment`
--

DROP TABLE IF EXISTS `composition_aliment`;
CREATE TABLE IF NOT EXISTS `composition_aliment` (
  `id_aliment_parent` int DEFAULT NULL,
  `id_aliment_compose` int DEFAULT NULL,
  `pourcentage_aliment` decimal(5,2) DEFAULT NULL,
  KEY `id_aliment_parent` (`id_aliment_parent`),
  KEY `id_aliment_compose` (`id_aliment_compose`)
);

-- --------------------------------------------------------

--
-- Structure de la table `composition_repas`
--

DROP TABLE IF EXISTS `composition_repas`;
CREATE TABLE IF NOT EXISTS `composition_repas` (
  `id_repas` int DEFAULT NULL,
  `id_aliment` int DEFAULT NULL,
  `quantite` decimal(5,2) DEFAULT NULL,
  KEY `id_repas` (`id_repas`),
  KEY `id_aliment` (`id_aliment`)
);

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
);

-- --------------------------------------------------------

--
-- Structure de la table `niveau_sport`
--

DROP TABLE IF EXISTS `niveau_sport`;
CREATE TABLE IF NOT EXISTS `niveau_sport` (
  `id_niveau_sport` int NOT NULL AUTO_INCREMENT,
  `nom_niveau_sport` varchar(50) DEFAULT NULL,
  `coef_sport` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_niveau_sport`)
);

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
);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `id_niveau_sport` int DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `identifiant` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `nom_de_famille` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `taille` decimal(5,2) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `identifiant` (`identifiant`),
  KEY `id_niveau_sport` (`id_niveau_sport`)
);

-- --------------------------------------------------------

--
-- Structure de la table `valeurs_nutritionnelles`
--

DROP TABLE IF EXISTS `valeurs_nutritionnelles`;
CREATE TABLE IF NOT EXISTS `valeurs_nutritionnelles` (
  `id_composition` int NOT NULL AUTO_INCREMENT,
  `nom_composition` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_composition`)
);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
