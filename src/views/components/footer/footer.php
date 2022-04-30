<?php
function createFooter()
{
    $html = <<<HTML
    <footer>
        <div id="contentFooter">
            <div id="linksFooter">
                <p><a href="/cours/rechercher">Cours</a></p>
                <p><a href="/qcm/rechercher">Tests</a></p>
                <p><a href="#">Contact</a></p>
                <p><a href="#">Conditions d'utilisation</a></p>
                <p><a href="#">Politiques de confidentialité</a></p>
            </div>
            <div id="divCopyright">
                <p id="copyright">Autolearn | ©2022<p>
            <div>
        </div>
    <footer>
HTML;
echo $html;
}
?>