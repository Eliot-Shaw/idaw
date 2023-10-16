<!-- INCORPORER DANS INTERFACE PUIS L'UTILISER DANS LOGIN -->

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
        echo 'Erreur : '.$erreur->getMessage();
    }
    $request = $pdo->prepare("select * from users");

    $request->execute();

    // retrieve data from database using fetch(PDO::FETCH_OBJ) and
    $reponss = $request->fetchAll(PDO::FETCH_OBJ);

    foreach($reponss as $reponse){
        echo "id: " . $reponse->id . "   nom: " . $reponse->nom ."    email : ". $reponse->email . "<br>";
    }

    /*** close the database connection ***/
    $pdo = null;
?>


