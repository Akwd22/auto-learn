<?php
include '../../components/header/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php infoHead('Accueil','Page d"accueil', '../accueil/accueil.css');?>
    <link rel="stylesheet" type="text/css" href="../../components/header/header.css">
</head>
<body>
    <header>
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

    </header>
</body>
</html>