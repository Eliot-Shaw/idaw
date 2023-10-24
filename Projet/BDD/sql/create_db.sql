-- Table des utilisateurs
CREATE TABLE Utilisateurs (
    ID INT PRIMARY KEY,
    Login VARCHAR(50) NOT NULL,
    Age INT,
    Sexe VARCHAR(10),
    NiveauActivite VARCHAR(10)
);

-- Table des aliments
CREATE TABLE Aliments (
    ID INT PRIMARY KEY,
    Nom VARCHAR(100) NOT NULL,
    Glucides DECIMAL(5, 2),
    Lipides DECIMAL(5, 2),
    Proteines DECIMAL(5, 2),
    Sel DECIMAL(5, 2),
    Sucre DECIMAL(5, 2)
);

-- Table de composition des aliments
CREATE TABLE AlimentsComposes (
    ID INT PRIMARY KEY,
    ID_AlimentParent INT,
    ID_AlimentCompose INT,
    PourcentageComposition DECIMAL(5, 2) NOT NULL,
);

-- Table des repas
CREATE TABLE Repas (
    ID INT PRIMARY KEY,
    Nom VARCHAR(100) NOT NULL,
    DateConsommation DATE
);

-- Table des aliments consommés dans les repas
CREATE TABLE AlimentsConsommes (
    ID INT PRIMARY KEY,
    ID_Repas INT,
    ID_Aliment INT,
    Quantite DECIMAL(5, 2),
    DateConsommation DATE
);

-- Table de l'historique des aliments consommés par les utilisateurs
CREATE TABLE HistoriqueAliments (
    ID INT PRIMARY KEY,
    ID_Utilisateur INT,
    ID_Aliment INT,
    Quantite DECIMAL(5, 2),
    DateConsommation DATE
);

-- Table des indicateurs nutritionnels
CREATE TABLE IndicateursNutritionnels (
    ID INT PRIMARY KEY,
    ID_Utilisateur INT,
    Periode VARCHAR(20),
    CaloriesMoyennes DECIMAL(10, 2),
    SelIngeere DECIMAL(10, 2),
    SucreIngeere DECIMAL(10, 2),
    -- Ajoutez d'autres indicateurs nutritionnels au besoin
);

-- Vous pouvez ajouter des tables supplémentaires pour gérer d'autres informations selon vos besoins.
