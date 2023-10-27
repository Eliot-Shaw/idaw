<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    require_once('init_pdo.php');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

            $request = $pdo->prepare("SELECT * FROM aliments");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_OBJ);
            $reponse= json_encode($result);
            http_response_code(200);
            echo $reponse;
            break;

        case 'POST':
            $request = $pdo->prepare("INSERT INTO aliments (nom_aliment) VALUES (:nom_aliment)");
            $data = json_decode(file_get_contents("php://input"), true);
            if(isset($data['nom_aliment'])){
                $result = $request->execute([
                    'nom_aliment' => $data['nom_aliment'],
                ]);
            if(!$result){
                http_response_code(400);
                break;
            }
            $result = $pdo->lastInsertId();
            http_response_code(201);
            echo $result;
            break;
            }
            // elseif(isset($data['code_aliment'])){
            //     echo"treeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee";
            //     $ajout_aliment = @file_get_contents("https://world.openfoodfacts.org/api/v2/search?code=".$data['code_aliment']);
            //     if($ajout_aliment===FALSE){
            //         http_response_code(404);
            //         break;
            //     }
            //     $reponse_ajout_aliment = (json_decode($ajout_aliment)->products);
            //     var_dump($reponse_ajout_aliment);
            //     break;
            // }
            
            break;

        case 'PUT':

            // $data = json_decode(file_get_contents("php://input"), true);

            // $request = $pdo->prepare("UPDATE aliments SET name = '" . $data['name'] . "', email = '" . $data['mail'] . "' WHERE id = " . $data['id']);
            // $request->execute();
            // $result = $request->fetchAll(PDO::FETCH_OBJ);

            // checkAndResponse($request, $result);
            // break;

        case 'DELETE':
            // $data = json_decode(file_get_contents("php://input"), true);

            // $request = $pdo->prepare("DELETE FROM `aliments` WHERE `id` = " . $data['id']);
            // $request->execute();
            // $result = $request->fetchAll(PDO::FETCH_OBJ);

            // checkAndResponse($request, $result);
            // break;

        default:
            http_response_code(405);
            echo json_encode(array('message' => 'Méthode non autorisée'));
            break;
    }
    /*** close the database connection ***/
    $pdo = null;
?>