<?php
require_once "databases/SessionManagement.php";
require_once "databases/UtilisateurCRUD.php";
require_once "models/Utilisateur.php";
require_once "models/CoursRecommandeQCM.php";

SessionManagement::session_start();

if (SessionManagement::isLogged()) {
  echo "Vous êtes connecté (Utilisateur ID " . SessionManagement::getUserId() . " | Admin ? " . SessionManagement::isAdmin() . ")";
} else {
  echo "Vous êtes déconnecté.";
}

$user = new Utilisateur();
$c = new TentativeCours(1);
$c2 = new TentativeCours(2);


$user->addCoursTentes($c);
$user->addCoursTentes($c2);

var_dump($user->getCoursTentes(1));
var_dump($user->getCoursTentes(2));

$user->removeCoursTentes(2);
$user->removeCoursTentes(7);

var_dump($user->getCoursTentes(7));

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