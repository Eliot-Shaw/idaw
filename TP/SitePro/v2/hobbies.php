<?php require_once('templates/template-header.php');?>
    <header>
        <div class="titre">Mes hobbies</div>
        <img class="smallpic" src="images/cat1.png " alt="Raisin :D"/>
    </header>
        <!-- faaire un header conditionné pour le titre et l'image mappé -->

    
    <div class = flexrow>
        <?php 
            require_once('templates/template-nav_menu.php');
            renderMenuToHTML('hobbies');
        ?>
        
        <div class="contenu">
            <h1>IT'S SPOOKY MONTH !!!!</h1>
            <div style="display: flex;">
                <pre>



                    
                    .-.                         
                   (o.o)
                    |=|
                   __|__
                 //.=|=.\\
                // .=|=. \\
                \\ .=|=. //
                 \\(_=_)//
                  (:| |:)
                   || ||
                   () ()
                   || ||
                   || ||
                 ==' '==
                </pre>
                <img class="mediumpic" src="images/ghost_retourne.png " alt="Raisin :D"/>
            </div>
        </div>

<?php require_once('templates/template-footer.php');?>


