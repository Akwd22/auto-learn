<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php infoHead('Accueil', 'Page d"accueil', '/views/pages/accueil/accueil.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
</head>

<body>
    <div id="mainContainer">
        <header>
            <?php createrNavbar(); ?>
        </header>
        <main class="accueil-container content">

            <div class="accueil-container-slogan">
                <h1 class="slogan-titre">La meilleure façon d'apprendre à coder</h1>
            </div>
            <div class="slogan-suite">
                <p class="slogan-text">Les cours sont conseillés suivants votre niveau déterminé par des tests de <br /> connaissance. C'est gratuit !</p>
            </div>
            <div class="accueil-container-bouton">
                <a href="/rechercher-cours"><button button id="btn-accueil" class="default m" type="button" value="Commencez à apprendre">Commencez à apprendre</button></a>
            </div>

        </main>
    </div>
    <?php createFooter(); ?>
</body>

</html>