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

            var xhrAliment = new XMLHttpRequest();
            xhrAliment.open('POST', '../backend/aliment.php');
            xhrAliment.setRequestHeader('Content-Type', 'application/json');
            xhrAliment.send(JSON.stringify({ "nom_aliment": nomAliment }));

            xhrAliment.onload = function() {
                if (xhrAliment.status === 201) {
                    console.log('Aliment ajouté avec succès');
                    var idAliment = JSON.parse(xhrAliment.responseText).id_aliment;

                    var xhrAlimentCategorie = new XMLHttpRequest();
                    xhrAlimentCategorie.open('POST', '../backend/aliment_categorie.php');
                    xhrAlimentCategorie.setRequestHeader('Content-Type', 'application/json');
                    xhrAlimentCategorie.send(JSON.stringify({ "id_aliment": idAliment, "id_categorie": nomCategorie }));

                    xhrAlimentCategorie.onload = function() {
                        console.log('Réponse de la requête aliment_categorie : ', xhrAlimentCategorie.responseText);
                        if (xhrAlimentCategorie.status === 201) {
                            console.log('Liaison aliment-categorie ajoutée avec succès');
                        } else {
                            console.error('Erreur lors de l\'ajout de la liaison aliment-categorie');
                        }
                    };
                } else {
                    console.error('Erreur lors de l\'ajout de l\'aliment');
                }
            };
        });

    </script>
</body>
</html>