<?php 
    require_once("templates/template-header.php");
    $currentPageId = 'accueil';
    if(isset($_GET['page'])) {$currentPageId = $_GET['page'];}
    $currentLanguage = 'fr';
    if(isset($_GET['lang'])) {$currentLanguage = $_GET['lang'];}
?>



<?php 
    renderHeaderToHTML($currentPageId, $currentLanguage);
?>

    <form id="style_form" action="index.php" method="GET">
        <select name="css">
            <option value="style1">style1</option>
            <option value="style2">style2</option>
        </select>
        <input type="submit" value="Appliquer"/>
    </form>

<section class="corps">
    <?php
        if($currentLanguage == 'fr'){
            $pageToInclude = $currentPageId . ".php";
            if(is_readable("pages/fr/" .$pageToInclude)) require_once("pages/fr/" .$pageToInclude);
            else require_once("error.php");
        }else{
            $pageToInclude = $currentPageId . ".php";
            if(is_readable("pages/en/" .$pageToInclude)) require_once("pages/en/" .$pageToInclude);
            else require_once("error.php");    
        }
        
    ?>
</section>

<?php require_once("templates/template-footer.php");?>