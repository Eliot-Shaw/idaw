<h1>Ajouter un utilisateur</h1>

<form id="addUserForm">
    <label for="identifiant">Identifiant :</label>
    <input type="text" id="identifiant" name="identifiant" required><br><br>
    
    <label for="mdp">Mot de passe :</label>
    <input type="password" id="mdp" name="mdp" required><br><br>
    
    <label for="nom_de_famille">Nom de famille :</label>
    <input type="text" id="nom_de_famille" name="nom_de_famille" required><br><br>
    
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required><br><br>
    
    <label for="genre">Genre :</label>
    <select id="genre" name="genre">
        <option value="autre">Autre</option>
        <option value="homme">Homme</option>
        <option value="femme">Femme</option>
    </select><br><br>
    
    <label for="age">Âge :</label>
    <input type="number" id="age" name="age" required><br><br>
    
    <label for="taille">Taille (en m) :</label>
    <input type="number" step="0.01" id="taille" name="taille" required><br><br>
    
    <label for="poids">Poids (en kg) :</label>
    <input type="number" step="0.01" id="poids" name="poids" required><br><br>
    
    <label for="id_niveau_sport">Niveau de sport pratiqué :</label>
    <select id="id_niveau_sport" name="id_niveau_sport">
        <option value="0">Nul</option>
        <option value="1">Faible</option>
        <option value="2">Moyen</option>
        <option value="3">Soutenu</option>
        <option value="4">Fort</option>
    </select><br><br>
    
    <button type="submit" id="submitUser">Enregistrer l'utilisateur</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id_utilisateur = urlParams.get('id_utilisateur');

        if (id_utilisateur) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../backend/utilisateur.php?id_utilisateur=' + id_utilisateur);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send();

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const utilisateur = JSON.parse(xhr.responseText).details_utilisateur;

                    document.getElementById('identifiant').value = utilisateur.identifiant;
                    document.getElementById('mdp').value = utilisateur.mdp;
                    document.getElementById('nom_de_famille').value = utilisateur.nom_de_famille;
                    document.getElementById('prenom').value = utilisateur.prenom;
                    document.getElementById('genre').value = utilisateur.genre;
                    document.getElementById('age').value = utilisateur.age;
                    document.getElementById('taille').value = utilisateur.taille;
                    document.getElementById('poids').value = utilisateur.poids;
                    document.getElementById('id_niveau_sport').value = utilisateur.id_niveau_sport;

                    // Mettre à jour le bouton pour l'édition
                    document.getElementById('submitUser').innerText = "Mettre à jour l'utilisateur";
                } else {
                    console.error('Erreur lors de la récupération des détails du utilisateur');
                }
            };
        }

        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const identifiant = document.getElementById('identifiant').value;
            const mdp = document.getElementById('mdp').value;
            const nom_de_famille = document.getElementById('nom_de_famille').value;
            const prenom = document.getElementById('prenom').value;
            const genre = document.getElementById('genre').value;
            const age = parseInt(document.getElementById('age').value);
            const taille = parseFloat(document.getElementById('taille').value);
            const poids = parseFloat(document.getElementById('poids').value);
            const id_niveau_sport = parseInt(document.getElementById('id_niveau_sport').value);

            const userData = {
                id_utilisateur,
                identifiant,
                mdp,
                nom_de_famille,
                prenom,
                genre,
                age,
                taille,
                poids,
                id_niveau_sport
            };

            const xhrButton = new XMLHttpRequest();

            if (id_utilisateur) {
                // S'il s'agit d'une édition, utiliser la méthode PUT pour mettre à jour l'utilisateur
                xhrButton.open('PUT', '../backend/utilisateur.php?id_utilisateur=' + id_utilisateur);
            } else {
                // S'il s'agit d'un ajout, utiliser la méthode POST pour créer un nouvel utilisateur
                xhrButton.open('POST', '../backend/utilisateur.php');
            }

            xhrButton.setRequestHeader('Content-Type', 'application/json');
            xhrButton.send(JSON.stringify(userData));

            console.log('userData');
            console.log(userData);
            console.log('xhrButton');
            console.log(xhrButton);

            xhrButton.onload = function() {
                if (xhrButton.status === 201 || xhrButton.status === 200) {
                    console.log('L\'utilisateur a été enregistré avec succès');
                } else {
                    console.error('Erreur lors de l\'enregistrement de l\'utilisateur');
                }
            };
        });
    });

</script>
