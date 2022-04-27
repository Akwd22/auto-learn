<?php
require_once("config.php");
require_once("databases/SessionManagement.php");
require_once("databases/QcmCRUD.php");
require_once("controllers/utils.php");
require_once("controllers/classes/files/FileManager.php");


SessionManagement::session_start();

$qcmId = $_GET["id"] ?? null;

/* -------------------------------------------------------------------------- */
/*                                Vérifications                               */
/* -------------------------------------------------------------------------- */

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();

/* --------------------- Vérification des paramètres URL -------------------- */
if (!$qcmId) die("ID du QCM non spécifié.");

/* ---------------------- Vérification des permissions ---------------------- */
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin)  die("Vous n'êtes pas admin.");

/* -------------------------------------------------------------------------- */
/*                              Supprimer le QCM                              */
/* -------------------------------------------------------------------------- */

$conn = new DatabaseManagement();
$qcmCRUD = new QcmCRUD($conn);

$qcm = $qcmCRUD->readQcmById($qcmId);
if (!$qcm) die("QCM n'existe pas.");

//supprimer le fichier xml
$xml = $qcm->getXmlUrl();
if ($xml) {
    $xml = UPLOADS_QCM_DIR . $qcm->getXmlUrl();
    FileManager::delete($xml);
}

// Supprimer le QCM.
$qcmCRUD->deleteQcm($qcmId);

redirect("/qcm/rechercher", "success", "Suppression du QCM avec succès.");
