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
require_once("views/pages/cours/editer/editer.php");

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
    if($isEditMode===true)
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
  
  if($format==EnumFormatCours::TEXTE)
    $fichPdf = UploadPdfManager::exists("fichPdf");
  else if($format==EnumFormatCours::VIDEO){
    $nbLiens=$_POST["nbLiens"] ?? null;
    $fichUrl=array();
  }
    
  

  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "Titre obligatoire.", array("id" => $coursId));

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "Description obligatoire.", array("id" => $coursId));
  }

  // tempsMoyen.
  if (!$tempsMoyen) {
    redirect($redirectUrl, "error", "Temps moyen obligatoire.", array("id" => $coursId));
  }

  //niveau
  if (!$niveauRecommande) {
    redirect($redirectUrl, "error", "Niveau obligatoire.", array("id" => $coursId));
  }

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Catégorie obligatoire.", array("id" => $coursId));
  }

  // Image .
  if ($image) {
    $upload = new UploadImageManager("image");
    $savePath = UPLOADS_COURS_IMGS_DIR . $upload->getFileHash() . "." . $upload->getExtension();

    if ($cours->getImageUrl()) FileManager::delete(UPLOADS_COURS_IMGS_DIR . $cours->getImageUrl());

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Image importée doit être un fichier image.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Image importée ne doit pas dépasser 1 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Image importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation de l'image.", array("id" => $coursId));

    $image = $upload->getRealFileName();
  } else {
    $image = $cours->getImageUrl();
  }

   //fichier 
   if($format==EnumFormatCours::TEXTE){
    if($fichPdf){
      $upload = new UploadPdfManager("fichPdf");
      $savePath = UPLOADS_COURS_DOCS_DIR . $upload->getFileHash() . "." . $upload->getExtension();

      if ($cours->getFichierUrl()) FileManager::delete(UPLOADS_COURS_DOCS_DIR . $cours->getFichierUrl());

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier importé doit être un fichier PDF.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Fichier importé ne doit pas dépasser 10 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier importé doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier.", array("id" => $coursId));

    $fichPdf = $upload->getRealFileName();
    }
    else {
      $fichPdf = $cours->getFichierUrl();
    }
  }
  else if($format==EnumFormatCours::VIDEO){
      for ($i = 1; $i <= $nbLiens; $i++)
      {
        $lien = trim($_POST["lien$i"]);

        $urlStart = "https://youtu.be/";

        // Vérifier que le lien est un lien YouTube et le transformer dans le bon format.
        // Sinon, ne pas considérer le lien.
        if (substr($lien, 0, strlen($urlStart)) !== $urlStart)
        {
          parse_str(parse_url($lien, PHP_URL_QUERY), $urlParams);
          $lien = isset($urlParams["v"]) ? ($urlStart . $urlParams["v"]) : null;
        }

        if ($lien) array_push($fichUrl, $lien);
      }

      if (empty($fichUrl)) redirect($redirectUrl, "error", "Au moins un lien YouTube est requis.", array("id" => $coursId));
    }
     


  // Mettre à jour les données.
  $cours->setTitre($titre);
  $cours->setDescription($description);
  $cours->setTempsMoyen($tempsMoyen);
  $cours->setCategorie(+$categorie);
  $cours->setNiveauRecommande(+$niveauRecommande);
  $cours->setImageUrl($image);

  if($format==EnumFormatCours::TEXTE)
    $cours->setFichierUrl($fichPdf);
  else if ($format==EnumFormatCours::VIDEO)
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

  if($format==EnumFormatCours::TEXTE)
    $fichPdf = UploadPdfManager::exists("fichPdf");
  else if($format==EnumFormatCours::VIDEO){
    $fichUrl=array();
    $nbLiens=$_POST["nbLiens"] ?? null;
  }
  
  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "Titre obligatoire.", array("id" => $coursId));

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "Description obligatoire.", array("id" => $coursId));
  }

  // tempsMoyen.
  if (!$tempsMoyen) {
    redirect($redirectUrl, "error", "Temps moyen obligatoire.", array("id" => $coursId));
  }

  //niveau
  if (!$niveauRecommande) {
    redirect($redirectUrl, "error", "Niveau obligatoire.", array("id" => $coursId));
  }

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Catégorie obligatoire.", array("id" => $coursId));
  }


  // Image .
  if ($image) {
    $upload = new UploadImageManager("image");
    $savePath = UPLOADS_COURS_IMGS_DIR . $upload->getFileHash() . "." . $upload->getExtension();

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Image importée doit être un fichier image.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Image importée ne doit pas dépasser 1 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Image importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation de l'image.", array("id" => $coursId));

    $image = $upload->getRealFileName();
  } else {
    $image = null;
  }

  //format
  if (!$format) {
    redirect($redirectUrl, "error", "Format obligatoire.", array("id" => $coursId));
  }

  
  //fichier 
  if($format==EnumFormatCours::TEXTE){
    if($fichPdf){
      $upload = new UploadPdfManager("fichPdf");
      $savePath = UPLOADS_COURS_DOCS_DIR . $upload->getFileHash() . "." . $upload->getExtension();

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier importé doit être un fichier PDF.", array("id" => $coursId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Fichier importé ne doit pas dépasser 10 Mo.", array("id" => $coursId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier importé doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $coursId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier.", array("id" => $coursId));

    $fichPdf = $upload->getRealFileName();
    }
    else {
      redirect($redirectUrl, "error", "Fichier PDF obligatoire.", array("id" => $coursId));
    }
  }
  else if ($format==EnumFormatCours::VIDEO)
  {
    for ($i = 1; $i <= $nbLiens; $i++)
    {
      $lien = trim($_POST["lien$i"]);

      $urlStart = "https://youtu.be/";

      // Vérifier que le lien est un lien YouTube et le transformer dans le bon format.
      // Sinon, ne pas considérer le lien.
      if (substr($lien, 0, strlen($urlStart)) !== $urlStart)
      {
        parse_str(parse_url($lien, PHP_URL_QUERY), $urlParams);
        $lien = isset($urlParams["v"]) ? ($urlStart . $urlParams["v"]) : null;
      }

      if ($lien) array_push($fichUrl, $lien);
    }

    if (empty($fichUrl)) redirect($redirectUrl, "error", "Au moins un lien YouTube est requis.", array("id" => $coursId));
  }
  
  
  if($format==EnumFormatCours::TEXTE)
    $cours=new CoursTexte($fichPdf);
  else if($format==EnumFormatCours::VIDEO)
    $cours=new CoursVideo($fichUrl);
  
  $cours->setTitre($titre);
  $cours->setDescription($description);
  $cours->setTempsMoyen($tempsMoyen);
  $cours->setCategorie(+$categorie);
  $cours->setNiveauRecommande(+$niveauRecommande);
  $cours->setImageUrl($image);
  
  $coursCRUD->createCours($cours);
  
  redirect("/cours/rechercher", "success", "Cours créé avec succès.", [
    "id"          => $coursId,
    "site-search" => $titre,
    "sub"         => true
  ]);
}
