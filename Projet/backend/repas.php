<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Chemin pour inclure le fichier PDO

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['repas']) && is_numeric($_GET['repas'])) {
            $repasId = $_GET['repas'];

            // Récupération des détails du repas
            $repasDetails = fetchRepasDetails($pdo, $repasId);
            if ($repasDetails) {
                $repasDescription = [
                    'id_repas' => $repasDetails->id_repas,
                    'id_utilisateur' => $repasDetails->id_utilisateur,
                    'date_mange' => $repasDetails->date_mange,
                    // Ajoutez d'autres détails si nécessaire
                ];

                http_response_code(200);
                echo json_encode($repasDescription);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucun repas trouvé pour cet ID']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de repas non valide ou non fourni']);
        }
        break;


    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Vérifier si les données nécessaires pour créer un repas sont fournies
        if (isset($_POST['id_utilisateur']) && isset($_POST['date_mange'])) {
            $idUtilisateur = $_POST['id_utilisateur'];
            $dateMange = $_POST['date_mange'];

            // Préparation de la requête d'insertion
            $insertRepas = $pdo->prepare("INSERT INTO repas (id_utilisateur, date_mange) VALUES (:id_utilisateur, :date_mange)");
            $insertRepas->bindParam(':id_utilisateur', $idUtilisateur);
            $insertRepas->bindParam(':date_mange', $dateMange);

            // Exécution de la requête
            if ($insertRepas->execute()) {
                $newRepasId = $pdo->lastInsertId(); // Récupération de l'ID du nouveau repas

                http_response_code(201);
                echo json_encode(['message' => 'Repas ajouté avec succès', 'id_repas' => $newRepasId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout du repas']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données de repas manquantes']);
        }
        break;

    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        // Vérifier si les données nécessaires pour la mise à jour d'un repas sont fournies
        if (isset($_PUT['id_repas']) && isset($_PUT['nouvelle_date'])) {
            $idRepas = $_PUT['id_repas'];
            $nouvelleDate = $_PUT['nouvelle_date'];

            // Préparation de la requête de mise à jour
            $updateRepas = $pdo->prepare("UPDATE repas SET date_mange = :nouvelle_date WHERE id_repas = :id_repas");
            $updateRepas->bindParam(':nouvelle_date', $nouvelleDate);
            $updateRepas->bindParam(':id_repas', $idRepas);

            // Exécution de la requête
            if ($updateRepas->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Repas mis à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la mise à jour du repas']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données de repas manquantes pour la mise à jour']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'ID du repas à supprimer est fourni dans la requête DELETE
        if (isset($_DELETE['id_repas'])) {
            $idRepas = $_DELETE['id_repas'];

            // Préparation de la requête de suppression
            $deleteRepas = $pdo->prepare("DELETE FROM repas WHERE id_repas = :id_repas");
            $deleteRepas->bindParam(':id_repas', $idRepas);

            // Exécution de la requête
            if ($deleteRepas->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Repas supprimé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression du repas']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de repas non fourni pour la suppression']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

?>
