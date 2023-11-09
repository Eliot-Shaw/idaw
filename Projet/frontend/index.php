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

    <br>
    <form id="style_form" action="index.php" method="GET">
        <select name="css" onchange='this.form.submit();'>
            <option value="None">Select style</option>
            <option value="style1">style1</option>
            <option value="style2">style2</option>
        </select>
    </form>
    <br>

<section class="corps" style="padding-right: 49.3px;">
    <?php
        if($currentLanguage == 'fr'){
            $pageToInclude = $currentPageId . ".php";
            if(is_readable("" .$pageToInclude)) require_once("" .$pageToInclude);
            else require_once("error.php");
        }else{
            $pageToInclude = $currentPageId . ".php";
            if(is_readable("" .$pageToInclude)) require_once("" .$pageToInclude);
            else require_once("error.php");    
        }
    ?>
</section>


<?php require_once("templates/template-footer.php");?>