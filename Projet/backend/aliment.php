<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['aliment']) && is_numeric($_GET['aliment'])) {
            $alimentId = $_GET['aliment'];

            // Récupération des détails de l'aliment
            $alimentDetails = fetchAlimentDetails($pdo, $alimentId);
            if ($alimentDetails) {
                $alimentDescription = [
                    'nom' => $alimentDetails->nom_aliment,
                    'nom_categorie' => $alimentDetails->nom_categorie,
                    'elements_composes' => fetchElements($pdo, $alimentId),
                    'composition_nutritionnelle' => fetchCompositionNutritionnelle($pdo, $alimentId),
                ];

                http_response_code(200);
                echo json_encode($alimentDescription);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucun aliment trouvé pour cet ID']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment non valide ou non fourni']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

function fetchAlimentDetails($pdo, $alimentId) {
    $request = $pdo->prepare("SELECT a.nom_aliment, c.nom_categorie FROM aliments a 
        JOIN aliment_categories ac ON a.id_aliment = ac.id_aliment 
        JOIN categories c ON c.id_categorie = ac.id_categorie 
        WHERE a.id_aliment = :alimentId");
    $request->execute(['alimentId' => $alimentId]);
    return $request->fetch(PDO::FETCH_OBJ);
}

function fetchElements($pdo, $alimentId) {
    $request = $pdo->prepare("SELECT ca.id_aliment_compose, a.nom_aliment, ca.pourcentage_aliment FROM aliments a 
        JOIN composition_aliment ca ON a.id_aliment = ca.id_aliment_compose 
        WHERE ca.id_aliment_parent = :alimentId");
    $request->execute(['alimentId' => $alimentId]);
    return $request->fetchAll(PDO::FETCH_OBJ);
}


function fetchCompositionNutritionnelle($pdo, $alimentId) {
    $request = $pdo->prepare("SELECT COUNT(*) AS count_elements FROM composition_aliment WHERE id_aliment_parent = :alimentId");
    $request->execute(['alimentId' => $alimentId]);
    $count = $request->fetch(PDO::FETCH_OBJ)->count_elements;

    if ($count > 0) {
        $request = $pdo->prepare("SELECT 
            vn.nom_composition, 
            SUM((cvn.quantite_composition / (SELECT SUM(ca.pourcentage_aliment) 
            FROM composition_aliment ca 
            WHERE ca.id_aliment_parent = :alimentId)) * ca.pourcentage_aliment) AS valeur_relative
            FROM composition_val_nutritionnelles cvn 
            JOIN valeurs_nutritionnelles vn ON cvn.id_val_nutritionnelle = vn.id_composition 
            JOIN composition_aliment ca ON cvn.id_aliment = ca.id_aliment_compose 
            WHERE ca.id_aliment_parent = :alimentId 
            GROUP BY vn.nom_composition");
        $request->execute(['alimentId' => $alimentId]);
        return $request->fetchAll(PDO::FETCH_OBJ);
    } else {
        $request = $pdo->prepare("SELECT vn.nom_composition, cvn.quantite_composition 
            FROM composition_val_nutritionnelles cvn 
            JOIN valeurs_nutritionnelles vn ON cvn.id_val_nutritionnelle = vn.id_composition 
            WHERE cvn.id_aliment = :alimentId");
        $request->execute(['alimentId' => $alimentId]);
        return $request->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
