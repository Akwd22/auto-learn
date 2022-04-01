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
    <a href="/connexion">Se connecter</a>
    <a href="/inscription">S'inscrire</a>
    <a href="/profil?id=<?php echo SessionManagement::getUserId() ?>">Mon profil</a>
    <a href="/utilisateurs">Rechercher des utilisateurs</a>
    <form action="/deconnexion" method="POST">
      <input type="submit" id='submit' value="Se déconnecter">
    </form>
  </div>

</body>

</html>