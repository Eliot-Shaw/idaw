<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Chemin pour inclure le fichier PDO

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id_composition']) && is_numeric($_GET['id_composition'])) {
            $compositionId = $_GET['id_composition'];

            // Récupération des détails de la valeur nutritionnelle
            $nutritionDetails = fetchNutritionDetails($pdo, $compositionId);
            if ($nutritionDetails) {
                $nutritionDescription = [
                    'nom_composition' => $nutritionDetails->nom_composition,
                    'autres_attributs' => fetchOtherAttributes($pdo, $compositionId),
                ];

                http_response_code(200);
                echo json_encode($nutritionDescription);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucune valeur nutritionnelle trouvée pour cet ID']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de composition nutritionnelle non valide ou non fourni']);
        }
        break;


    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Vérification de la présence des données requises dans la requête POST
        if (isset($_POST['nom_composition'])) {
            $nomComposition = $_POST['nom_composition'];

            // Préparation de la requête d'insertion
            $insertNutrition = $pdo->prepare("INSERT INTO valeurs_nutritionnelles (nom_composition) VALUES (:nom_composition)");
            $insertNutrition->bindParam(':nom_composition', $nomComposition);

            // Exécution de la requête
            if ($insertNutrition->execute()) {
                $newCompositionId = $pdo->lastInsertId(); // Récupération de l'ID de la composition ajoutée

                http_response_code(201);
                echo json_encode(['message' => 'Valeur nutritionnelle ajoutée avec succès', 'id_composition' => $newCompositionId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de la valeur nutritionnelle']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Nom de composition nutritionnelle non fourni']);
        }
        break;

    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        // Vérification de la présence des données requises dans la requête PUT
        if (isset($_PUT['id_composition']) && isset($_PUT['nouveau_nom_composition'])) {
            $idComposition = $_PUT['id_composition'];
            $nouveauNomComposition = $_PUT['nouveau_nom_composition'];

            // Préparation de la requête de mise à jour
            $updateNutrition = $pdo->prepare("UPDATE valeurs_nutritionnelles SET nom_composition = :nouveau_nom_composition WHERE id_composition = :id_composition");
            $updateNutrition->bindParam(':nouveau_nom_composition', $nouveauNomComposition);
            $updateNutrition->bindParam(':id_composition', $idComposition);

            // Exécution de la requête
            if ($updateNutrition->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Valeur nutritionnelle mise à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la mise à jour de la valeur nutritionnelle']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de la valeur nutritionnelle ou nouveau nom non fourni']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        // Vérification de la présence de l'ID de la valeur nutritionnelle dans la requête DELETE
        if (isset($_DELETE['id_composition'])) {
            $idComposition = $_DELETE['id_composition'];

            // Préparation de la requête de suppression
            $deleteNutrition = $pdo->prepare("DELETE FROM valeurs_nutritionnelles WHERE id_composition = :id_composition");
            $deleteNutrition->bindParam(':id_composition', $idComposition);

            // Exécution de la requête
            if ($deleteNutrition->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Valeur nutritionnelle supprimée avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression de la valeur nutritionnelle']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de la valeur nutritionnelle non fourni pour la suppression']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

?>
