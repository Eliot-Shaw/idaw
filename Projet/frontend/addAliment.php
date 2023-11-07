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
                <input type="text" class="id_val_nutritionnelle" placeholder="Nom de la composition">
                <input type="text" class="quantiteComposition" placeholder="Quantité de la composition">
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
                <input type="text" class="id_val_nutritionnelle" placeholder="Nom de la composition">
                <input type="text" class="quantiteComposition" placeholder="Quantité de la composition">
            `;
            div.appendChild(newComposition);
        });

        document.getElementById('submitAliment').addEventListener('click', function() {
            var nomAliment = document.getElementById('nom_aliment').value;
            var nomCategorie = document.getElementById('nom_categorie').value;

            // Effectuer une requête pour ajouter l'aliment
            var xhrAliment = new XMLHttpRequest();
            xhrAliment.open('POST', '../backend/aliment.php');
            xhrAliment.setRequestHeader('Content-Type', 'application/json');
            xhrAliment.send(JSON.stringify({ "nom_aliment": nomAliment }));

            xhrAliment.onload = function() {
                if (xhrAliment.status === 201) {
                    var idAliment = JSON.parse(xhrAliment.responseText).id_aliment;

                    var compositions = document.querySelectorAll('.composition');
                    compositions.forEach(function(composition) {
                        var id_val_nutritionnelle = composition.querySelector('.id_val_nutritionnelle').value;
                        var quantiteComposition = composition.querySelector('.quantiteComposition').value;

                        var xhrAlimentCategorie = new XMLHttpRequest();
                        xhrAlimentCategorie.open('POST', '../backend/aliment_categorie.php');
                        xhrAlimentCategorie.setRequestHeader('Content-Type', 'application/json');
                        xhrAlimentCategorie.send(JSON.stringify({ "id_aliment": idAliment, "id_categorie": nomCategorie }));

                        // Effectuer une requête pour ajouter chaque composition nutritionnelle
                        var xhrComposition = new XMLHttpRequest();
                        xhrComposition.open('POST', '../backend/composition_val_nutritionnelles.php');
                        xhrComposition.setRequestHeader('Content-Type', 'application/json');
                        xhrComposition.send(JSON.stringify({
                            "id_aliment": idAliment,
                            "id_val_nutritionnelle": id_val_nutritionnelle,
                            "quantite_composition": quantiteComposition
                        }));
                        
                    });
                } else {
                    console.error('Erreur lors de l\'ajout de l\'aliment');
                }
            };
        });

    </script>
</body>
</html>
