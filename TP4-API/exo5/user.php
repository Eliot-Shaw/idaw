<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('db_connect.php');

$request_uri = $_SERVER['REQUEST_URI'];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $segments = explode('/', trim($request_uri, '/'));
        $id = $segments[4];

        $request = $pdo->prepare("SELECT * FROM users WHERE `id` = " . $id);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_OBJ);

        checkAndResponse($request, $result);
        break;
    default:
        http_response_code(405);
        echo json_encode(array('message' => 'Méthode non autorisée'));
        break;
}
