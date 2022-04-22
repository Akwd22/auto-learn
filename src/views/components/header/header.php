<?php

function infoHead($title, $description, $link_style)
{
    $html = <<<HTML
        <title>$title</title>
        <link rel="shortcut icon" href="assets/img/logo/logo_dark.svg"/>
        <link rel="stylesheet" type="text/css" href="$link_style"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="$description"/>
        <meta name="author" content="DRUET Eddy, GILI Clément, AULOY Rémy, BARBIER Tom, SONVICO Guillaume, MANZANO Lilian" />
HTML;
    echo $html;
}

function createrNavbar()
{


    $isLogin = function () { {
            if (SessionManagement::isLogged()) {
                $user = SessionManagement::getUser();
                $url_profilImage = UPLOADS_PROFIL_URL . $user->getImageUrl();
                $user_id = SessionManagement::getUserId();
            }

            if (!SessionManagement::isLogged()) {
                return <<<HTML
                <a href="/connexion"><button id="btn-connexion" class="outline " type="button" value="Se connecter">Se connecter</button></a>
                <a href="/inscription"><button id="btn-inscription" class="default" type="button" value="S'inscrire">S'inscrire</button></a>
HTML;
            } else {
                return <<<HTML
                <a href="/profil?id={$user_id}"><img class="img-profil" src={$url_profilImage}></a>
HTML;
            }
        }
    };

    $html = <<<HTML
    <div>
    <nav class="navbar">
        <div class="navbar-logo-container">
            <div class="logo"></div>
            <a href="/accueil"><h2 class="navbar-titre">Autolearn</h2></a>
        </div>
        <div class="navbar-links-container">
            <div class="links-container-onglets">
                <ul class="links-container-onglets-list">
                    <li><a href="/rechercher-cours" class="container-onglets-links">Cours</a></li>
                    <li><a href="#" class="container-onglets-links">Tests</a></li>
                </ul>
            </div>
            <div class="links-container-button">
               {$isLogin()}
            </div>
        </div>
    </nav>
    </div>
HTML;

    echo $html;
};
