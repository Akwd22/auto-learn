<?php
require_once("config.php");
require_once("databases/DatabaseManagement.php");
require_once "databases/SessionManagement.php";
require_once("databases/QcmCRUD.php");
require_once("models/CoursRecommandeQCM.php");
require_once("databases/CoursCRUD.php");
require_once("databases/TentativeQcmCRUD.php");
require_once("views/pages/qcm/editer/editer.php");
require_once("controllers/utils.php");
require_once("controllers/classes/files/UploadXmlManager.php");
require_once("controllers/classes/XmlParserQcm.php");

SessionManagement::session_start();

$qcmId =$_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin) die("Vous ne pouvez pas modifier ce QCM.");

//recup QCM
$conn = new DatabaseManagement();
$qcmCRUD = new QcmCRUD($conn);
$tentaQcmCRUD = new TentativeQcmCRUD($conn);
$coursCRUD = new CoursCRUD($conn);

$cours = null;
$qcm = null;
$isEditMode = $qcmId ? true : false;

if ($isEditMode){
  $qcm = $qcmCRUD->readQcmById($qcmId);
  if(!$qcm)
    die("QCM n'existe pas");
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
  global $qcm;
  global $isEditMode;
  afficherFormulaire($isEditMode, $qcm);
  exit;
}

function handleFormEdit()
{
  global $qcmId;
  global $qcmCRUD;
  global $qcm;
  global $coursCRUD;
  global $tentaQcmCRUD;
  global $cours;
 
  $redirectUrl = "/qcm/edition";

  $titre = $_POST["titre"] ?? null;
  $categorie= $_POST["categorie"] ?? null;
  $description = $_POST["description"] ?? null;
  $xml= UploadXmlManager::exists("xml");
  $nbCoursRecommandes = $_POST["nbCoursRecommandes"];

  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "Titre obligatoire.", array("id" => $qcmId));

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Catégorie obligatoire.", array("id" => $qcmId));
  }

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "Description obligatoire.", array("id" => $qcmId));
  }

  if ($xml) {
    $upload = new UploadXmlManager("xml");
    $savePath = UPLOADS_QCM_DIR . $upload->getFileHash() . "." . $upload->getExtension();

    FileManager::delete(UPLOADS_QCM_DIR . $qcm->getXmlUrl());

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier XML importé doit être un fichier XML.", array("id" => $qcmId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "FIchier XML importé ne doit pas dépasser 500 Ko.", array("id" => $qcmId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier XML importé doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $qcmId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier XML.", array("id" => $qcmId));

    // Parser le fichier XML et créer les questions.
    $xmlParse= new XmlParserQcm($upload->getRealFileName());
    $questions=$xmlParse->parse();
    $qcm->setQuestions($questions);

    // Supprimer toutes les tentatives de ce QCM.
    $tentaQcmCRUD->deleteAllTentativesQcmFromQcm($qcm->getId());

    $xml = $upload->getRealFileName();
  } else {
    $xml = $qcm->getXmlUrl();
  }

  //cours recommandé
  $qcm->setCoursRecommandes([]);

  for($i = 1; $i<=$nbCoursRecommandes; $i++){
    $moyMin = floatval($_POST["min-$i"]);
    $moyMax = floatval($_POST["max-$i"]);
    $idCours = $_POST["id-$i"];

    if (empty($idCours)) continue;

    $cours = $coursCRUD->readCoursById($idCours);

    if(!$cours)
      redirect($redirectUrl, "error", "Cours à recommander n'existe pas.", array("id" => $qcmId));
    if($moyMin<0 || $moyMin>20)
      redirect($redirectUrl, "error", "Moyenne min. doit être entre 0 et 20.", array("id" => $qcmId));
    if($moyMax<0 || $moyMax>20)
      redirect($redirectUrl, "error", "Moyenne max. doit être entre 0 et 20.", array("id" => $qcmId));
    if($moyMax < $moyMin)
      redirect($redirectUrl, "error", "Moyenne max. ≥ à la min.", array("id" => $qcmId));

    $coursRecommande = new CoursRecommandeQCM();
    $coursRecommande->setMoyMin($moyMin);
    $coursRecommande->setMoyMax($moyMax);
    $coursRecommande->setCours($cours);
    $qcm->addCoursRecommandes($coursRecommande);
    }

  // Mettre à jour les données.
  $qcm->setTitre($titre);
  $qcm->setDescription($description);
  $qcm->setCategorie(+$categorie);
  $qcm->setXmlUrl($xml);
  
  $qcmCRUD->updateQcm($qcm);

  redirect($redirectUrl, "success", "QCM modifié avec succès.", array("id" => $qcmId));
}

