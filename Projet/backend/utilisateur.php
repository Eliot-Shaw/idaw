<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['utilisateur'])){
            if ($_GET['utilisateur'] === 'all') {
                $request = $pdo->prepare("SELECT * FROM utilisateurs");
                $request->execute();
                $result = $request->fetchAll(PDO::FETCH_OBJ);
                $reponse = json_encode($result);
                http_response_code(200);
                echo $reponse;
            } elseif (!is_numeric($_GET['utilisateur'])) {
                http_response_code(400);
                echo json_encode(array('message' => 'Mauvaise valeur pour utilisateur'));
            } else{
                $userId = $_GET['utilisateur'];

                $request_user = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :user_id");
                $request_user->execute(['user_id' => $userId]);
                $userInfo = $request_user->fetchAll(PDO::FETCH_OBJ)[0];
                
                // Calcul du métabolisme de l'utilisateur
                $metabolisme = calculerMetabolisme($pdo, $userInfo);
                

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
                    'metabolisme' => $metabolisme,
                    'descriptions_repas' => $repasInfo,
                    'valeurs_nutritionnelles_totales' => $valeursTotales,
                ];

                http_response_code(200);
                echo json_encode($response);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Variable utilisateur non fournie']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}



function calculerMetabolisme($pdo, $userInfo) {
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

$pdo = null;
?>
