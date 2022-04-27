<?php
require_once("databases/SessionManagement.php");
require_once("databases/QcmCRUD.php");
require_once("databases/TentativeQcmCRUD.php");
require_once("databases/UtilisateurCRUD.php");
require_once("controllers/utils.php");
require_once("config.php");

SessionManagement::session_start();

$qcmId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();

// Vérification des paramètres URL.
if (!$qcmId) die("ID du QCM non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");

// Récupération des données.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);
$qcmCRUD = new QcmCRUD($conn);
$tentaCRUD = new TentativeQcmCRUD($conn);

$qcm = $qcmCRUD->readQcmById($qcmId);
if (!$qcm) die("QCM inconnu");

$user = SessionManagement::getUser();

// Créer la tentative, si c'est la 1ère ouverture du QCM.
if ($user->hasQcmTente($qcmId)) {
  $tentative = $user->getQcmTentesByQcmId($qcmId);
} else {
  $tentative = new TentativeQCM();
  $tentative->setQcm($qcm);
  $user->addQcmTentes($tentative);
  $tentaCRUD->createTentativeQcm($user->getId(), $tentative);
}

$question = $tentative->questionCourante();

// Appeler le sous-contrôleur adéquat.
if ($tentative->getIsTermine()) {
  include("fin.php");
} else if ($tentative->getIsCommence()) {
  include("question.php");
} else {
  include("debut.php");
}
