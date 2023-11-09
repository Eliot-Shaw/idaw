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

<script>
    var id_utilisateur = <?php echo json_encode($_SESSION['id_utilisateur']); ?>;

    var base_url = "<?php echo _BASE_URL; ?>";

    $(document).ready(function () {
        fetchRepasData(); // Charge les repas initiaux sans contrainte de date

        $('#dateRangeForm').on('submit', function (e) {
            e.preventDefault();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            fetchRepasData(start_date, end_date);
        });
    });

    function fetchRepasData(start_date = '', end_date = '') {

        $('#repasTable').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": base_url + "backend/repas.php?id_repas=all&start_date=" + start_date + "&end_date=" + end_date + "&id_utilisateur=" + id_utilisateur,
                "dataSrc": ""
                },
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
    }

    // La fonction deleteRepas est similaire à deleteAliment
    function deleteRepas(id) {
        fetch(base_url + "backend/repas.php?id_repas=" + id + "&id_utilisateur=" + id_utilisateur, {
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