<?php require 'views/components/header/header.php'; ?>


<html>
    <head>
        <?php infoHead('S\'inscrire','Inscris toi pour une meilleur expérience', 'views/pages/inscription/signin.css');?>
    </head>
    <body>
        <div id="container">
            <div id="centerDiv">              
                <form action="/controllers/utilisateurControllers/UtilisateurInscription.php" method="POST">
                    <h1 id="titleForm">Inscription</h1>
                    <div id="errorField"><p id="textError">Format du mail incorrect.</p></div>
                    
                    <div class="labelsDiv"><label class="labelsForm" for="email">Email</label></div>
                    <input id="email" class="input" type="email" placeholder="Entrer l'email" name="email" required>

                    <div class="labelsDiv"><label class="labelsForm" for="pseudo">Nom d'utilisateur</label></div>
                    <input id="pseudo" class="input" type="pseudo" placeholder="Entrer le nom d'utilisateur" name="pseudo" required>

                    <div class="labelsDiv"><label class="labelsForm" for="password">Mot de passe</label></div>
                    <input id="password" class="input" type="password" placeholder="Entrer le mot de passe" name="password" required>

                    
                    <div id="divCheckbox">
                        <input id="acceptConditions" type="checkbox" names="acceptConditions" required>
                    </div>
                    <div id="divLabelCheckbox">
                        <label id="labelAcceptConditions" for="acceptConditions">J'ai lu et j'accepte les termes d'utilisation ainsi que la politique de confidentialité.</label>
                    </div>
                    
                    <input type="submit" id='submit' value="S'INSCRIRE" >
                    <?php
                    if(isset($_GET['erreur'])){
                        $err = $_GET['erreur'];
                        if($err==1)
                            echo "<p style='color:red'>Utilisateur déjà existant</p>";
                        if($err==2)
                            echo  "<p style='color:red'>Email déjà existant</p>";
                    }
                    ?>
                </form>
                <div>
                <p id="text">
                    Vous avez déjà un compte ? 
                    <a href="" class="links">Se connecter</a>
                </p>
                </div> 
            </div>
        </div>
    </body>
</html>