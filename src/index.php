<?php
include 'databases/UtilisateurCRUD.php';

session_start();

if (isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]) {
  echo "Vous êtes connecté (Utilisateur ID " . $_SESSION['utilisateurId'] . " | Admin ? " . $_SESSION['isAdmin'] . ")";
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
    <form action="/controllers/utilisateurControllers/UtilisateurDeconnexion.php" method="POST">
      <input type="submit" id='submit' value="SE DECONNECTER">
    </form>
  </div>
</body>

</html>
