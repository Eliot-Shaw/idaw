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

            $data = json_decode(file_get_contents("php://input"), true);

            $request = $pdo->prepare("INSERT INTO `aliments` (`id`, `name`, `email`) VALUES ('','" . $data['name'] . "','" . $data['mail'] . "')");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_OBJ);

            echo json_encode($result);
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