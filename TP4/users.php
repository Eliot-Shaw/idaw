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
    echo "
        <form id=\"add_entry_form\" action=\"logic.php\" method=\"GET\">
    ";
    echo "
        <table>
        <th>id</th>
        <th>nom</th>
        <th>email</th>
        <th>remove</th>
        <th>edit</th>
    ";
    foreach($reponss as $reponse){
        echo "
            <tr>
                <td>" . $reponse->id . "</td>
                <td>" . $reponse->nom ."</td>
                <td>". $reponse->email . "</td>
                <td><input type=\"submit\" name=\"remove\" value=\"".$reponse->id."\"/></td>
                <td><input type=\"submit\" name=\"edit\" value=\"".$reponse->id."\"/></td>
            </tr>
        ";
        if(isset($_GET['edit'])){
            if($reponse->id == $_GET['edit']){
                $edit_id = $reponse->id;
                $edit_nom = $reponse->nom;
                $edit_email = $reponse->email;
            }
        }
    }
    echo "
        </table>
        <br>
        <table>
            <tr>
                <th>UserName :</th>
                <td><input type=\"text\" name=\"user\"
    ";
    if(isset($edit_nom)) echo "value = \"".$edit_nom."\"";
    echo "
                ></td>
            </tr>
            <tr>
                <th>Email :</th>
                <td><input type=\"email\" name=\"email\"
    ";
    if(isset($edit_email)) echo "value = \"".$edit_email."\"";
    echo "
                ></td>
            </tr>
        <br>
            <tr>
                <th></th>
                <td><input type=\"submit\" name=\"add\" value=\"Add value\"/></td> 
                <td><input type=\"submit\" name=\"validate\"
    ";
    if(isset($edit_id)) echo "value = \"".$edit_id."\"";
    else echo "value = \"\" style=\"hidden:true\"";
    echo "
                /></td> 
            </tr>
        </table>
    ";

    /*** close the database connection ***/
    $pdo = null;
?>
