<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Include the PDO file

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST['id_aliment']) && isset($_POST['id_categorie'])) {
            $idAliment = $_POST['id_aliment'];
            $idCategorie = $_POST['id_categorie'];

            // Prepare the insertion query
            $insertAlimentCategorie = $pdo->prepare("INSERT INTO aliment_categories (id_aliment, id_categorie) VALUES (:id_aliment, :id_categorie)");
            $insertAlimentCategorie->bindParam(':id_aliment', $idAliment);
            $insertAlimentCategorie->bindParam(':id_categorie', $idCategorie);

            if ($insertAlimentCategorie->execute()) {
                http_response_code(201);
                echo json_encode(['message' => 'Liaison aliment-catégorie ajoutée avec succès', 'idAliment' => $idAliment, 'idCategorie' => $idCategorie]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de la liaison aliment-catégorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment ou ID de catégorie non fourni']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        if (isset($_DELETE['id_aliment'])) {
            $idAliment = $_DELETE['id_aliment'];

            // Prepare the deletion query
            $deleteAlimentCategorie = $pdo->prepare("DELETE FROM aliment_categories WHERE id_aliment=:id_aliment");
            $deleteAlimentCategorie->bindParam(':id_aliment', $idAliment);

            if ($deleteAlimentCategorie->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Liaison aliment-catégorie supprimée avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression de la liaison aliment-catégorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment non fourni']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;
?>
