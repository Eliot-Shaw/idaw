<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('db_connect.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':

        $request = $pdo->prepare("SELECT * FROM users");
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);

        checkAndResponse($request, ["data" => $result]);
        break;

    case 'POST':

        $data = json_decode(file_get_contents("php://input"), true);

        $request = $pdo->prepare("INSERT INTO `users` (`id`, `name`, `email`) VALUES ('','" . $data['name'] . "','" . $data['mail'] . "')");
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);

        checkAndResponse($request, $result);
        break;

    case 'PUT':

        $data = json_decode(file_get_contents("php://input"), true);

        $request = $pdo->prepare("UPDATE users SET name = '" . $data['name'] . "', email = '" . $data['mail'] . "' WHERE id = " . $data['id']);
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);

        checkAndResponse($request, $result);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);

        $request = $pdo->prepare("DELETE FROM `users` WHERE `id` = " . $data['id']);
        $request->execute();
        $result = $request->fetchAll(PDO::FETCH_OBJ);

        checkAndResponse($request, $result);
        break;

    default:
        http_response_code(405);
        echo json_encode(array('message' => 'Méthode non autorisée'));
        break;
}
