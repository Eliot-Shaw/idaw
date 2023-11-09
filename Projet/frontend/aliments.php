<button onclick="window.location.href = 'index.php?page=addAliment';">Ajouter un aliment</button>
<br>
<br>

<script>
    var base_url = "<?php echo _BASE_URL; ?>";

    $(document).ready(function () {
        $('#alimentsTable').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": base_url + "backend/aliment.php?aliment=all",
                "dataSrc": ""
            },
            "columns": [
                { "data": "nom_aliment" },
                { "data": "nom_categorie" },
                {
                    "data": "id_aliment",
                    "render": function (data, type, row) {
                        return '<button onclick="deleteAliment(' + row.id_aliment + ')">Supprimer</button>' +
                            '<button onclick=\"window.location.href = \'index.php?page=addAliment&id_aliment=' + row.id_aliment + '\';\">Editer</button>';
                    }
                },
            ]
        });
    });

    // La fonction deleteAliment reste inchangée
    function deleteAliment(id) {
        fetch(base_url + "backend/aliment.php?aliment=" + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_aliment: id }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la suppression de l\'aliment');
                }
                return response.json();
            })
            .then(data => {
                $('#alimentsTable').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'aliment :', error);
            });
    }
</script>

<table id="alimentsTable" class="display">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Categorie</th>
            <th>Action</th>
        </tr>
    </thead>
</table>