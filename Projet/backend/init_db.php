<?php
    require_once('db_connect.php');
    $sql_content = file_get_contents('sql/create_db.sql');
    $request = $pdo->prepare($sql_content);

    $request->execute();
?>