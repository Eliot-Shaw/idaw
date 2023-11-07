<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('../init_pdo.php'); // Chemin pour inclure le fichier PDO

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['categorie']) && is_numeric($_GET['categorie'])) {
            $categorieId = $_GET['categorie'];

            // Récupération des détails de la catégorie
            $categorieDetails = fetchCategorieDetails($pdo, $categorieId);
            if ($categorieDetails) {
                http_response_code(200);
                echo json_encode($categorieDetails);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucune catégorie trouvée pour cet ID']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de catégorie non valide ou non fourni']);
        }
        break;


    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Vérifier si le nom de la catégorie est fourni dans la requête POST
        if (isset($_POST['nom_categorie'])) {
            $nomCategorie = $_POST['nom_categorie'];

            // Préparation de la requête d'insertion
            $insertCategorie = $pdo->prepare("INSERT INTO categories (nom_categorie) VALUES (:nom_categorie)");
            $insertCategorie->bindParam(':nom_categorie', $nomCategorie);

            // Exécution de la requête
            if ($insertCategorie->execute()) {
                $newCategorieId = $pdo->lastInsertId(); // Récupération de l'ID de la catégorie ajoutée

                http_response_code(201);
                echo json_encode(['message' => 'Catégorie ajoutée avec succès', 'id_categorie' => $newCategorieId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de la catégorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Nom de catégorie non fourni']);
        }
        break;

    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'ID de la catégorie et le nouveau nom sont fournis dans la requête PUT
        if (isset($_PUT['id_categorie']) && isset($_PUT['nouveau_nom_categorie'])) {
            $idCategorie = $_PUT['id_categorie'];
            $nouveauNomCategorie = $_PUT['nouveau_nom_categorie'];

            // Préparation de la requête de mise à jour
            $updateCategorie = $pdo->prepare("UPDATE categories SET nom_categorie = :nouveau_nom_categorie WHERE id_categorie = :id_categorie");
            $updateCategorie->bindParam(':nouveau_nom_categorie', $nouveauNomCategorie);
            $updateCategorie->bindParam(':id_categorie', $idCategorie);

            // Exécution de la requête
            if ($updateCategorie->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Catégorie mise à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la mise à jour de la catégorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de catégorie ou nouveau nom de catégorie non fourni']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'ID de la catégorie à supprimer est fourni dans la requête DELETE
        if (isset($_DELETE['id_categorie'])) {
            $idCategorie = $_DELETE['id_categorie'];

            // Préparation de la requête de suppression
            $deleteCategorie = $pdo->prepare("DELETE FROM categories WHERE id_categorie = :id_categorie");
            $deleteCategorie->bindParam(':id_categorie', $idCategorie);

            // Exécution de la requête
            if ($deleteCategorie->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Catégorie supprimée avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression de la catégorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de catégorie non fourni pour la suppression']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

?>
