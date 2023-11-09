<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id_utilisateur'])) {

            if ($_GET['id_utilisateur'] === 'all') {
                $request = $pdo->prepare("SELECT * FROM utilisateurs");
                $request->execute();
                $utilisateurs = $request->fetchAll(PDO::FETCH_OBJ);

                $usersWithMetabolism = [];
                foreach ($utilisateurs as $userInfo) {
                    $userInfo->metabolisme = calculerMetabolisme($pdo, $userInfo);
                    $usersWithMetabolism[] = $userInfo;
                }

                http_response_code(200);
                echo json_encode($usersWithMetabolism);

            }elseif (!is_numeric($_GET['id_utilisateur'])) {
                http_response_code(400);
                echo json_encode(array('message' => 'Mauvaise valeur pour utilisateur'));

            }else {
                $userId = $_GET['id_utilisateur'];
            
                // Vérifie si l'utilisateur avec l'ID spécifié existe
                $checkUser = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :user_id");
                $checkUser->execute(['user_id' => $userId]);
                $userInfo = $checkUser->fetch(PDO::FETCH_OBJ);
            
                if ($userInfo) {
                    $request_user = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :user_id");
                    $request_user->execute(['user_id' => $userId]);
                    $userInfo = $request_user->fetchAll(PDO::FETCH_OBJ)[0];

                    // Calcul du métabolisme de l'utilisateur
                    $userInfo->metabolisme = calculerMetabolisme($pdo, $userInfo);


                    $request_repas = $pdo->prepare("SELECT * FROM repas WHERE id_utilisateur = :user_id");
                    $request_repas->execute(['user_id' => $userId]);
                    $repasInfo = $request_repas->fetchAll(PDO::FETCH_OBJ);

                    // Calcul des valeurs nutritionnelles totales agrégées par type pour tous les repas de l'utilisateur
                    $request_valeurs = $pdo->prepare("SELECT vn.nom_composition, SUM(cvn.quantite_composition) AS valeur_totale
                                        FROM composition_val_nutritionnelles cvn
                                        JOIN valeurs_nutritionnelles vn ON cvn.id_val_nutritionnelle = vn.id_composition
                                        WHERE cvn.id_aliment IN 
                                            (SELECT ca.id_aliment_compose FROM composition_aliment ca 
                                            WHERE ca.id_aliment_parent IN 
                                                (SELECT cr.id_aliment FROM composition_repas cr 
                                                JOIN repas r ON cr.id_repas = r.id_repas 
                                                WHERE r.id_utilisateur = :user_id))
                                        GROUP BY vn.nom_composition");
                    $request_valeurs->execute(['user_id' => $userId]);
                    $valeursTotales = $request_valeurs->fetchAll(PDO::FETCH_OBJ);



                    $response = [
                        'details_utilisateur' => $userInfo,
                        'descriptions_repas' => $repasInfo,
                        'valeurs_nutritionnelles_totales' => $valeursTotales,
                    ];

                    http_response_code(200);
                    echo json_encode($response);
                }else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Utilisateur introuvable']);
                }
            }
        }else if (isset($_GET['check'])) {
            if (isset($_GET['identifiant']) && isset($_GET['mdp'])) {
                $identifiant = $_GET['identifiant'];
                $mdp = $_GET['mdp'];
        
                // Recherche de l'utilisateur correspondant à l'identifiant
                $checkUser = $pdo->prepare("SELECT id_utilisateur, identifiant, mdp FROM utilisateurs WHERE identifiant = :identifiant");
                $checkUser->execute(['identifiant' => $identifiant]);
                $userInfo = $checkUser->fetch(PDO::FETCH_OBJ);
        
                if ($userInfo) {
                    // Vérification du mot de passe
                    if ($mdp== $userInfo->mdp) {
                        $_SESSION['id_utilisateur'] = $userInfo->id_utilisateur;
                        $_SESSION['identifiant'] = $userInfo->identifiant;
                        http_response_code(200);
                        echo json_encode(['message' => 'Connexion réussie', 'id_utilisateur'=>$userInfo->id_utilisateur]);
                    } else {
                        http_response_code(401);
                        echo json_encode(['message' => 'Mot de passe incorrect']);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Identifiant non trouvé']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Paramètres manquants pour la vérification de connexion']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Variable utilisateur non fournie']);
        }
        break;
    // -----------------------------------------------------------------------------------------------
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        $idNiveauSport = $_POST['id_niveau_sport'];
        $identifiant = $_POST['identifiant'];
        $mdp = $_POST['mdp'];
        $nomDeFamille = $_POST['nom_de_famille'];
        $prenom = $_POST['prenom'];
        $genre = $_POST['genre'];
        $age = $_POST['age'];
        $taille = $_POST['taille'];
        $poids = $_POST['poids'];

        $insertUser = $pdo->prepare("INSERT INTO `utilisateurs` (
            `id_niveau_sport`,
            `identifiant`, 
            `mdp`, 
            `nom_de_famille`, 
            `prenom`, 
            `genre`, 
            `age`, 
            `taille`, 
            `poids`
        ) VALUES (
            :id_niveau_sport,
            :identifiant,
            :mdp,
            :nom_de_famille,
            :prenom,
            :genre,
            :age,
            :taille,
            :poids
        )");

        // Liaison des valeurs aux paramètres
        $insertUser->bindParam(':id_niveau_sport', $idNiveauSport);
        $insertUser->bindParam(':identifiant', $identifiant);
        $insertUser->bindParam(':mdp', $mdp);
        $insertUser->bindParam(':nom_de_famille', $nomDeFamille);
        $insertUser->bindParam(':prenom', $prenom);
        $insertUser->bindParam(':genre', $genre);
        $insertUser->bindParam(':age', $age);
        $insertUser->bindParam(':taille', $taille);
        $insertUser->bindParam(':poids', $poids);

        $insertUser->execute();
        $newUserId = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode(['message' => 'Utilisateur créé avec succès', 'id_utilisateur' => $newUserId]);
        break;
    // -----------------------------------------------------------------------------------------------
    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        if (isset($_DELETE['id_utilisateur'])) {
            $userId = $_DELETE['id_utilisateur'];
            $deleteUser = $pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = :user_id");
            $deleteUser->execute(['user_id' => $userId]);
            http_response_code(200);
            echo json_encode(['message' => 'Utilisateur supprimé avec succès']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de l\'utilisateur non fourni pour la suppression']);
        }
        break;
    // -----------------------------------------------------------------------------------------------
    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        if (isset($_PUT['id_utilisateur'])) {
            $userId = $_PUT['id_utilisateur'];

            // Collecte des nouvelles données de l'utilisateur à mettre à jour
            $idNiveauSport = $_PUT['id_niveau_sport'];
            $role = 'membre';
            $identifiant = $_PUT['identifiant'];
            $mdp = $_PUT['mdp'];
            $nomDeFamille = $_PUT['nom_de_famille'];
            $prenom = $_PUT['prenom'];
            $genre = $_PUT['genre'];
            $age = $_PUT['age'];
            $taille = $_PUT['taille'];
            $poids = $_PUT['poids'];

            // Mettre à jour l'utilisateur dans la base de données
            $updateUser = $pdo->prepare("UPDATE `utilisateurs` SET 
                `id_niveau_sport` = :id_niveau_sport,
                `role` = :role,
                `identifiant` = :identifiant,
                `mdp` = :mdp,
                `nom_de_famille` = :nom_de_famille,
                `prenom` = :prenom,
                `genre` = :genre,
                `age` = :age,
                `taille` = :taille,
                `poids` = :poids
                WHERE `id_utilisateur` = :user_id");

            // Liaison des nouvelles valeurs aux paramètres
            $updateUser->bindParam(':id_niveau_sport', $idNiveauSport);
            $updateUser->bindParam(':role', $role);
            $updateUser->bindParam(':identifiant', $identifiant);
            $updateUser->bindParam(':mdp', $mdp);
            $updateUser->bindParam(':nom_de_famille', $nomDeFamille);
            $updateUser->bindParam(':prenom', $prenom);
            $updateUser->bindParam(':genre', $genre);
            $updateUser->bindParam(':age', $age);
            $updateUser->bindParam(':taille', $taille);
            $updateUser->bindParam(':poids', $poids);
            $updateUser->bindParam(':user_id', $userId);

            // Exécution de la requête de mise à jour
            $updateUser->execute();

            http_response_code(200);
            echo json_encode(['message' => 'Utilisateur édité avec succès']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de l\'utilisateur non fourni pour l\'édition']);
        }
        break;
    // -----------------------------------------------------------------------------------------------
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}
$pdo = null;



