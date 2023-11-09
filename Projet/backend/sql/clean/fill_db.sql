-- https://world.openfoodfacts.org/cgi/search.pl?action=process&sort_by=random&page_size=5&json=1&fields=nutriments,ingredients,id,product_name,image_url,categories_tags
--
-- Base de données : `idaw_projet-food_tracker`
--
-- --------------------------------------------------------

--
-- Vider les tables de leur données
-- Ordre - join tables, linked tables, normal tables 
--

DELETE FROM aliment_categories WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'aliment_categories');
DELETE FROM composition_aliment WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'composition_aliment');
DELETE FROM composition_repas WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'composition_repas');
DELETE FROM composition_val_nutritionnelles WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'composition_val_nutritionnelles');

DELETE FROM repas WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'repas');

DELETE FROM niveau_sport WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'niveau_sport');
DELETE FROM utilisateurs WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'utilisateurs');
DELETE FROM aliments WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'aliments');
DELETE FROM categories WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'categories');
DELETE FROM valeurs_nutritionnelles WHERE EXISTS (SELECT * FROM information_schema.tables WHERE table_schema = 'idaw_projet-food_tracker' AND table_name = 'valeurs_nutritionnelles');

-- --------------------------------------------------------

--
-- Remplissage des tables
-- Ordre - normal tables, linked tables, join tables
--

-- --------------------------------------------------------

--
-- Insertion des données de la table `niveau_sport`
--

INSERT INTO `niveau_sport` (`nom_niveau_sport`, `coef_sport`) VALUES
('Nulle', '1.00'),
('Faible', '1.37'),
('Moyenne', '1.55'),
('Soutenu', '1.80'),
('Forte', '2.00');

-- --------------------------------------------------------

