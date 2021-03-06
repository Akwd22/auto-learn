<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>

<html>

<head>
    <?php infoHead('S\'identifier', 'Connecte-toi pour accéder à tes cours personnalisés.', '/views/pages/connexion/connexion.css'); ?>
</head>

<body>
    <div id="mainContainer">
        <main class="content">

            <div id="centerDiv">
                <form method="POST">
                    <h1 id="titleForm">S'identifier</h1>

                    <?php createMessage(); ?>

                    <div class="labelsDiv"><label class="labelsForm" for="pseudo">Nom d'utilisateur</label></div>
                    <input id="pseudo" class="input l" type="pseudo" placeholder="Entrer le nom d'utilisateur" name="pseudo" required>

                    <div class="labelsDiv"><label class="labelsForm" for="password">Mot de passe</label></div>
                    <input id="password" class="input l" type="password" placeholder="Entrer le mot de passe" name="password" required>

                    <input class="default m" type="submit" id="submit" value="S'identifier">

                </form>

                <div>
                    <p id="text">
                        Vous n'avez pas de compte ?
                        <a href="/inscription" class="links">Créer un compte</a>
                    </p>
                </div>
            </div>

            <main>
    </div>
</body>

</html>