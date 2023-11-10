<!DOCTYPE html>
<html>
<head>
    <title>Page d'Accueil</title>
    <style>
        #userDetails {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur notre site</h1>
    <div id="userDetails"></div>
    <label for="selectDays">Sélectionnez la durée :</label>
    <select id="selectDays">
        <option value="1">1 jour</option>
        <option value="7">7 jours</option>
        <option value="15">15 jours</option>
        <option value="30">30 jours</option>
        <option value="99999">Tou jours</option>
    </select>
    <div id="nutritionDetails"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Appeler la fonction pour récupérer les données avec le jour 1 par défaut
            fetchData(1);

            const selectDays = document.getElementById('selectDays');
            
            selectDays.addEventListener('change', function() {
                // Appeler la fonction pour récupérer les données avec le jour sélectionné
                fetchData(this.value);
            });
        });

        function fetchData(selectedDays) {
            // Calcul des dates de début et de fin en fonction de la sélection
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - selectedDays + 1);

            // Formatage des dates pour les inclure dans la requête
            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);

            // Faites une requête AJAX pour récupérer les données utilisateur et les valeurs nutritionnelles
            var id_utilisateur = <?php echo json_encode($_SESSION['id_utilisateur']); ?>;
            const apiUrl = `http://localhost/IDAW/Projet/backend/utilisateur.php?id_utilisateur=${id_utilisateur}&date_debut=${formattedStartDate}&date_fin=${formattedEndDate}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    const userDetailsDiv = document.getElementById('userDetails');
                    userDetailsDiv.innerHTML = `
                        <h2>Bonjour, ${data.details_utilisateur.prenom} ${data.details_utilisateur.nom_de_famille} !</h2>
                        <p>Energie requise (kcal): ${data.details_utilisateur.metabolisme * selectedDays/1000}</p>
                    `;

                    const nutritionDetailsDiv = document.getElementById('nutritionDetails');
                    nutritionDetailsDiv.innerHTML = '<h3>Valeurs Nutritionnelles</h3>';

                    if (data.valeurs_nutritionnelles_totales && data.valeurs_nutritionnelles_totales.length > 0) {
                        const energyValue = data.valeurs_nutritionnelles_totales[0]['Énergie'];
                        const metabolicCoefficient = calculateMetabolicCoefficient(data.details_utilisateur.metabolisme, selectedDays, energyValue);
                        const gradientColor = getGradientColor(metabolicCoefficient);

                        userDetailsDiv.style.background = gradientColor;

                        data.valeurs_nutritionnelles_totales.forEach(item => {
                            const nutrientName = Object.keys(item)[0];
                            const nutrientValue = item[nutrientName];
                            nutritionDetailsDiv.innerHTML += `
                                <li>${nutrientName}: ${nutrientValue}</li>
                            `;
                        });

                        nutritionDetailsDiv.innerHTML += '</ul>';

                        // Afficher le message en fonction du coefficient métabolique
                        const message = getMessageFromCoefficient(metabolicCoefficient);
                        userDetailsDiv.innerHTML += `<p>${message}</p>`;
                    } else {
                        nutritionDetailsDiv.innerHTML += '<p>Pas de données nutritionnelles disponibles.</p>';
                    }
                })
                .catch(error => {
                    console.error('Une erreur s\'est produite lors de la récupération des données :', error);
                });
        }

        // Fonction pour formater la date au format "YYYY-MM-DD"
        function formatDate(date) {
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Fonction pour calculer le coefficient métabolique
        function calculateMetabolicCoefficient(metabolism, days, energy) {
            return energy / (metabolism * days);
        }

        // Fonction pour obtenir une couleur de dégradé en fonction du coefficient métabolique
        function getGradientColor(coefficient) {
            // Utilisez ici votre propre logique pour déterminer la couleur en fonction de la proximité de la valeur à 1
            // C'est juste un exemple basé sur la distance à 1.
            const distanceTo1 = Math.abs(1 - coefficient);
            const color = distanceTo1 < 0.1 ? 'green' : distanceTo1 < 0.3 ? 'orange' : 'red';
            return color;
        }

        // Fonction pour obtenir le message en fonction du coefficient métabolique
        function getMessageFromCoefficient(coefficient) {
            const tolerance = 0.15; // 15%

            if (coefficient < 1 - tolerance) {
                return "Mangez plus pour atteindre vos besoins énergétiques";
            } else if (coefficient > 1 + tolerance) {
                return "Réduisez votre consommation pour atteindre vos besoins énergétiques";
            } else {
                return "Vous atteignez vos besoins énergétiques. Bien joué !";
            }
        }
    </script>
</body>
</html>