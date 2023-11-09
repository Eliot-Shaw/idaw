<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('init_pdo.php'); // Inclure le fichier PDO

// Vérifier si $_SESSION['id_utilisateur'] est défini
if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur = $_SESSION['id_utilisateur'];
} else {
    $id_utilisateur = null; // Utilisateur non connecté
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
    
        if (isset($_GET['id_repas'])) {
            if ($_GET['id_repas'] === 'all') {
                if ($id_utilisateur) {
                    $allRepas = fetchAllRepasWithUserConstraint($pdo, $id_utilisateur, $start_date, $end_date);
                    if ($allRepas) {
                        http_response_code(200);
                        echo json_encode($allRepas);
                    } else {
                        http_response_code(404);
                        echo json_encode(['message' => 'Aucun repas trouvé']);
                    }
                } else {
                    http_response_code(403);
                    echo json_encode(['message' => 'Utilisateur non connecté']);
                }
            } else {
                $idRepas = $_GET['id_repas'];
                $repasDetails = fetchRepasDetails($pdo, $idRepas);
                if ($repasDetails) {
                    $repasDetails['composition'] = fetchCompositionRepas($pdo, $idRepas);
                    http_response_code(200);
                    echo json_encode($repasDetails);
                } else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Aucun repas trouvé pour cet ID']);
                }
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
            $insertRepas = $pdo->prepare("INSERT INTO repas (date_mange, id_utilisateur) VALUES (:date_mange, :id_utilisateur)");
            $insertRepas->bindParam(':date_mange', $dateRepas);
            $insertRepas->bindParam(':id_utilisateur', $id_utilisateur);
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
        $id_utilisateur = $_SESSION['id_utilisateur']; // Récupérer l'ID utilisateur de la session
    
        if (isset($_GET['id_repas']) && !empty($data['dateRepas']) && !empty($data['compositionRepas'])) {
            $idRepas = $_GET['id_repas'];
            $dateRepas = $data['dateRepas'];
    
            // Vérifier que le repas appartient à l'utilisateur avant de le mettre à jour
            $request = $pdo->prepare("SELECT id_repas FROM repas WHERE id_repas = :id_repas AND id_utilisateur = :id_utilisateur");
            $request->bindParam(':id_repas', $idRepas);
            $request->bindParam(':id_utilisateur', $id_utilisateur);
            $request->execute();
            $repasExist = $request->fetch();
    
            if ($repasExist) {
                // Mettre à jour la date du repas
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
                http_response_code(403);
                echo json_encode(['message' => 'Ce repas ne peut pas être modifié car il n\'appartient pas à cet utilisateur']);
            }
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

function fetchAllRepasWithUserConstraint($pdo, $id_utilisateur, $start_date, $end_date) {
    $query = "SELECT * FROM repas WHERE id_utilisateur = :id_utilisateur";

    // Ajout des conditions de date si des dates sont fournies
    if ($start_date && $end_date) {
        $query .= " AND date_mange BETWEEN :start_date AND :end_date";
    } else if ($start_date && !$end_date) {
        $query .= " AND date_mange >= :start_date";
    } else if (!$start_date && $end_date) {
        $query .= " AND date_mange <= :end_date";
    }

    $request = $pdo->prepare($query);

    // Lier les paramètres si des dates sont fournies
    $request->bindParam(':id_utilisateur', $id_utilisateur);

    if ($start_date) {
        $request->bindParam(':start_date', $start_date);
    }
    if ($end_date) {
        $request->bindParam(':end_date', $end_date);
    }

    $request->execute();
    $allRepas = $request->fetchAll(PDO::FETCH_ASSOC);

    foreach ($allRepas as $key => $repas) {
        $idRepas = $repas['id_repas'];
        $composition = fetchCompositionRepas($pdo, $idRepas);
        $allRepas[$key]['composition'] = $composition;
    }

    return $allRepas;
}

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
