
    <h1>Ajouter/Éditer un Repas</h1>
    
    <form id="addRepasForm">
        <label for="dateRepas">Date du Repas :</label>
        <input type="date" id="dateRepas" name="dateRepas" required>
        
        <h2>Composition du Repas</h2>
        <div id="compositionRepas">
            <!-- Bouton pour ajouter un nouvel aliment -->
            <button type="button" id="ajouterAliment">Ajouter un aliment</button>
            <!-- Champs pour la composition du repas -->
            <div class="alimentEntry">
                <label for="aliment">Aliment :</label>
                <input type="text" class="aliment" placeholder="Nom de l'aliment"required>
                <label for="quantite">Quantité :</label>
                <input type="text" class="quantite" placeholder="Quantité de l'aliment"required>
            </div>
        </div>
        
        <button type="submit" id="submitRepas">Enregistrer le Repas</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_repas = urlParams.get('id_repas');

            if (id_repas) {
                // Si l'ID du repas est présent dans l'URL, c'est une édition, on peut charger les détails du repas

                // Faire une requête pour obtenir les détails du repas avec l'ID spécifié

                // Pré-remplir les champs du formulaire avec les détails du repas
            }

            document.getElementById('ajouterAliment').addEventListener('click', function() {
                var div = document.getElementById('compositionRepas');
                var newAlimentEntry = document.createElement('div');
                newAlimentEntry.className = 'alimentEntry';
                newAlimentEntry.innerHTML = `
                    <label for="aliment">Aliment :</label>
                    <input type="text" class="aliment" placeholder="Nom de l'aliment">
                    <label for="quantite">Quantité :</label>
                    <input type="text" class="quantite" placeholder="Quantité de l'aliment">
                `;
                div.appendChild(newAlimentEntry);
            });

            document.getElementById('addRepasForm').addEventListener('submit', function(event) {
                event.preventDefault();
                console.log("cc maman");
                // Récupérer les valeurs du formulaire pour l'enregistrement du repas
                
                // Faire une requête pour enregistrer le repas et sa composition (POST ou PUT selon le cas)
                
                // Rediriger ou effectuer une autre action après l'enregistrement du repas
            });
        });
    </script>