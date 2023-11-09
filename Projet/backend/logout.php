<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
session_start();

// Réinitialisation des variables de session


// Destruction de la session
session_destroy();

http_response_code(200);
echo json_encode(['message' => 'Déconnecté']);

?>
