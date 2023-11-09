<button onclick="window.location.href = 'index.php?page=addRepas';">Ajouter un repas</button>
<br>
<br>

<form id="dateRangeForm">
    <label for="start_date">Date de début :</label>
    <input type="date" id="start_date" name="start_date">
    <label for="end_date">Date de fin :</label>
    <input type="date" id="end_date" name="end_date">
    <button type="submit" id="searchByDate">Rechercher</button>
</form>

<table id="repasTable" class="display">
    <thead>
        <tr>
            <th>Date du repas</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div id="loginMessage">
    <h1>Vous devez vous connecter pour accéder à cette page.</h1>
    <p><button onclick="window.location.href = 'index.php?page=profil';">Se connecter</button></p>
</div>

<script>
    var base_url = "<?php echo _BASE_URL; ?>";

    $(document).ready(function () {
        $('#dateRangeForm').on('submit', function (e) {
            e.preventDefault();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date && end_date && start_date <= end_date) {
                fetchRepasData(start_date, end_date);
            } else {
                fetchRepasData(); // Afficher un tableau vide
                console.log("Dates de recherche non valides");
                alert("Dates de recherche non valides");
            }
        });
    });

    function fetchRepasData(start_date = '', end_date = '') {
        fetch(base_url + "backend/repas.php?id_repas=all&start_date=" + start_date + "&end_date=" + end_date)
            .then(response => {
                if (response.ok) {
                    response.json().then(data => {
                        initializeDataTable(data);
                        hideLoginMessage(); // Masquer le message de connexion si tout est bon
                    });
                } else if (response.status === 403) {
                    console.error('Accès interdit (403) : Utilisateur non connecté');
                    alert('Accès interdit : Veuillez vous connecter.');
                    displayLoginMessage(); // Afficher le message de connexion
                } else {
                    console.error('Erreur inattendue : ', response.status);
                    displayLoginMessage(); // Afficher le message de connexion
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données :', error);
                displayLoginMessage(); // Afficher le message de connexion
            });
    }

    function displayLoginMessage() {
        document.getElementById('loginMessage').style.display = 'block';
    }

    function hideLoginMessage() {
        document.getElementById('loginMessage').style.display = 'none';
    }

    function initializeDataTable(data) {
        if (data) {
            $('#repasTable').DataTable({
                destroy: true, // Pour rafraîchir les données
                "processing": true,
                "serverSide": false,
                "data": data, // Utilisation des données reçues
                "columns": [
                    { "data": "date_mange" },
                    {
                        "data": "id_repas",
                        "render": function (data, type, row) {
                            return '<button onclick="deleteRepas(' + row.id_repas + ')">Supprimer</button>' +
                                '<button onclick=\"window.location.href = \'index.php?page=addRepas&id_repas=' + row.id_repas + '\';\">Editer</button>';
                        }
                    },
                ]
            });
        } else {
            $('#repasTable').DataTable().clear().draw(); // Effacer la table existante
        }
    }

    function deleteRepas(id) {
        fetch(base_url + "backend/repas.php?id_repas=" + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_repas: id }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la suppression du repas');
                }
                return response.json();
            })
            .then(data => {
                $('#repasTable').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error('Erreur lors de la suppression du repas :', error);
            });
    }
</script>
