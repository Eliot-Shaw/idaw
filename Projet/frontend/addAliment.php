<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la BDD</title>
</head>
<body>
    <h1>Ajouter/Modifier un aliment</h1>
    
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
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_aliment = urlParams.get('id_aliment');

            if (id_aliment) {
                // Requête GET pour obtenir les détails de l'aliment avec l'ID spécifié
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '../backend/aliment.php?aliment=' + id_aliment);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const aliment = JSON.parse(xhr.responseText);

                        // Pré-remplir les champs du formulaire
                        document.getElementById('nom_aliment').value = aliment.nom_aliment;
                        document.getElementById('nom_categorie').value = aliment.nom_categorie;

                        // Boucle pour pré-remplir les champs de composition nutritionnelle
                        aliment.composition_nutritionnelle.forEach(function(composition) {
                            var div = document.getElementById('compositionNutritionnelle');
                            var newComposition = document.createElement('div');
                            newComposition.className = 'composition';
                            newComposition.innerHTML = `
                                <input type="text" class="id_val_nutritionnelle" placeholder="Nom de la composition" value="${composition.nom_composition}">
                                <input type="text" class="quantiteComposition" placeholder="Quantité de la composition" value="${composition.quantite_composition}">
                            `;
                            div.appendChild(newComposition);
                        });

                        // Modifier le bouton pour envoyer les données en tant que requête PUT
                        document.getElementById('submitAliment').textContent = 'Mettre à jour';
                        document.getElementById('submitAliment').addEventListener('click', function() {
                            var xhrPut = new XMLHttpRequest();
                            xhrPut.open('PUT', '../backend/aliment.php?aliment=' + id_aliment);
                            xhrPut.setRequestHeader('Content-Type', 'application/json');
                            xhrPut.send(JSON.stringify({ "id_aliment": id_aliment, "nom_aliment": document.getElementById('nom_aliment').value }));

                            var xhrAlimentCategorieDelete = new XMLHttpRequest();
                            xhrAlimentCategorieDelete.open('DELETE', '../backend/aliment_categorie.php');
                            xhrAlimentCategorieDelete.setRequestHeader('Content-Type', 'application/json');
                            xhrAlimentCategorieDelete.send(JSON.stringify({"id_aliment": id_aliment}));

                            xhrAlimentCategorieDelete.onload = function() {
                                var xhrCompositionDelete = new XMLHttpRequest();
                                xhrCompositionDelete.open('DELETE', '../backend/composition_val_nutritionnelles.php');
                                xhrCompositionDelete.setRequestHeader('Content-Type', 'application/json');
                                xhrCompositionDelete.send(JSON.stringify({"id_aliment": id_aliment}));

                                xhrCompositionDelete.onload = function() {
                                    var xhrAlimentCategorie = new XMLHttpRequest();
                                    xhrAlimentCategorie.open('POST', '../backend/aliment_categorie.php');
                                    xhrAlimentCategorie.setRequestHeader('Content-Type', 'application/json');
                                    xhrAlimentCategorie.send(JSON.stringify({ "id_aliment": id_aliment, "id_categorie": document.getElementById('nom_categorie').value }));
                            
                                    xhrAlimentCategorie.onload = function() {
                                        var compositions = document.querySelectorAll('.composition');
                                        compositions.forEach(function(composition) {
                                            var id_val_nutritionnelle = composition.querySelector('.id_val_nutritionnelle').value;
                                            var quantiteComposition = composition.querySelector('.quantiteComposition').value;
                                            if(!isNaN(id_val_nutritionnelle) && !isNaN(quantiteComposition)){// Effectuer une requête pour ajouter chaque composition nutritionnelle
                                                var xhrComposition = new XMLHttpRequest();
                                                xhrComposition.open('POST', '../backend/composition_val_nutritionnelles.php');
                                                xhrComposition.setRequestHeader('Content-Type', 'application/json');
                                                xhrComposition.send(JSON.stringify({
                                                    "id_aliment": id_aliment,
                                                    "id_val_nutritionnelle": id_val_nutritionnelle,
                                                    "quantite_composition": quantiteComposition
                                                }));
                                            }
                                        });
                                        console.log("fini le comp");
                                        window.location.href = 'index.php?page=aliments';
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('Erreur lors de la récupération des informations de l\'aliment');
                    }
                };
            } else{
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
                                xhrComposition.onload = function(){window.location.href = 'index.php?page=aliments';};
                            });
                        } else {
                            console.error('Erreur lors de l\'ajout de l\'aliment');
                        }
                    };
                });
            }

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

            
        });
    </script>
</body>
</html>