function calculerMetabolisme($pdo, $userInfo)
{
    // Récupération du coefficient de sport associé à l'utilisateur depuis la base de données
    $request_coef_sport = $pdo->prepare("SELECT coef_sport FROM niveau_sport WHERE id_niveau_sport = :niveau_sport_id");
    $request_coef_sport->execute(['niveau_sport_id' => $userInfo->id_niveau_sport]);
    $coefSport = $request_coef_sport->fetch(PDO::FETCH_OBJ);
    $coefficientSport = ($coefSport) ? $coefSport->coef_sport : 1;

    if ($userInfo->genre === "homme") {
        return (13.707 * $userInfo->poids + 492.3 * $userInfo->taille / 100 - 6.673 * $userInfo->age + 77.607) * $coefficientSport;
    } elseif ($userInfo->genre === "femme") {
        return (9.740 * $userInfo->poids + 172.9 * $userInfo->taille / 100 - 4.737 * $userInfo->age + 667.051) * $coefficientSport;
    } else {
        $metabolismeHomme = (13.707 * $userInfo->poids + 492.3 * $userInfo->taille / 100 - 6.673 * $userInfo->age + 77.607) * $coefficientSport;
        $metabolismeFemme = (9.740 * $userInfo->poids + 172.9 * $userInfo->taille / 100 - 4.737 * $userInfo->age + 667.051) * $coefficientSport;
        return ($metabolismeHomme + $metabolismeFemme) / 2;
    }
}
?>