<?php
require_once "databases/SessionManagement.php";
require_once "databases/DatabaseManagement.php";

SessionManagement::session_start();

if (SessionManagement::isLogged()) {
  echo "Vous êtes connecté (Utilisateur ID " . SessionManagement::getUserId() . " | Admin ? " . SessionManagement::isAdmin() . ")";
} else {
  echo "Vous êtes déconnecté.";
}
?>

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

<?php
require_once("config.php");
require_once("databases/DatabaseManagement.php");
require_once "databases/SessionManagement.php";
require_once("databases/QcmCRUD.php");
require_once("models/CoursRecommandeQCM.php");
require_once("databases/CoursCRUD.php");
require_once("views/pages/qcm/editer/editer.php");
require_once("controllers/utils.php");
require_once("controllers/classes/files/UploadXmlManager.php");
require_once("controllers/classes/XmlParserQcm.php");

$conn = new DatabaseManagement();
$qcmCRUD = new QcmCRUD($conn);
$coursCRUD  = new CoursCRUD($conn);

$qcm = $qcmCRUD->readQcmById(1);
?>

<!-- <form action="/qcm/edition?id=1" method="post" enctype="multipart/form-data">
  <h1>Modifier le qcm</h1>
  <label for="titre">Nouveau titre</label>
  <input type="text" name="titre" id="titre" value="<?php echo $qcm->getTitre(); ?>">
  <br>
  <label for="description">Nouvelle description</label>
  <input type="text" name="description" id="description" value="<?php echo $qcm->getDescription(); ?>">
  <br>
  <label for="categorie">Nouvelle categorie</label>
  <input type="text" name="categorie" id="categorie" value="<?php echo $qcm->getCategorie(); ?>">
  <br>
  <label for="xml">Nouveau fichier xml</label>
  <input type="file" name="xml" id="xml">
  <br>
  <h1>Cours recommandes</h1>

  <input type="hidden" name="nbCoursRecommandes" value="<?php echo count($qcm->getAllCoursRecommandes()) ?>">

  <?php
  foreach ($qcm->getAllCoursRecommandes() as $i => $reco) {
    $idCours = $reco->getCours()->getId();
    $min = $reco->getMoyMin();
    $max = $reco->getMoyMax();

  ?>
    <div>
      Entre <input type="number" name="min-<?php echo $i+1 ?>" placeholder="Moy min." value="<?php echo $min ?>">
      Et <input type="number" name="max-<?php echo $i+1 ?>" placeholder="Moy max." value="<?php echo $max ?>">
      : <input type=" number" name="id-<?php echo $i+1 ?>" placeholder="Identifiant du cours" value="<?php echo $idCours ?>">
    </div>
  <?php
  }
  ?>

  <input type="submit" name="submit" value="Creer/Modifier le qcm">
</form> -->