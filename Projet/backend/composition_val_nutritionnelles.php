<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Replace with the correct path

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        if (isset($_POST['id_aliment']) && isset($_POST['id_val_nutritionnelle']) && isset($_POST['quantite_composition'])) {
            $idAliment = $_POST['id_aliment'];
            $idValNutritionnelle = $_POST['id_val_nutritionnelle'];
            $quantiteComposition = $_POST['quantite_composition'];

            // Prepare the insertion query
            $insertCompositionValNut = $pdo->prepare("INSERT INTO composition_val_nutritionnelles (id_aliment, id_val_nutritionnelle, quantite_composition) VALUES (:id_aliment, :id_val_nutritionnelle, :quantite_composition)");
            $insertCompositionValNut->bindParam(':id_aliment', $idAliment);
            $insertCompositionValNut->bindParam(':id_val_nutritionnelle', $idValNutritionnelle);
            $insertCompositionValNut->bindParam(':quantite_composition', $quantiteComposition);

            if ($insertCompositionValNut->execute()) {
                $newId = $pdo->lastInsertId();

                http_response_code(201);
                echo json_encode(['message' => 'Composition val nutritionnelle ajoutée avec succès', 'id' => $newId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout de la composition val nutritionnelle']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID d\'aliment, ID de val nutritionnelle ou quantité de composition non fournie']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;
?>