--
-- Insertion des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_niveau_sport`, `role`, `identifiant`, `mdp`, `nom_de_famille`, `prenom`, `genre`, `age`, `taille`, `poids`) VALUES
(NULL, 'admin', 'root', 'root', NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'membre', 'utilisateur1', 'mdp1', 'Smith', 'John', 'homme', 30, '170.50', '70.00'),
(3, 'membre', 'utilisateur2', 'mdp2', 'Johnson', 'Emily', 'femme', 35, '165.00', '65.00'),
(0, 'membre', 'utilisateur3', 'mdp3', 'Brown', 'Alex', 'autre', 28, '180.00', '80.00'),
(2, 'membre', 'utilisateur4', 'mdp4', 'Davis', 'Oliver', 'homme', 32, '175.00', '75.00'),
(1, 'membre', 'utilisateur5', 'mdp5', 'Martinez', 'Sophia', 'femme', 29, '160.00', '60.00'),
(3, 'membre', 'utilisateur6', 'mdp6', 'Miller', 'Mason', 'homme', 34, '172.00', '70.00'),
(0, 'membre', 'utilisateur7', 'mdp7', 'Wilson', 'Harper', 'autre', 31, '168.00', '68.00'),
(2, 'membre', 'utilisateur8', 'mdp8', 'Lee', 'Ella', 'homme', 27, '176.00', '72.00'),
(1, 'membre', 'utilisateur9', 'mdp9', 'Garcia', 'Avery', 'femme', 33, '162.00', '62.00'),
(3, 'membre', 'utilisateur10', 'mdp10', 'Taylor', 'Noah', 'homme', 30, '170.00', '70.00'),
(0, 'membre', 'utilisateur11', 'mdp11', 'Hernandez', 'Liam', 'femme', 35, '165.00', '65.00'),
(2, 'membre', 'utilisateur12', 'mdp12', 'Perez', 'Quinn', 'autre', 28, '180.00', '80.00'),
(1, 'membre', 'utilisateur13', 'mdp13', 'Turner', 'Evelyn', 'homme', 32, '175.00', '75.00'),
(3, 'membre', 'utilisateur14', 'mdp14', 'King', 'Zoe', 'femme', 29, '160.00', '60.00'),
(0, 'membre', 'utilisateur15', 'mdp15', 'Adams', 'Aiden', 'homme', 34, '172.00', '70.00'),
(2, 'membre', 'utilisateur16', 'mdp16', 'Wright', 'Aria', 'autre', 31, '168.00', '68.00'),
(1, 'membre', 'utilisateur17', 'mdp17', 'Green', 'Emma', 'homme', 27, '176.00', '72.00'),
(3, 'membre', 'utilisateur18', 'mdp18', 'Collins', 'Liam', 'femme', 33, '162.00', '62.00'),
(0, 'membre', 'utilisateur19', 'mdp19', 'Clark', 'Madison', 'homme', 30, '170.00', '70.00'),
(2, 'membre', 'utilisateur20', 'mdp20', 'Taylor', 'Riley', 'autre', 35, '165.00', '65.00');

-- --------------------------------------------------------

--
-- Insertion des données de la table `aliments`
--

INSERT INTO `aliments` (`nom_aliment`) VALUES
('Pomme'),
('Poulet'),
('Riz'),
('Carotte'),
('Saumon'),
('Brocoli'),
('Banane'),
('Boeuf'),
('Pain'),
('Tomate'),
('Pâtes'),
('Poire'),
('Thon'),
('Courgette'),
('Fromage'),
('Lait'),
('Haricots'),
('Cerise'),
('Chocolat'),
('Amandes'),
('Salade de poulet'),
('Pizza au fromage'),
('Salade de fruits'),
('Sandwich au thon'),
('Hamburger');

-- --------------------------------------------------------

--
-- Insertion des données de la table `categories`
--

INSERT INTO `categories` (`nom_categorie`) VALUES
('France'),
('Allemagne'),
('Espagne'),
('Italie'),
('États-Unis'),
('Canada'),
('Royaume-Uni'),
('Condiments'),
('Australie'),
('Légumineuses'),
('Mexique'),
('Noix et graines'),
('Russie'),
('Fruits de mer'),
('Nouvelle-Zélande'),
('Suède'),
('Norvège'),
('Pâtes'),
('Brésil'),
('Argentine'),
('Pérou'),
('Colombie'),
('Venezuela'),
('Chili'),
('Équateur'),
('Bolivie'),
('Paraguay'),
('Uruguay'),
('Chine'),
('Inde'),
('Japon'),
('Corée du Sud'),
('Soupes'),
('Desserts'),
('Boissons'),
('Poissons'),
('Céréales'),
('Arabie saoudite'),
('Israël'),
('Émirats arabes unis'),
('Qatar'),
('Turquie'),
('Iran'),
('Irak'),
('Koweït'),
('Liban'),
('Jordanie'),
('Nigéria'),
('Égypte'),
('Afrique du Sud'),
('Kenya'),
('Ghana'),
('Sénégal'),
('Produits laitiers'),
('Maroc'),
('Tunisie'),
('Thaïlande'),
('Vietnam'),
('Indonésie'),
('Malaisie'),
('Singapour'),
('Fruits'),
('Légumes'),
('Viandes'),
('Philippines'),
('Brunei'),
('Bangladesh'),
('Pakistan'),
('Sri Lanka'),
('Népal'),
('Cambodge'),
('Laos'),
('Myanmar (Birmanie)'),
('Mongolie'),
('Madagascar'),
('Ouganda'),
('Tanzanie'),
('Rwanda'),
('Honduras'),
('Nicaragua'),
('Éthiopie'),
('Collations'),
('Produits de boulangerie'),
('Salades'),
('Pizzas'),
('Salades de fruits'),
('Sandwiches'),
('Burgers');

-- --------------------------------------------------------

--
-- Insertion des données de la table `valeurs_nutritionnelles`
--

INSERT INTO `valeurs_nutritionnelles` (`nom_composition`) VALUES
('Énergie'),
('Matières grasses'),
('Acides gras saturés'),
('Glucides'),
('Sucres'),
('Fibres alimentaires'),
('Protéines'),
('Sel'),
('Vitamines'),
('Magnésium');

-- --------------------------------------------------------

--
-- Insertion des données de la table `repas`
--

INSERT INTO `repas` (`id_utilisateur`, `date_mange`) VALUES


-- --------------------------------------------------------

--
-- Insertion des données de la table `aliment_categories`
--

INSERT INTO `aliment_categories` (`id_aliment`, `id_categorie`) VALUES


-- --------------------------------------------------------

--
-- Insertion des données de la table `composition_aliment`
--

INSERT INTO `composition_aliment` (`id_aliment_parent`, `id_aliment_compose`, `pourcentage_aliment`) VALUES


-- --------------------------------------------------------

--
-- Insertion des données de la table `composition_repas`
--

INSERT INTO `composition_repas` (`id_repas`, `id_aliment`, `quantite`) VALUES


-- --------------------------------------------------------

--
-- Insertion des données de la table `composition_val_nutritionnelles`
--

INSERT INTO `composition_val_nutritionnelles` (`id_val_nutritionnelle`, `id_aliment`, `quantite_composition`) VALUES
