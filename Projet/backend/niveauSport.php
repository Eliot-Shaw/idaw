<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Chemin pour inclure le fichier PDO

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['sport']) && is_numeric($_GET['sport'])) {
            $sportId = $_GET['sport'];

            // Récupérer les détails d'un niveau de sport spécifique avec l'ID fourni
            $request = $pdo->prepare("SELECT * FROM niveau_sport WHERE id_niveau_sport = :sportId");
            $request->execute(['sportId' => $sportId]);
            $sportDetails = $request->fetch(PDO::FETCH_ASSOC);
            if ($sportDetails) {
                http_response_code(200);
                echo json_encode($sportDetails);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucun niveau de sport trouvé pour cet ID']);
            }
        } else {
            // Récupérer tous les niveaux de sport
            $request = $pdo->query("SELECT * FROM niveau_sport");
            $allSports = $request->fetchAll(PDO::FETCH_ASSOC);
            if ($allSports) {
                http_response_code(200);
                echo json_encode($allSports);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucun niveau de sport trouvé']);
            }
        }
        break;


    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);

        // Vérifier si les données nécessaires pour le niveau de sport sont fournies
        if (isset($_POST['nom_niveau_sport']) && isset($_POST['coef_sport'])) {
            $nomNiveauSport = $_POST['nom_niveau_sport'];
            $coefSport = $_POST['coef_sport'];

            // Préparation de la requête d'insertion
            $insertSport = $pdo->prepare("INSERT INTO niveau_sport (nom_niveau_sport, coef_sport) VALUES (:nom_niveau_sport, :coef_sport)");
            $insertSport->bindParam(':nom_niveau_sport', $nomNiveauSport);
            $insertSport->bindParam(':coef_sport', $coefSport);

            // Exécution de la requête
            if ($insertSport->execute()) {
                $newSportId = $pdo->lastInsertId(); // Récupération de l'ID du niveau de sport ajouté

                http_response_code(201);
                echo json_encode(['message' => 'Niveau de sport ajouté avec succès', 'id_niveau_sport' => $newSportId]);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de l\'ajout du niveau de sport']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données du niveau de sport non fournies']);
        }
        break;

    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);

        // Vérifier si les données nécessaires pour la mise à jour du niveau de sport sont fournies
        if (isset($_PUT['id_niveau_sport']) && isset($_PUT['nom_niveau_sport']) && isset($_PUT['coef_sport'])) {
            $idNiveauSport = $_PUT['id_niveau_sport'];
            $nomNiveauSport = $_PUT['nom_niveau_sport'];
            $coefSport = $_PUT['coef_sport'];

            // Préparation de la requête de mise à jour
            $updateSport = $pdo->prepare("UPDATE niveau_sport SET nom_niveau_sport = :nom_niveau_sport, coef_sport = :coef_sport WHERE id_niveau_sport = :id_niveau_sport");
            $updateSport->bindParam(':nom_niveau_sport', $nomNiveauSport);
            $updateSport->bindParam(':coef_sport', $coefSport);
            $updateSport->bindParam(':id_niveau_sport', $idNiveauSport);

            // Exécution de la requête
            if ($updateSport->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Niveau de sport mis à jour avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la mise à jour du niveau de sport']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données du niveau de sport non fournies pour la mise à jour']);
        }
        break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input'), true);

        // Vérifier si l'identifiant du niveau de sport à supprimer est fourni
        if (isset($_DELETE['id_niveau_sport'])) {
            $idNiveauSport = $_DELETE['id_niveau_sport'];

            // Préparation de la requête de suppression
            $deleteSport = $pdo->prepare("DELETE FROM niveau_sport WHERE id_niveau_sport = :id_niveau_sport");
            $deleteSport->bindParam(':id_niveau_sport', $idNiveauSport);

            // Exécution de la requête
            if ($deleteSport->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'Niveau de sport supprimé avec succès']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Échec de la suppression du niveau de sport']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Identifiant du niveau de sport non fourni pour la suppression']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

?>
