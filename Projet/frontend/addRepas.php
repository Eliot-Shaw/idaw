
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
            <input type="text" class="aliment" placeholder="Nom de l'aliment">
            <label for="quantite">Quantité :</label>
            <input type="text" class="quantite" placeholder="Quantité de l'aliment">
        </div>
    </div>
    
    <button type="submit" id="submitRepas">Enregistrer le Repas</button>
</form>

<script>
    var id_utilisateur = <?php echo json_encode($_SESSION['id_utilisateur']); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id_repas = urlParams.get('id_repas');

        if (id_repas) {
            // Si l'ID du repas est présent dans l'URL, c'est une édition, on peut charger les détails du repas

            // Faire une requête pour obtenir les détails du repas avec l'ID spécifié
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../backend/repas.php?id_repas=' + id_repas);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send();

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const repas = JSON.parse(xhr.responseText);

                    // Pré-remplir les champs du formulaire avec les détails du repas
                    document.getElementById('dateRepas').value = repas.date_mange;

                    // Pré-remplir les champs pour la composition du repas
                    repas.composition.forEach(function(aliment) {
                        var div = document.getElementById('compositionRepas');
                        var newAlimentEntry = document.createElement('div');
                        newAlimentEntry.className = 'alimentEntry';
                        newAlimentEntry.innerHTML = `
                            <label for="aliment">Aliment :</label>
                            <input type="text" class="aliment" placeholder="Nom de l'aliment" value="${aliment.nom_aliment}">
                            <label for="quantite">Quantité :</label>
                            <input type="text" class="quantite" placeholder="Quantité de l'aliment" value="${aliment.quantite}">
                        `;
                        div.appendChild(newAlimentEntry);
                    });
                } else {
                    console.error('Erreur lors de la récupération des détails du repas');
                }
            };
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
            const urlParams = new URLSearchParams(window.location.search);
            const id_repas = urlParams.get('id_repas');

            const dateRepas = document.getElementById('dateRepas').value;

            const alimentEntries = document.querySelectorAll('.alimentEntry');
            const compositionRepas = [];
            alimentEntries.forEach(function(entry) {
                const nomAliment = entry.querySelector('.aliment').value;
                const quantite = entry.querySelector('.quantite').value;
                if (nomAliment.trim() !== '' && quantite.trim() !== '') {
                    compositionRepas.push({ nomAliment, quantite });
                }
            });

            if (compositionRepas.length > 0) {
                if (id_repas) {
                    // C'est une édition de repas
                    // Faire une requête pour mettre à jour le repas et sa composition
                    var xhr = new XMLHttpRequest();
                    xhr.open('PUT', '../backend/repas.php?id_repas=' + id_repas);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.send(JSON.stringify({ dateRepas, compositionRepas }));

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Gérer la réussite de la modification du repas
                            console.log('Le repas a été modifié avec succès');
                            window.location.href = 'index.php?page=journal';
                        } else {
                            console.error('Erreur lors de la modification du repas');
                        }
                    };
                } else {
                    // C'est un nouvel ajout de repas
                    // Faire une requête pour enregistrer le repas et sa composition
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../backend/repas.php');
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.send(JSON.stringify({ id_utilisateur,  dateRepas, compositionRepas }));

                    xhr.onload = function() {
                        if (xhr.status === 201) {
                            // Gérer la réussite de l'ajout du repas
                            console.log('Le repas a été ajouté avec succès');
                            window.location.href = 'index.php?page=journal';
                        } else {
                            console.error('Erreur lors de l\'ajout du repas');
                        }
                    };
                }
            } else {
                console.error('Veuillez saisir au moins un aliment pour le repas');
            }
        });
    });
</script>