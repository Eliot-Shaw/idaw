<?php 
    require_once('config.php');
    $connectionString = "mysql:host=". _MYSQL_HOST;
    if(defined('_MYSQL_PORT'))
        $connectionString .= ";port=". _MYSQL_PORT;
        $connectionString .= ";dbname=" . _MYSQL_DBNAME;
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );
        $pdo = NULL;
    try {
        $pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $erreur) {
        http_response_code(500);
        echo json_encode(["message" => "Erreur : ".$erreur->getMessage()]);
    }
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $request = $pdo->prepare("select * from users ORDER BY id ASC");

        if(!$request->execute()){
            http_response_code(500);
            echo json_encode(["message" => "erreur lors de la lecture des utilisateurs."]);
        }else{
            // retrieve data from database using fetch(PDO::FETCH_OBJ) and
            $reponss = $request->fetchAll(PDO::FETCH_OBJ);
        
            http_response_code(200);
            echo json_encode($reponss);
        }

        /*** close the database connection ***/
        $pdo = null;       
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents('php://input'));
        
        if (!isset($data->nom) || !isset($data->email)) {
            http_response_code(400);
            echo json_encode(["message" => "Les champs 'nom' et 'email' sont obligatoires."]);
        } else {
            $request = $pdo->prepare("INSERT INTO `users` (nom, email) VALUES ('{$data->nom}', '{$data->email}')");
            if($request->execute()){
                http_response_code(201);
                echo json_encode(["message" => "Utilisateur créé avec succès.", "id" => $pdo->lastInsertId()]);
            }else{
                http_response_code(500);
                echo json_encode(["message" => "Erreur lors de la création de l'utilisateur."]);
            }
        }

        /*** close the database connection ***/
        $pdo = null;
    }
?>