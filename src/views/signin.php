<html>
    <head>
       <meta charset="utf-8">
    </head>
    <body>
        <div id="container">           
            <form action="/controllers/utilisateurControllers/UtilisateurInscription.php" method="POST">
                <h1>Inscription</h1>
                
                <label><b>Nom d'utilisateur</b></label>
                <input type="pseudo" placeholder="Entrer le nom d'utilisateur" name="pseudo" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <label><b>Email</b></label>
                <input type="email" placeholder="Entrer l'email" name="email" required>

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
        </div>
    </body>
</html>