<?php
    session_start();
    echo"
        <!doctype html>
        <html>
            <head>
                <title>i Manger Mieux</title>
                
                <link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css\" />
                <script src=\"https://code.jquery.com/jquery-3.7.1.js\"></script>
                <script src=\"https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js\"></script>
                <script>
                    document.addEventListener(\"DOMContentLoaded\", function() {
                        const datatable = new DataTable('#table', {
                            ajax:\"/IDAW/TP4-API/exo5/users.php\",
                            pageLength:10,
                            lengthMenu:[[10,20,50],['Dix','Vingt','Cinquante']],
                            processing:true,
                            serverSide:false,
                            serverMethod:\"get\",

                            columns:[
                                {
                                    data: \"id\",
                                },
                                {
                                    data: \"nom\",
                                },
                                {
                                    data: \"email\",
                                },
                            ]
                        });
                    });
                </script>
                
                <link rel=\"stylesheet\" href=\"
    ";

    if(isset($_GET['css'])) {setcookie('css', $_GET['css']); echo "css/".$_GET['css'].".css";}
    elseif(isset($_COOKIE['css'])) echo "css/".$_COOKIE['css'].".css";
    else echo "css/style1.css";
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
                'profil' => 'Profil',
                'aliments' => 'Aliments',
                'journal' => 'Journal',
            );
            $oppLanguage = 'en';
        }else{
            $mymenu = array(
                'accueil' => 'Accueil',
                'profil' => 'Profil',
                'aliments' => 'Aliments',
                'journal' => 'Journal',
            );
            $oppLanguage = 'fr';
        }
        
        $picPath = array(
            'accueil' => 'logo.png',
            'profil' => 'photo.jpg',
            'aliments' => 'panier.png',
            'journal' => 'journal.png',
        );

        $titre = $mymenu[$currentPageId];
        $imagePath = $picPath[$currentPageId];

        echo "
        <header>
            <a style=\"padding-left:60px;\" href=\"index.php?page=accueil&lang=$currentLanguage\"> <img src=\"imgs/{$imagePath}\" width=\"125px\"/> </a>
            <div class=\"titre\">{$titre}</div>
            <a href=\"index.php?page={$currentPageId}&lang=$oppLanguage\"> <img src=\"imgs/pumkin.png\" width=\"150px\"/> </a>
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
