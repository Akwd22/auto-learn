<?php
require_once("config.php");
require_once("databases/SessionManagement.php");
require_once("databases/CoursCRUD.php");
require_once("controllers/utils.php");
require_once("controllers/classes/files/UploadImageManager.php");
require_once("controllers/classes/files/UploadPdfManager.php");
require_once("models/Enum.php");
require_once("models/EnumCategorie.php");
require_once("models/EnumFormatCours.php");
require_once("models/EnumNiveauCours.php");
require_once("views/pages/cours/creation-edition.php");

SessionManagement::session_start();

$coursId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();


// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin) die("Vous ne pouvez pas modifier ce cours.");

// Récupération du cours.
$conn = new DatabaseManagement();
$coursCRUD = new CoursCRUD($conn);

$cours=null;
$isEditMode=false;

if($coursId){
  $cours = $coursCRUD->readCoursById($coursId);
  if (!$cours) die("Cours n'existe pas.");
  $isEditMode=true;
}

//Affichage de la vue ou traitement du formulaire.
if (empty($_POST)) {
  showView();
} else {
    if($isEditMode==true)
      handleFormEdit();
    else 
      handleFormCreate();
}

function showView()
{
  global $cours;
  global $isEditMode;
  afficherVue($isEditMode,$cours);
  exit;
}

function handleFormEdit()
{
  global $coursId;
  global $coursCRUD;
  global $cours;
 
  $redirectUrl = "/cours/editer";

  $titre = $_POST["titre"] ?? null;
  $tempsMoyen = $_POST["tempsMoyen"] ?? null;
  $niveauRecommande = $_POST["niveauRecommande"];
  $description = $_POST["description"] ?? null;
  $categorie= $_POST["categorie"] ?? null;
  $image = UploadFileManager::exists("image");
  $format=$cours::FORMAT;
  
  if($format==1)
    $fichPdf = UploadPdfManager::exists("fichPdf");
  else if($format==2){
    $nbLiens=$_POST["nbLiens"] ?? null;
    $fichUrl=array();
  }
    
  

  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "titre obligatoire.", array("id" => $coursId));

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "description obligatoire.", array("id" => $coursId));
  }

  // tempsMoyen.
  if (!$tempsMoyen) {
    redirect($redirectUrl, "error", "Precisez le temps.", array("id" => $coursId));
  }

  //niveau
  if (!$niveauRecommande) {
    redirect($redirectUrl, "error", "Niveau obligatoire", array("id" => $coursId));
  }

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Categorie obligatoire", array("id" => $coursId));
  }

  // Image .
  if ($image) {
    $upload = new UploadImageManager("image");

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Image importée doit être un fichier image.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Image importée ne doit pas dépasser 1 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Image importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save(UPLOADS_COURS_IMGS_DIR . "$coursId." . $upload->getExtension()))
      redirect($redirectUrl, "error", "Erreur lors de l'importation de l'image.", array("id" => $coursId));

    $image = $upload->getRealFileName();
  } else {
    $image = $cours->getImageUrl();
  }

   //fichier 
   if($format==1){
    if($fichPdf){
      $upload = new UploadPdfManager("fichPdf");

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier importée doit être un fichier pdf.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Fichier importée ne doit pas dépasser 10 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save(UPLOADS_COURS_DOCS_DIR . "$coursId." . $upload->getExtension()))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier.", array("id" => $coursId));

    $fichPdf = $upload->getRealFileName();
    }
    else {
      $fichPdf = $cours->getFichierUrl();
    }
  }
  else if($format==2){
      if($_POST["lien" . 1]){
        for($i=1;$i<=$nbLiens;$i++){
          array_push($fichUrl, $_POST["lien" . $i]);
        }
      }
      else {
        $fichUrl = $cours->getVideosUrl();
      }
    }
     


  // Mettre à jour les données.
  $cours->setTitre($titre);
  $cours->setDescription($description);
  $cours->setTempsMoyen($tempsMoyen);
  $cours->setCategorie(+$categorie);
  $cours->setNiveauRecommande(+$niveauRecommande);
  $cours->setImageUrl($image);
  if($format==1)
    $cours->setFichierUrl($fichPdf);
  else 
    $cours->setVideosUrl($fichUrl);

  $coursCRUD->updateCours($cours, $coursId);

  redirect($redirectUrl, "success", "Cours modifié avec succès.", array("id" => $coursId));

}

function handleFormCreate(){

  global $coursId;
  global $coursCRUD;
  global $cours;
  
  $redirectUrl = "/cours/editer";

  $titre = $_POST["titre"] ?? null;
  $description = $_POST["description"] ?? null;
  $tempsMoyen = $_POST["tempsMoyen"] ?? null;
  $niveauRecommande = $_POST["niveauRecommande"] ?? null;
  $categorie= $_POST["categorie"] ?? null;
  $image = UploadFileManager::exists("image");
  $format=$_POST["format"] ?? null;

  if($format==1)
    $fichPdf = UploadPdfManager::exists("fichPdf");
  else if($format==2){
    $fichUrl=array();
    $nbLiens=$_POST["nbLiens"] ?? null;
  }
  
  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "titre obligatoire.", array("id" => $coursId));

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "description obligatoire.", array("id" => $coursId));
  }

  // tempsMoyen.
  if (!$tempsMoyen) {
    redirect($redirectUrl, "error", "Precisez le temps.", array("id" => $coursId));
  }

  //niveau
  if (!$niveauRecommande) {
    redirect($redirectUrl, "error", "Niveau obligatoire", array("id" => $coursId));
  }

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Categorie obligatoire", array("id" => $coursId));
  }


  // Image .
  if ($image) {
    $upload = new UploadImageManager("image");

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Image importée doit être un fichier image.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Image importée ne doit pas dépasser 1 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Image importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save(UPLOADS_COURS_IMGS_DIR . "$coursId." . $upload->getExtension()))
      redirect($redirectUrl, "error", "Erreur lors de l'importation de l'image.", array("id" => $coursId));

    $image = $upload->getRealFileName();
  } else {
    redirect($redirectUrl, "error", "Image obligatoire", array("id" => $coursId));
  }

  //format
  if (!$format) {
    redirect($redirectUrl, "error", "Format obligatoire", array("id" => $coursId));
  }

  
  //fichier 
  if($format==1){
    if($fichPdf){
      $upload = new UploadPdfManager("fichPdf");

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier importée doit être un fichier pdf.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Fichier importée ne doit pas dépasser 10 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save(UPLOADS_COURS_DOCS_DIR . "$coursId." . $upload->getExtension()))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier.", array("id" => $coursId));

    $fichPdf = $upload->getRealFileName();
    }
    else {
      redirect($redirectUrl, "error", "Fichier obligatoire", array("id" => $coursId));
    }
  }
  else if($format==2){
      if($_POST["lien" . 1]){
        for($i=1;$i<=$nbLiens;$i++){
          array_push($fichUrl, $_POST["lien" . $i]);
        }
      }
    }
     else {
      redirect($redirectUrl, "error", "Liens obligatoires", array("id" => $coursId));
    }
  
  
  if($format==1)
    $cours=new CoursTexte($fichPdf);
  else if($format==2)
    $cours=new CoursVideo($fichUrl);
  
  $cours->setTitre($titre);
  $cours->setDescription($description);
  $cours->setTempsMoyen($tempsMoyen);
  $cours->setCategorie(+$categorie);
  $cours->setNiveauRecommande(+$niveauRecommande);
  $cours->setImageUrl($image);
  
  $coursCRUD->createCours($cours);
  
  redirect($redirectUrl, "success", "Cours crée avec succès.", array("id" => $coursId));


}