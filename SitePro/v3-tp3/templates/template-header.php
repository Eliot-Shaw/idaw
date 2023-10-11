<?php
    echo"
        <!doctype html>
        <html>
            <head>
                <title>My Haloween Blog</title>
                <link rel=\"stylesheet\" href=\"
    ";

    cssCookieLive();

    if(isset($_GET['css'])) echo "styles/".$_GET['css'].".css";
    elseif(isset($_COOKIE['css'])) echo "styles/".$_COOKIE['css'].".css";
    else echo "styles/style1.css";
    echo "
    \" type=\"text/css\"
        media=\"screen\" title=\"default\" charset=\"utf-8\" />
    </head>
    <body>
    ";
?>

<?php
    function renderHeaderToHTML($currentPageId, $currentLanguage) {
        if($currentLanguage == 'fr'){
            $mymenu = array(
                'accueil' => 'Accueil',
                'cv' => 'Curriculum Vitae',
                'hobbies' => 'Mes hobbies',
                'info-techniques' => 'Informations techniques',
                'contact' => 'Me contacter',
                'login' => 'Se connecter',
            );
            $oppLanguage = 'en';
        }else{
            $mymenu = array(
                'accueil' => 'Home page',
                'cv' => 'Resume',
                'hobbies' => 'My hobbies',
                'info-techniques' => 'Technical informations',
                'contact' => 'Contact me plz',
                'login' => 'Connect',
            );
            $oppLanguage = 'fr';
        }
        
        $picPath = array(
            'accueil' => 'arcenciel.jpg',
            'cv' => 'photo.jpg',
            'hobbies' => 'cat1.png',
            'info-techniques' => 'vacuum.png',
            'contact' => 'contact.jpg',
            'login' => 'contact.jpg',
            // TODO : AMODIF
        );

        $titre = $mymenu[$currentPageId];
        $imagePath = $picPath[$currentPageId];

        echo "
        <header>
            <a href=\"index.php?page={$currentPageId}&lang=$oppLanguage\"> <img src=\"images/pumkin.png\" width=\"150px\"/> </a>
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

    
<?php
    function cssCookieLive(){
        if(isset($_GET['css'])) setcookie('css', $_GET['css']);
    }
?>