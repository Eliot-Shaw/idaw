<!doctype html>
<html>
    <head>
        <title>xX_SUPER-SITE-INTERNET_Xx</title>
        <link rel="stylesheet" href="styles/style1.css" type="text/css"
        media="screen" title="default" charset="utf-8" />
    </head>
    <body>

<?php
    function renderHeaderToHTML($currentPageId) {
        // un tableau qui d\'efinit la structure du site
        $pageId = array(
            'accueil' => 'Accueil',
            'cv' => 'Cv',
            'hobbies' => 'Mes hobbies',
            'info-techniques' => 'Informations techniques',
        );

        $titre = $pageID['{$currentPageId}'];
        echo"
        <header>
            <div class=\"titre\">{$titre}</div>
            <img class=\"smallpic\" src=\"images/cat1.png\" alt=\"Raisin :D\"/>
        </header>
        
        <div class = flexrow>
        <?php 
            require_once('templates/template-nav_menu.php');
            renderMenuToHTML({$currentPageId});
        ?>
        
        <div class=\"contenu\">
        ";
    }
?>                


    
    