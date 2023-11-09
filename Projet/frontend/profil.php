<!DOCTYPE html>
<html>
<head>
    <title>Page de Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <form id="loginForm">
        <label for="identifiant">Identifiant :</label>
        <input type="text" id="identifiant" name="identifiant" required><br><br>
        
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required><br><br>
        
        <button type="submit" id="submitLogin">Se connecter</button>
    </form>

    <button id="createAccount">Créer un compte</button>

    <script>
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
                    // Redirection vers une nouvelle page ou traitement supplémentaire ici
                } else {
                    console.error('Identifiants incorrects');
                }
            };
        });

        document.getElementById('createAccount').addEventListener('click', function() {
            window.location.href = 'index.php?page=addUtilisateur';
        });
    </script>
</body>
</html>
