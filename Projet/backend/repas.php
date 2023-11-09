<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Inclure le fichier PDO

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id_repas'])) {
            $idRepas = $_GET['id_repas'];

            // Récupérer les détails du repas avec son ID spécifique
            $repasDetails = fetchRepasDetails($pdo, $idRepas);

            if ($repasDetails) {
                $repasDetails['composition'] = fetchCompositionRepas($pdo, $idRepas); // Récupérer la composition du repas

                http_response_code(200);
                echo json_encode($repasDetails);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Aucun repas trouvé pour cet ID']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de repas non fourni']);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($data['dateRepas']) && !empty($data['compositionRepas'])) {
            // Insertion d'un nouveau repas dans la table 'repas'
            $dateRepas = $data['dateRepas'];
            $insertRepas = $pdo->prepare("INSERT INTO repas (date_mange) VALUES (:date_mange)");
            $insertRepas->bindParam(':date_mange', $dateRepas);
            $insertRepas->execute();
            $idRepas = $pdo->lastInsertId();

            // Insertion de la composition du repas dans la table 'composition_repas'
            foreach ($data['compositionRepas'] as $aliment) {
                $nomAliment = $aliment['nomAliment'];
                $quantite = $aliment['quantite'];

                // Récupération de l'ID de l'aliment
                $selectAliment = $pdo->prepare("SELECT id_aliment FROM aliments WHERE nom_aliment = :nom_aliment");
                $selectAliment->bindParam(':nom_aliment', $nomAliment);
                $selectAliment->execute();
                $idAliment = $selectAliment->fetchColumn();

                // Si l'aliment n'existe pas, on peut l'ajouter ici dans la table 'aliments'
                if (!$idAliment) {
                    $insertAliment = $pdo->prepare("INSERT INTO aliments (nom_aliment) VALUES (:nom_aliment)");
                    $insertAliment->bindParam(':nom_aliment', $nomAliment);
                    $insertAliment->execute();
                    $idAliment = $pdo->lastInsertId();

                    // Insertion dans la table 'aliment_categories' avec la catégorie 0 = aucune
                    $insertCategorie = $pdo->prepare("INSERT INTO aliment_categories (id_aliment, id_categorie) VALUES (:id_aliment, 0)");
                    $insertCategorie->bindParam(':id_aliment', $idAliment);
                    $insertCategorie->execute();
                }

                // Insertion dans la table 'composition_repas'
                $insertComposition = $pdo->prepare("INSERT INTO composition_repas (id_repas, id_aliment, quantite) VALUES (:id_repas, :id_aliment, :quantite)");
                $insertComposition->bindParam(':id_repas', $idRepas);
                $insertComposition->bindParam(':id_aliment', $idAliment);
                $insertComposition->bindParam(':quantite', $quantite);
                $insertComposition->execute();
            }

            http_response_code(201);
            echo json_encode(['message' => 'Le repas a été ajouté avec succès', 'id_repas' => $idRepas]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données manquantes pour ajouter le repas']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($_GET['id_repas']) && !empty($data['dateRepas']) && !empty($data['compositionRepas'])) {
            $idRepas = $_GET['id_repas'];
            $dateRepas = $data['dateRepas'];

            // Mise à jour de la date du repas
            $updateRepas = $pdo->prepare("UPDATE repas SET date_mange = :date_mange WHERE id_repas = :id_repas");
            $updateRepas->bindParam(':date_mange', $dateRepas);
            $updateRepas->bindParam(':id_repas', $idRepas);
            $updateRepas->execute();

            // Suppression de l'ancienne composition pour mettre à jour avec la nouvelle
            $deleteComposition = $pdo->prepare("DELETE FROM composition_repas WHERE id_repas = :id_repas");
            $deleteComposition->bindParam(':id_repas', $idRepas);
            $deleteComposition->execute();

            // Insertion de la nouvelle composition
            foreach ($data['compositionRepas'] as $aliment) {
                $nomAliment = $aliment['nomAliment'];
                $quantite = $aliment['quantite'];

                // Récupération de l'ID de l'aliment
                $selectAliment = $pdo->prepare("SELECT id_aliment FROM aliments WHERE nom_aliment = :nom_aliment");
                $selectAliment->bindParam(':nom_aliment', $nomAliment);
                $selectAliment->execute();
                $idAliment = $selectAliment->fetchColumn();

                if (!$idAliment) {
                    $insertAliment = $pdo->prepare("INSERT INTO aliments (nom_aliment) VALUES (:nom_aliment)");
                    $insertAliment->bindParam(':nom_aliment', $nomAliment);
                    $insertAliment->execute();
                    $idAliment = $pdo->lastInsertId();

                    // Insertion dans la table 'aliment_categories' avec la catégorie 0 = aucune
                    $insertCategorie = $pdo->prepare("INSERT INTO aliment_categories (id_aliment, id_categorie) VALUES (:id_aliment, 0)");
                    $insertCategorie->bindParam(':id_aliment', $idAliment);
                    $insertCategorie->execute();
                }

                // Insertion dans la table 'composition_repas'
                $insertComposition = $pdo->prepare("INSERT INTO composition_repas (id_repas, id_aliment, quantite) VALUES (:id_repas, :id_aliment, :quantite)");
                $insertComposition->bindParam(':id_repas', $idRepas);
                $insertComposition->bindParam(':id_aliment', $idAliment);
                $insertComposition->bindParam(':quantite', $quantite);
                $insertComposition->execute();
            }

            http_response_code(200);
            echo json_encode(['message' => 'Le repas a été mis à jour avec succès']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID de repas ou données manquantes pour mettre à jour le repas']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}

$pdo = null;

function fetchRepasDetails($pdo, $idRepas) {
    $request = $pdo->prepare("SELECT * FROM repas WHERE id_repas = :id_repas");
    $request->execute(['id_repas' => $idRepas]);
    return $request->fetch(PDO::FETCH_ASSOC);
}

function fetchCompositionRepas($pdo, $idRepas) {
    $request = $pdo->prepare("SELECT a.nom_aliment, cr.quantite 
                             FROM composition_repas cr
                             JOIN aliments a ON cr.id_aliment = a.id_aliment 
                             WHERE cr.id_repas = :id_repas");
    $request->execute(['id_repas' => $idRepas]);
    return $request->fetchAll(PDO::FETCH_ASSOC);
}
?>
