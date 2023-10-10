<?php require_once('templates/template-header.php');?>
        <header>
            <div class="titre">Mon CV</div>
            <img class="smallpic" src="images/photo.jpg" alt="Raisin :D"/>
        </header>

        <div class = flexrow>
            <?php 
                require_once('templates/template-nav_menu.php');
                renderMenuToHTML('cv');
            ?>

            
            <div class="contenu">
                <h1> Présetation de mon curriculum vitae</h1>
                <p>Je suis un professionnel dédié et passionné, doté d'une solide expérience dans le domaine de la gestion de projets. Fort de plus de 10 ans d'expérience, j'ai acquis une expertise approfondie dans la planification, la gestion et l'exécution de projets complexes. Mon parcours professionnel m'a permis de travailler au sein de diverses organisations, des startups aux grandes entreprises, où j'ai pu développer ma polyvalence et ma capacité à m'adapter à des environnements en évolution constante.</p>
                <p>Ma passion pour l'innovation technologique m'a toujours poussé à rechercher des solutions novatrices et à approcher chaque projet avec créativité. Mon expérience m'a également permis de développer des compétences solides en gestion d'équipe, en communication interfonctionnelle et en leadership.</p>
                <p>Je suis reconnu pour ma capacité à résoudre des problèmes complexes et à prendre des décisions éclairées grâce à une approche analytique. Mon engagement envers l'apprentissage continu m'a conduit à rester à jour avec les dernières tendances et technologies de l'industrie, ce qui me permet de fournir des résultats de haute qualité.</p>
                <p>En tant qu'homme professionnel, je m'efforce constamment d'atteindre l'excellence dans tout ce que j'entreprends. Je suis enthousiaste à l'idée de relever de nouveaux défis, de collaborer avec des équipes talentueuses et de contribuer au succès de mon employeur. Ma passion pour l'innovation, mon dévouement envers l'excellence et ma capacité à m'adapter font de moi un atout précieux pour toute organisation en quête de croissance et de réussite.</p>
            </div>

        </div>




<?php require_once('templates/template-footer.php');?>