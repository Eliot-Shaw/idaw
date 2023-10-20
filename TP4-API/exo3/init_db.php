<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Configuration</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="default" charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php
    require_once('db_connect.php');
    $sql_content = file_get_contents('sql/create_db.sql');
    $request = $pdo->prepare($sql_content);

    print_r($request);
    ?>
</body>

</html>