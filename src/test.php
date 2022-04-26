<?php
require_once "databases/SessionManagement.php";
require_once "databases/UtilisateurCRUD.php";
require_once "databases/DatabaseManagement.php";
require_once "databases/CoursCRUD.php";
require_once "models/QuestionQCM.php";
require_once "models/ReponseQCM.php";
require_once "models/TentativeQCM.php";
require_once "models/QCM.php";





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

/*$coursTente = $tentativeCoursCRUD->readTentativeCoursById(1);
$coursTente->terminer(true);

$tentativeCoursCRUD->updateTentativeCours($coursTente, 1);
*/

$quest = new QuestionSaisie(1);
$quest->setBonneReponse("test1");

$quest2 = new QuestionSaisie(2);
$quest2->setBonneReponse("test2");



$rep = new ReponseSaisie("test1");

//var_dump($quest->isCorrecte($rep));

$tentativeQCM = new TentativeQCM();
$qcm = new QCM();
$qcm->addQuestion($quest);
$qcm->addQuestion($quest2);

$tentativeQCM->setQcm($qcm);

$tentativeQCM->setNumQuestionCourante(0);
$tentativeQCM->questionSuivante($rep);


$cours = new CoursTexte("tertete",30);
$cours->setTitre("titreTexte");
$cours->setDescription("description");
$cours->setImageUrl("test");
$cours->setDateCreation(new DateTime());
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
    <a href="/rechercher-cours">Rechercher des cours</a>
    <form action="/deconnexion" method="POST">
      <input type="submit" id='submit' value="Se déconnecter">
    </form>
  </div>

  <div>
  <form action="/cours/editer" method="post" enctype="multipart/form-data">
    <h1>Modifier le cours</h1>
    <label for="titre">Nouveau titre</label>
    <input type="text" name="titre" id="titre" value="<?php echo $cours->getTitre() ?>">
    <br>
    <label for="description">Nouvelle description</label>
    <input type="text" name="description" id="description">
    <br>
    <label for="tempsMoyen">Temps</label>
    <input type="text" name="tempsMoyen" id="tempsMoyen">
    <br>
    <select name="categorie">
    <option value="1">Bureautique</option>
    <option value="2">Langages</option>
    </select>
    <br>
    <br>
    <select name="niveauRecommande">
    <option value="1">Debutant</option>
    <option value="2">Avance</option>
    </select>
    <br>
    <label for="image">Nouvelle image</label>
    <input type="file" name="image" id="image">
    <br>
    <label for="fichPdf">Nouveau cours pdf</label>
    <input type="file" name="fichPdf" id="fichPdf">
    <br>
    <input type="hidden" name="nbLiens" value="3">
    <input type="text" name="lien1">
    <input type="text" name="lien2">
    <input type="text" name="lien3">
    <br>
    <input type="submit" name="submit" value="Modifier le cours">
  </form>
  </div>

</body>

</html>