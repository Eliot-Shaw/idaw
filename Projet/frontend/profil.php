<h1>Connexion</h1>
<div id="userDetails"></div>

<div id="userInfo">
    <?php
    if (isset($_SESSION['identifiant'])) {
        echo "<p>Bienvenue, " . $_SESSION['identifiant'] . "!</p>";
        echo "<button id='logoutButton'>Déconnexion</button>";
    } else {
        echo "
        <form id='loginForm'>
            <label for='identifiant'>Identifiant :</label>
            <input type='text' id='identifiant' name='identifiant' required><br><br>
            
            <label for='mdp'>Mot de passe :</label>
            <input type='password' id='mdp' name='mdp' required><br><br>
            
            <button type='submit' id='submitLogin'>Se connecter</button>
        </form>
        <button id='createAccount'>Créer un compte</button>";
    }
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('logoutButton')) {
            document.getElementById('logoutButton').addEventListener('click', function() {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '../backend/logout.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Déconnexion réussie');
                        window.location.href = 'index.php';
                    } else {
                        console.error('Erreur lors de la déconnexion');
                    }
                };
            });
        }

        if (document.getElementById('submitLogin')) {
            document.getElementById('submitLogin').addEventListener('click', function(event) {
                event.preventDefault();
                const identifiant = document.getElementById('identifiant').value;
                const mdp = document.getElementById('mdp').value;

                const xhr = new XMLHttpRequest();
                xhr.open('GET', `http://localhost/IDAW/Projet/backend/utilisateur.php?check=true&identifiant=${identifiant}&mdp=${mdp}`);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log('Connexion réussie');
                        window.location.href = 'index.php';
                    } else {
                        console.error('Identifiants incorrects');
                    }
                };
            });
        }

        if (document.getElementById('createAccount')) {
            document.getElementById('createAccount').addEventListener('click', function() {
                window.location.href = 'index.php?page=addUtilisateur';
            });
        }
    });
</script>
