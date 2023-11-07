<?php
    require_once('init_pdo.php');

    $sql_create = file_get_contents('sql/create_db.sql');
    $request_create = $pdo->prepare($sql_create);
    $request_create->execute();
    $request_create->closeCursor();

    $sql_fill = file_get_contents('sql/fill_db.sql');
    $request_fill = $pdo->prepare($sql_fill);
    $request_fill->execute();
    $request_fill->closeCursor(); 
?>