<!doctype html>
<html>
    <head>
        <title>xX_SUPER-SITE-INTERNET_Xx</title>
        <link rel="stylesheet" href="styles/style1.css" type="text/css"
        media="screen" title="default" charset="utf-8" />
    </head>
    <body>

<?php
    function renderHeaderToHTML($currentPageId, $currentLanguage) {
        if($currentLanguage == 'fr'){
            $mymenu = array(
                'accueil' => 'Accueil',
                'cv' => 'Curriculum Vitae',
                'hobbies' => 'Mes hobbies',
                'info-techniques' => 'Informations techniques',
                'contact' => 'Me contacter',
            );
        }else{
            $mymenu = array(
                'accueil' => 'Home page',
                'cv' => 'Resume',
                'hobbies' => 'My hobbies',
                'info-techniques' => 'Technical informations',
                'contact' => 'Contact me plz',
            );
        }
        
        $picPath = array(
            'accueil' => 'arcenciel.jpg',
            'cv' => 'photo.jpg',
            'hobbies' => 'cat1.png',
            'info-techniques' => 'vacuum.png',
            'contact' => 'contact.jpg',
        );

        $titre = $mymenu[$currentPageId];
        $imagePath = $picPath[$currentPageId];

        echo "
        <header>
            <div class=\"languages\">
                <img src=\"images/pumkin.png\" width=\"150px\"/>
                <div>
                    <a href=\"index.php?page={$currentPageId}&lang=fr\"> <button class=\"frenchFlag\"></button> </a>
                    <br>
                    <a href=\"index.php?page={$currentPageId}&lang=en\"> <button class=\"englishFlag\"></button> </a>
                </div>
            </div>
            <div class=\"titre\">{$titre}</div>
            <img class=\"smallpic\" src=\"images/{$imagePath}\" alt=\"Raisin :D\"/>
        </header>
        
        <div class = \"preflexrow\">
            <div class = \"flexrow\">
        ";
        
        require_once('templates/template-nav_menu.php');
        foreach($mymenu as $pageId => $elementMenu) {
            $isCurrent = false;
            if($currentPageId == $pageId){$isCurrent = true;}
            renderMenuToHTML($pageId, $elementMenu, $isCurrent, $currentLanguage);
        }
        echo "</div><div class=\"contenu\">";
    }
?>                

    
    