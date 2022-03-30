<?php
include '../../components/header/header.php';
include '../../components/footer/footer.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php infoHead('Accueil', 'Page d"accueil', '../accueil/accueil.css'); ?>
    <link rel="stylesheet" type="text/css" href="../../components/header/header.css">
    <link rel="stylesheet" type="text/css" href="../../components/footer/footer.css">
</head>

<body>
    <header>
        <?php createrNavbar(); ?>
    </header>
    <main class="accueil-container">
        <div class="accueil-container-slogan">
            <h1 class="slogan-titre">La meilleure façon d'apprendre à coder</h1>
        </div>
        <div class="slogan-suite">
            <p class="slogan-text">Les cours sont conseillés suivants votre niveau déterminé par des tests de <br /> connaissance. C'est gratuit !</p>
        </div>
        <div class="accueil-container-bouton">
            <button button id="btn-accueil" class="btn2" type="button" value="Commencez à apprendre">Commencez à apprendre</button>
        </div>
    </main>
    <div class="content">

    </div>
    <!-- Balise footer définit dans la fonction -->
    <?php createFooter(); ?>


</body>

</html>