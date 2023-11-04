<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['utilisateur']) && $_GET['utilisateur'] === 'all') {
            $request = $pdo->prepare("SELECT * FROM utilisateurs");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_OBJ);
            $reponse = json_encode($result);
            http_response_code(200);
            echo $reponse;
        } elseif (isset($_GET['utilisateur']) && !is_numeric($_GET['utilisateur'])) {
            http_response_code(400);
            echo json_encode(array('message' => 'Mauvaise valeur pour utilisateur'));
        } elseif (isset($_GET['utilisateur'])) {
            $userId = $_GET['utilisateur'];

            $request_user = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :user_id");
            $request_user->execute(['user_id' => $userId]);
            $userInfo = $request_user->fetchAll(PDO::FETCH_OBJ);

            $request_repas = $pdo->prepare("SELECT * FROM repas WHERE id_utilisateur = :user_id");
            $request_repas->execute(['user_id' => $userId]);
            $repasInfo = $request_repas->fetchAll(PDO::FETCH_OBJ);

            // Calcul des valeurs nutritionnelles totales agrégées par type pour tous les repas de l'utilisateur
            $request_valeurs = $pdo->prepare("SELECT vn.nom_composition, SUM(cvn.quantite_composition) AS valeur_totale
                                             FROM composition_val_nutritionnelles cvn
                                             JOIN valeurs_nutritionnelles vn ON cvn.id_val_nutritionnelle = vn.id_composition
                                             WHERE cvn.id_aliment IN 
                                                (SELECT cr.id_aliment FROM composition_repas cr 
                                                 JOIN repas r ON cr.id_repas = r.id_repas 
                                                 WHERE r.id_utilisateur = :user_id)
                                             GROUP BY vn.nom_composition");
            $request_valeurs->execute(['user_id' => $userId]);
            $valeursTotales = $request_valeurs->fetchAll(PDO::FETCH_OBJ);

            $result = [
                'details_utilisateur' => $userInfo,
                'descriptions_repas' => $repasInfo,
                'valeurs_nutritionnelles_totales' => $valeursTotales
            ];

            http_response_code(200);
            echo json_encode($result);
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

$pdo = null;
?>
