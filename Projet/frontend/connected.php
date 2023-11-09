<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    var base_url = "<?php echo _BASE_URL; ?>";
    var userData;

    $(document).ready(function () {
        $.ajax({
            url: "http://localhost:8888/ProjetNU/idaw/Projet/backend/utilisateur.php?utilisateur=check",
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Les données sont récupérées avec succès
                // Vous pouvez les stocker dans une variable ou les utiliser directement

                // Exemple de stockage dans une variable
                userData = data;

                // Vous pouvez maintenant utiliser userData dans la page
                console.log(userData); // Affichez les données dans la console du navigateur
            },
            error: function () {
                // Une erreur s'est produite lors de la récupération des données
                console.log("Une erreur s'est produite");
            }
        });
    });
</script>


<?php
session_start();
// on simule une base de données
print_r($userData);
print_r(gettype($userData));

$login = "anonymous";
$errorText = "";
$successfullyLogged = false;

if (isset($_POST['login']) && isset($_POST['password'])) {
    $tryLogin = $_POST['login'];
    $tryPwd = $_POST['password'];
    // si login existe et password correspond
    if (array_key_exists($tryLogin, $userData) && $userData[$tryLogin] == $tryPwd) {
        $successfullyLogged = true;
        $login = $tryLogin;
    } else

        $errorText = "Wrong login/password";

} else
    $errorText = "Merci d'utiliser le formulaire de login";
if (!$successfullyLogged) {
    echo $errorText;
} else {
    $_SESSION['login'] = $login;
    header("Location: index.php");
}
?>