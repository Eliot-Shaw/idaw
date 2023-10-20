<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Configuration</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" title="default" charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <h1>Users</h1>

    <?php

    require_once('db_connect.php');

    $request = $pdo->prepare("select * from users");
    // TODO: add your code here
    // retrieve data from database using fetch(PDO::FETCH_OBJ) and
    // display them in HTML array
    $request->execute();
    $usersTab = $request->fetchAll(PDO::FETCH_OBJ);

    // print_r($usersTab);

    echo '<table>';
    echo '<thead>';
    // foreach ($usersTab as $user) {
    //     echo '<tr>' . $user[] . '</tr>';
    // }
    echo '<th>ID</th><th>Name</th><th>Email</th>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($usersTab as $user) {
        echo '<tr>';
        foreach ($user as $champ) {
            echo '<td>' . $champ . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    /*** close the database connection ***/
    $pdo = null;
    ?>

</body>

</html>