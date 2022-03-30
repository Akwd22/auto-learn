<?php
function infoHead ($title, $description, $link_style)
{
    $html = <<<HTML
        <title>$title</title>
        <link rel="shortcut icon" href="../images/logoNoir.png"/>
        <link rel="stylesheet" type="text/css" href="$link_style"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="$description"/>
        <meta name="author" content="DRUET Eddy, GILI Clément, AULOY Rémy, BARBIER Tom, SONVICO Guillaume, MANZANO Lilian" />
HTML;
echo $html;
}

function createLink($title, $className)
{
    $html = <<<HTML
        <a class=$className href="#">
            $title
        </a>
HTML;
echo $html;
}


function createrNavbar()
{
    $html = <<<HTML
    <div>
    <nav class="navbar">
        <div class="navbar-logo-container">
            <img src="../../../assets/uploads/logo/logo.svg" alt="Logo du site" class="navbar-logo">
            <h2 class="navbar-titre">Autolearn</h2>
        </div>
        <div class="navbar-links-container">
            <div class="links-container-onglets">
                <ul class="links-container-onglets-list">
                    <li><a href="#" class="container-onglets-links">Cours</a></li>
                    <li><a href="#" class="container-onglets-links">Tests</a></li>
                </ul>
            </div>
            <div class="links-container-button">
                <button class="btn1" type="button" value="Se connecter">Se connecter</button>
                <button class="btn2" type="button" value="S'inscrire">S'inscrire</button>
            </div>
        </div>
    </nav>
    </div>

HTML;
echo $html;
}

?>