function handleFormCreate(){

  global $qcmId;
  global $qcmCRUD;
  global $qcm;
  global $coursCRUD;
  global $cours;
  
  $redirectUrl = "/qcm/edition";

  $titre = $_POST["titre"] ?? null;
  $description = $_POST["description"] ?? null;
  $categorie= $_POST["categorie"] ?? null;
  $xml= UploadXmlManager::exists("xml");
  $nbCoursRecommandes = $_POST["nbCoursRecommandes"];
  $qcm = new QCM();

  // titre.
  if (!$titre) 
    redirect($redirectUrl, "error", "Titre obligatoire.", array("id" => $qcmId));

  //description.
  if (!$description) {
    redirect($redirectUrl, "error", "Description obligatoire.", array("id" => $qcmId));
  }

  //categorie
  if (!$categorie) {
    redirect($redirectUrl, "error", "Catégorie obligatoire.", array("id" => $qcmId));
  }

  if ($xml) {
    $upload = new UploadXmlManager("xml");
    $savePath = UPLOADS_QCM_DIR . $upload->getFileHash() . "." . $upload->getExtension();

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Fichier XML importé doit être un fichier XML.", array("id" => $qcmId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "FIchier XML importé ne doit pas dépasser 500 Ko.", array("id" => $qcmId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Fichier XML importé doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $qcmId));

    if (!$upload->save($savePath))
      redirect($redirectUrl, "error", "Erreur lors de l'importation du fichier XML.", array("id" => $qcmId));

    $xmlParse= new XmlParserQcm($upload->getRealFileName());
    $questions=$xmlParse->parse();
    $qcm->setQuestions($questions);

    $xml = $upload->getRealFileName();
  } else {
    redirect($redirectUrl, "error", "Fichier XML obligatoire", array("id" => $qcmId));
  }

  //cours recommandé
  for($i = 1; $i<=$nbCoursRecommandes; $i++){
    $moyMin = floatval($_POST["min-$i"]);
    $moyMax = floatval($_POST["max-$i"]);
    $idCours = $_POST["id-$i"];

    if (empty($idCours)) continue;

    $cours = $coursCRUD->readCoursById($idCours);

    if(!$cours)
      redirect($redirectUrl, "error", "Cours à recommander n'existe pas.", array("id" => $qcmId));
    if($moyMin<0 || $moyMin>20)
      redirect($redirectUrl, "error", "Moyenne min. doit être entre 0 et 20.", array("id" => $qcmId));
    if($moyMax<0 || $moyMax>20)
      redirect($redirectUrl, "error", "Moyenne max. doit être entre 0 et 20.", array("id" => $qcmId));
    if($moyMax < $moyMin)
      redirect($redirectUrl, "error", "Moyenne max. ≥ à la min.", array("id" => $qcmId));

      $coursRecommande = new CoursRecommandeQCM();
      $coursRecommande->setMoyMin($moyMin);
      $coursRecommande->setMoyMax($moyMax);
      $coursRecommande->setCours($cours);
      $qcm->addCoursRecommandes($coursRecommande);
    }

  $qcm->setTitre($titre);
  $qcm->setDescription($description);
  $qcm->setCategorie(+$categorie);
  $qcm->setXmlUrl($xml);

  $qcmCRUD->createQcm($qcm);
  
  redirect($redirectUrl, "success", "QCM créé avec succès.", array("id" => $qcmId));
}
