<?php
    require_once('init_pdo.php');
    $sql_content = file_get_contents('sql/create_db.sql');
    $request = $pdo->prepare($sql_content);

    $request->execute();
?>