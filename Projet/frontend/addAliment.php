<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un aliment</title>
</head>
<body>
    <h1>Ajouter un aliment</h1>
    
    <form id="addAlimentForm">
        <label for="nom_aliment">Nom de l'aliment :</label>
        <input type="text" id="nom_aliment" name="nom_aliment" required>
        
        <label for="nom_categorie">Nom de la catégorie :</label>
        <input type="text" id="nom_categorie" name="nom_categorie" required>
        
        <h2>Composition nutritionnelle</h2>
        <div id="compositionNutritionnelle">
            <button type="button" id="ajouterComposition">Ajouter une composition</button>
            <!-- Champs pour la composition nutritionnelle -->
            <div class="composition">
                <input type="text" class="nomComposition" placeholder="Nom de la composition">
                <input type="text" class="valeurComposition" placeholder="Valeur de la composition">
            </div>
            <!-- Bouton pour ajouter une nouvelle composition -->
        </div>
        
        <button type="button" id="submitAliment">Ajouter</button>
    </form>

    <script>
        document.getElementById('ajouterComposition').addEventListener('click', function() {
            var div = document.getElementById('compositionNutritionnelle');
            var newComposition = document.createElement('div');
            newComposition.className = 'composition';
            newComposition.innerHTML = `
                <input type="text" class="nomComposition" placeholder="Nom de la composition">
                <input type="text" class="valeurComposition" placeholder="Valeur de la composition">
            `;
            div.appendChild(newComposition);
        });

        document.getElementById('submitAliment').addEventListener('click', function() {
            var nomAliment = document.getElementById('nom_aliment').value;
            var nomCategorie = document.getElementById('nom_categorie').value;

            // Envoi du nom de l'aliment à la table "aliments"
            var xhrAliment = new XMLHttpRequest();
            xhrAliment.open('POST', 'addAliment.php');
            xhrAliment.setRequestHeader('Content-Type', 'application/json');
            xhrAliment.send(JSON.stringify({ "nom_aliment": nomAliment }));

            xhrAliment.onload = function() {
                if (xhrAliment.status === 200) {
                    var idAliment = JSON.parse(xhrAliment.responseText).id_aliment;

                    // Envoi de l'id de l'aliment et de la catégorie à la table "aliment_categories"
                    var xhrAlimentCategorie = new XMLHttpRequest();
                    xhrAlimentCategorie.open('POST', 'categorie.php');
                    xhrAlimentCategorie.setRequestHeader('Content-Type', 'application/json');
                    xhrAlimentCategorie.send(JSON.stringify({ "id_aliment": idAliment, "id_categorie": nomCategorie }));

                    var compositions = document.querySelectorAll('.composition');
                    compositions.forEach(function(composition) {
                        var nomComposition = composition.querySelector('.nomComposition').value;
                        var valeurComposition = composition.querySelector('.valeurComposition').value;

                        // Envoi de chaque composition à la table "composition_nutritionnelle"
                        var xhrComposition = new XMLHttpRequest();
                        xhrComposition.open('POST', 'addComposition.php');
                        xhrComposition.setRequestHeader('Content-Type', 'application/json');
                        xhrComposition.send(JSON.stringify({ "id_aliment": idAliment, "nom_composition": nomComposition, "quantite_composition": valeurComposition }));
                    });
                } else {
                    console.error('Erreur lors de l\'ajout de l\'aliment');
                }
            };
        });
    </script>
</body>
</html>
