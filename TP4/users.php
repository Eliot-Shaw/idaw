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
        echo "";
        echo "id: " . $reponse->id . "   nom: " . $reponse->nom ."    email : ". $reponse->email . "<br>";
    }

    /*** close the database connection ***/
    $pdo = null;
?>

<br>

<form id="add_entry_form" action="add_entry.php" method="POST">
    <table>
        <tr>
            <th>UserName :</th>
            <td><input type="text" name="user"></td>
            </tr>
            <tr>
            <th>Email :</th>
            <td><input type="email" name="email"></td>
            </tr>
            <tr>
            <th></th>
            <td><input type="submit" value="Validate" /></td> 
        </tr>
    </table>
</form>


<form id="remove_form" action="remove.php" method="POST">
    <table>
        <td><input type="submit" value="Remove all selected !" /></td> 
    </table>
</form>

<form id="checkbox_form" method="POST">
    <input type="checkbox" id="selected" name="selected"/>
</form>