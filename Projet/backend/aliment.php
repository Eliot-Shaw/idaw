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
// -----------------------------------------------------------------------------------------------
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Vérifier si le nom de l'aliment est fourni dans la requête POST
        if (isset($_POST['nom_aliment'])) {
            $nomAliment = $_POST['nom_aliment'];

            // Préparation de la requête d'insertion
            $insertAliment = $pdo->prepare("INSERT INTO aliments (nom_aliment) VALUES (:nom_aliment)");
            $insertAliment->bindParam(':nom_aliment', $nomAliment);

            // Exécution de la requête
            if ($insertAliment->execute()) {
                $newAlimentId = $pdo->lastInsertId(); // Récupération de l'ID de l'aliment ajouté

                http_response_code(201);
                echo json_encode(['message' => 'Aliment ajouté avec succès', 'id_aliment' => $newAlimentId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de l\'aliment']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Nom d\'aliment non fourni']);
        }
        break;
// -----------------------------------------------------------------------------------------------
case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'ID de l'aliment et le nouveau nom sont fournis dans la requête PUT
        if (isset($_PUT['id_aliment']) && isset($_PUT['nouveau_nom_aliment'])) {
            $idAliment = $_PUT['id_aliment'];
            $nouveauNomAliment = $_PUT['nouveau_nom_aliment'];

            // Préparation de la requête de mise à jour
            $updateAliment = $pdo->prepare("UPDATE aliments SET nom_aliment = :nouveau_nom_aliment WHERE id_aliment = :id_aliment");
            $updateAliment->bindParam(':nouveau_nom_aliment', $nouveauNomAliment);
            $updateAliment->bindParam(':id_aliment', $idAliment);

            // Exécution de la requête
            if ($updateAliment->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Aliment mis à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la mise à jour de l\'aliment']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment ou nouveau nom d\'aliment non fourni']);
        }
        break;
// -----------------------------------------------------------------------------------------------
    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'ID de l'aliment à supprimer est fourni dans la requête DELETE
        if (isset($_DELETE['id_aliment'])) {
            $idAliment = $_DELETE['id_aliment'];

            // Préparation de la requête de suppression
            $deleteAliment = $pdo->prepare("DELETE FROM aliments WHERE id_aliment = :id_aliment");
            $deleteAliment->bindParam(':id_aliment', $idAliment);

            // Exécution de la requête
            if ($deleteAliment->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Aliment supprimé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression de l\'aliment']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment non fourni pour la suppression']);
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
