--
-- Base de données : `idaw_projet-food_tracker`
--

-- --------------------------------------------------------

--
-- Destruction des tables
-- Ordre - join tables, linked tables, normal tables 
--

DROP TABLE IF EXISTS `aliment_categories`;
DROP TABLE IF EXISTS `composition_aliment`;
DROP TABLE IF EXISTS `composition_repas`;
DROP TABLE IF EXISTS `composition_val_nutritionnelles`;

DROP TABLE IF EXISTS `repas`;

DROP TABLE IF EXISTS `niveau_sport`;
DROP TABLE IF EXISTS `utilisateurs`;
DROP TABLE IF EXISTS `aliments`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `valeurs_nutritionnelles`;

-- --------------------------------------------------------

--
-- Construction des tables
-- Ordre - normal tables, linked tables, join tables
--

-- --------------------------------------------------------

--
-- Structure de la table `niveau_sport`
--

CREATE TABLE IF NOT EXISTS `niveau_sport` (
  `id_niveau_sport` int NOT NULL AUTO_INCREMENT,
  `nom_niveau_sport` varchar(50) DEFAULT NULL,
  `coef_sport` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_niveau_sport`)
);


-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

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
-- Structure de la table `aliments`
--

CREATE TABLE IF NOT EXISTS `aliments` (
  `id_aliment` int NOT NULL AUTO_INCREMENT,
  `nom_aliment` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_aliment`),
  KEY `nom_aliment` (`nom_aliment`(3))
);


-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

CREATE TABLE IF NOT EXISTS `repas` (
  `id_repas` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `date_mange` date DEFAULT NULL,
  PRIMARY KEY (`id_repas`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `fk_repas_utilisateurs` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE
);


-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categorie`)
);


-- --------------------------------------------------------

--
-- Structure de la table `valeurs_nutritionnelles`
--

CREATE TABLE IF NOT EXISTS `valeurs_nutritionnelles` (
  `id_composition` int NOT NULL AUTO_INCREMENT,
  `nom_composition` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_composition`)
);


-- --------------------------------------------------------

--
-- Structure de la table `aliment_categories`
--

CREATE TABLE IF NOT EXISTS `aliment_categories` (
  `id_aliment` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_aliment`,`id_categorie`),
  CONSTRAINT `fk_aliment_categories_id_aliment` FOREIGN KEY (`id_aliment`) REFERENCES `aliments` (`id_aliment`) ON DELETE CASCADE,
  CONSTRAINT `fk_aliment_categories_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE
);


-- --------------------------------------------------------

--
-- Structure de la table `composition_aliment`
--

CREATE TABLE IF NOT EXISTS `composition_aliment` (
  `id_aliment_parent` int,
  `id_aliment_compose` int,
  `pourcentage_aliment` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_aliment_parent`,`id_aliment_compose`),
  CONSTRAINT `fk_composition_aliment_parent` FOREIGN KEY (`id_aliment_parent`) REFERENCES `aliments` (`id_aliment`) ON DELETE CASCADE,
  CONSTRAINT `fk_composition_aliment_compose` FOREIGN KEY (`id_aliment_compose`) REFERENCES `aliments` (`id_aliment`) ON DELETE CASCADE
);


-- --------------------------------------------------------

--
-- Structure de la table `composition_repas`
--

CREATE TABLE IF NOT EXISTS `composition_repas` (
  `id_repas` int,
  `id_aliment` int,
  `quantite` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_repas`,`id_aliment`),
  CONSTRAINT `fk_composition_repas_repas` FOREIGN KEY (`id_repas`) REFERENCES `repas` (`id_repas`) ON DELETE CASCADE,
  CONSTRAINT `fk_composition_repas_aliments` FOREIGN KEY (`id_aliment`) REFERENCES `aliments` (`id_aliment`) ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Structure de la table `composition_val_nutritionnelles`
--

CREATE TABLE IF NOT EXISTS `composition_val_nutritionnelles` (
  `id_val_nutritionnelle` int,
  `id_aliment` int,
  `quantite_composition` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_val_nutritionnelle`,`id_aliment`),
  CONSTRAINT `fk_composition_val_nutritionnelles_valeurs` FOREIGN KEY (`id_val_nutritionnelle`) REFERENCES `valeurs_nutritionnelles` (`id_composition`) ON DELETE CASCADE,
  CONSTRAINT `fk_composition_val_nutritionnelles_aliments` FOREIGN KEY (`id_aliment`) REFERENCES `aliments` (`id_aliment`) ON DELETE CASCADE
);

COMMIT;