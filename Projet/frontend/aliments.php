<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const datatable = new DataTable('#table', {
                ajax:"/IDAW/TP4-API/exo5/users.php",
                pageLength:10,
                lengthMenu:[[10,20,50],['Dix','Vingt','Cinquante']],
                processing:true,
                serverSide:false,
                serverMethod:"get",

                columns:[
                    {
                        data: "id",
                    },
                    {
                        data: "nom",
                    },
                    {
                        data: "email",
                    },
                ]
            });
        });
    </script>
</head>
<body>
        aliments page affichant les aliments de la base avec la possibilité d’en ajouter, d’en supprimer,
    de les modifier, ... Attention, comme il est possible d’avoir un grand nombre d’aliments en
    base, il est important de prévoir une pagination.

<br>
<br>
<br>
    <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Énergie</th>
                    <th scope="col">Matières grasses</th>
                    <th scope="col">Acides gras saturés</th>
                    <th scope="col">CRUD</th>
                </tr>
            </thead>
            <tbody id="alimentTableBody">
            </tbody>
        </table>
        
        <form id="addAlimentForm" action="" onsubmit="onFormSubmit();">
            <div class="form-group row">
                <label for="inputNom" class="col-sm-2 col-form-label" required>Nom*</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="inputNom">
                </div>
                <div class="col-sm-3">
                    <p id="inputNomRequis"></p>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPrenom" class="col-sm-2 col-form-label">Prénom</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="inputPrenom">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDdn" class="col-sm-2 col-form-label">Date de naissance</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="inputDdn">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputAdore" class="col-sm-2 col-form-label">Adore le cours</label>
                <div class="col-sm-3">
                    <input type="checkbox" id="inputAdore">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputRemarque" class="col-sm-2 col-form-label">Remarque</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="inputRemarque">
                </div>
            </div>

            <div class="form-group row">
                <span class="col-sm-2"></span>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary form-control">valider</button>
                </div>
            </div>
        </form>


        <script>
            function onFormSubmit() {
                // prevent the form to be sent to the server
                event.preventDefault();
                let nom = $("#inputNom").val();

                if (nom === "") {
                    $("#inputNomRequis").html("Champ requis");
                }else {
                    let prenom = $("#inputPrenom").val();
                    let ddn = $("#inputDdn").val().toString();
                    let adore = $("#inputAdore").prop("checked") ? "Oui" : "Non";
                    let remarque = $("#inputRemarque").val();
                    $("#inputNomRequis").html("");

                    $("#alimentTableBody").append(`<tr id="${nom}"><td>${nom}</td><td>${prenom}</td><td>${ddn}</td><td>${adore}</td><td>${remarque}</td>
                    <td><input type="submit" id="${nom}edit" value="Edit"><input type="submit" id="${nom}delete" value="Delete"></td></tr>`);
                    
                    
                    const editButton = document.getElementById(nom+"edit");
                    editButton.addEventListener("click", function(event){
                        choix = this.getAttribute("value");
                        // mettre les valeurs dans le form
                        $("#inputNom").val(nom);
                        $("#inputPrenom").val(prenom);
                        $("#inputDdn").val(ddn);
                        $("#inputAdore").prop("checked")
                        $("#inputRemarque").val(remarque);

                        $("#alimentTableBody").children("#"+nom).remove();
                    })

                    const deleteButton = document.getElementById(nom+"delete");
                    deleteButton.addEventListener("click", function(event){
                        choix = this.getAttribute("value");
                        $("#alimentTableBody").children("#"+nom).remove();
                    })
                }
            }
        </script>
    </body>
</html>


