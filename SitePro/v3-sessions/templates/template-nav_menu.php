<div class="menu menuNavigation" style="border: 3px solid rgba(0, 0, 0, 0.2);">
        <div class="titreMenu"> 
<?php
    if(isset($_SESSION['login'])) echo "<a href=\"pages/fr/disconnect.php\">{$_SESSION['login']}</a>";
    else echo "Menu";
    echo "</div>
    <hr class=\"darker tres\">
    ";
?>

<?php
    function renderMenuToHTML($elementMenu, $nomElement, $isCurrent, $currentLanguage) {
            echo "<div class=\"elementMenu\"";
            if($isCurrent == true){echo"id=\"currentpage\"";}
            echo"
                ><a href=\"index.php?page={$elementMenu}&lang={$currentLanguage}\">{$nomElement}</a></div>
                <hr class=\"darker dos\">
            ";
        }
?>                

