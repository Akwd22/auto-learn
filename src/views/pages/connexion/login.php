<?php require '../../components/header/header.php'; ?>


<html>
    <head>
        <?php infoHead('Se connecter','Connectes toi pour accèder à tes cours personnalisés', '../connexion/login.css');?>
    </head>

    <body>
        <div id="container">
            <div id="centerDiv">           
            <form action="/controllers/utilisateurControllers/UtilisateurConnexion.php" method="POST">
                <h1 id="titleForm">S'identifier</h1>

                <div id="errorField"><p id="textError">identifiant ou mot de passe incorrect.</p></div>

                <div class="labelsDiv"><label class="labelsForm">Nom d'utilisateur</label></div>
                <input class="input" type="pseudo" placeholder="Entrer le nom d'utilisateur" name="pseudo" required>

                <div class="labelsDiv"><label class="labelsForm">Mot de passe</label></div>
                <input class="input" type="password" placeholder="Entrer le mot de passe" name="password" required>

                <p id="linkForgetPassword"><a href=""  class="links">Mot de passe oublié ?</a><p>

                <input type="submit" id='submit' value="S'identifier" >
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>

            <div>
            <p id="text">
                Vous n'avez pas de compte ? 
                <a href="" class="links">Créer un compte</a>
            </p>
            </div> 
        </div>


        
    </body>
</html>