<?php
require_once "databases/SessionManagement.php";
require_once "databases/UtilisateurCRUD.php";

SessionManagement::session_start();

if (SessionManagement::isLogged()) {
  echo "Vous êtes connecté (Utilisateur ID " . SessionManagement::getUserId() . " | Admin ? " . SessionManagement::isAdmin() . ")";
} else {
  echo "Vous êtes déconnecté.";
}
?>

<html>

<head>
  <meta charset=”utf-8″>
</head>

<body>
  <div id="container">
    <a href="/views/pages/connexion/login.php">Se connecter</a>
    <a href="/views/pages/inscription/signin.php">S'inscrire</a>
    <a href="/controllers/utilisateurControllers/UtilisateurAfficherProfil.php?id=<?php echo SessionManagement::getUserId() ?>">Mon profil</a>
    <form action="/controllers/utilisateurControllers/UtilisateurDeconnexion.php" method="POST">
      <input type="submit" id='submit' value="SE DECONNECTER">
    </form>
  </div>

  <div id="containerRecherche">
    <form action="/controllers/adminControllers/adminRechercheUtilisateur.php" method="POST">
      <label for="site-search" name="site-search">Rechercher un utilisateur sur le site:</label>
      <input type="search" id="site-search" name="site-search">
      <input type="submit" id='sub' name="sub" value="RECHERCHER">
    </form>
  </div>

 
</body>

</html>