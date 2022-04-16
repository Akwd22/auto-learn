<?php
require_once "databases/SessionManagement.php";
require_once "databases/UtilisateurCRUD.php";
require_once "databases/DatabaseManagement.php";
require_once "databases/CoursCRUD.php";


SessionManagement::session_start();

/*if (SessionManagement::isLogged()) {
  echo "Vous êtes connecté (Utilisateur ID " . SessionManagement::getUserId() . " | Admin ? " . SessionManagement::isAdmin() . ")";
} else {
  echo "Vous êtes déconnecté.";
}*/


$db = new DatabaseManagement();

$userCRUD = new UtilisateurCRUD($db);
$coursCRUD = new CoursCRUD($db);
$tentativeCoursCRUD = new TentativeCoursCRUD($db);


$user = new Utilisateur();
$user->setPseudo("tesaatraaaaaaaazezazeaaaaaa");
$user->setEmail("testaa@taareaaaaazazeazezaeezaaaaasat");
$user->setPassHash("ataestraahaaaaaaazezaeazeaaaaasah");
/*
$coursTexte = new CoursTexte("tertete",30);
$coursTexte->setTitre("titreTexte");
$coursTexte->setDescription("description");
$coursTexte->setImageUrl("test");
$coursTexte->setDateCreation(new DateTime());

$coursCRUD->createCours($coursTexte);

$tentativeCours = new TentativeCours();
$tentativeCours->setCours($coursTexte);

$user->addCoursTentes($tentativeCours);

*/
//$userCRUD->createUser($user);
//var_dump($userCRUD->readAllUsers());

$coursTente=$tentativeCoursCRUD->readTentativeCoursById(1);
$coursTente->terminer(true);

$tentativeCoursCRUD->updateTentativeCours($coursTente, 1);





//$coursCRUD->createCours($coursTexte);
//$coursCRUD->deleteCours(5); Works
//var_dump($coursCRUD->readCoursById(15)); // Works
//var_dump($coursCRUD->readAllCours());
//$coursCRUD->updateCours(1,$coursTexte); trop dur flemme
//$coursCRUD->createTentativeCours($coursTente);
//var_dump( $coursCRUD->readTentativeCoursById(4));


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