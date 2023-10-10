<div class="menu menuNavigation" style="border: 3px solid rgba(0, 0, 0, 0.2);">
    <div class="titreMenu">Menu</div>
    <hr class="darker tres">
    <!-- creer plus des boites sur le menu qu'un texte -->

<?php
    function renderMenuToHTML($currentPageId) {
        // un tableau qui d\'efinit la structure du site
        $mymenu = array(
            // idPage titre
            'index' => 'Accueil',
            'cv' => 'Cv',
            'hobbies' => 'Mes hobbies',
            'info-techniques' => 'Informations techniques',
        );

        foreach($mymenu as $pageId => $pageParameters) {
            echo "<div class=\"elementMenu\"";
            if($currentPageId == $pageId){echo"id=\"currentpage\"";}
            echo"
                ><a href=\"{$pageId}.php\">{$pageParameters}</a></div>
                <hr class=\"darker dos\">
            ";
        }
        echo"</div>";
    }
?>                
