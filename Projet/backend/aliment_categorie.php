<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('../init_pdo.php'); // Include the PDO file

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Perform the GET operation
        // ...

    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST['id_aliment']) && isset($_POST['id_categorie'])) {
            $idAliment = $_POST['id_aliment'];
            $idCategorie = $_POST['id_categorie'];

            // Prepare the insertion query
            $insertAlimentCategorie = $pdo->prepare("INSERT INTO aliment_categorie (id_aliment, id_categorie) VALUES (:id_aliment, :id_categorie)");
            $insertAlimentCategorie->bindParam(':id_aliment', $idAliment);
            $insertAlimentCategorie->bindParam(':id_categorie', $idCategorie);

            if ($insertAlimentCategorie->execute()) {
                $newId = $pdo->lastInsertId();

                http_response_code(201);
                echo json_encode(['message' => 'Liaison aliment-categorie ajoutée avec succès', 'id' => $newId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de la liaison aliment-categorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment ou ID de catégorie non fourni']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        if (isset($_DELETE['id'])) {
            $idToDelete = $_DELETE['id'];

            $deleteAlimentCategorie = $pdo->prepare("DELETE FROM aliment_categorie WHERE id = :id");
            $deleteAlimentCategorie->bindParam(':id', $idToDelete);

            if ($deleteAlimentCategorie->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Liaison aliment-categorie supprimée avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression de la liaison aliment-categorie']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de liaison aliment-categorie non fourni pour la suppression']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;
?>
