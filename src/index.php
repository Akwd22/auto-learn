<?php require '/components/button/button.php'; ?>
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
  <meta charset="utf-8">
</head>

<body>
  <div id="container">
    <form action="/controllers/utilisateurControllers/UtilisateurDeconnexion.php" method="POST">
      <input type="submit" id='submit' value="SE DECONNECTER">
    </form>
  </div>
  <div>
    <?php
    $submitButton = new Button('m', 'outline', 'Sidentifier');
    echo $submitButton->toHtml();
    ?>
    fefefe
  </div>
</body>

</html>