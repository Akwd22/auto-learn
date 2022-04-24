<?php
require_once("config.php");
require_once("databases/SessionManagement.php");
require_once("databases/CoursCRUD.php");
require_once("controllers/utils.php");
require_once("controllers/classes/files/FileManager.php");

SessionManagement::session_start();

$coursId = $_GET["id"] ?? null;

/* -------------------------------------------------------------------------- */
/*                                Vérifications                               */
/* -------------------------------------------------------------------------- */

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();

/* --------------------- Vérification des paramètres URL -------------------- */
if (!$coursId) die("ID du cours non spécifié.");

/* ---------------------- Vérification des permissions ---------------------- */
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin)  die("Vous n'êtes pas admin.");

/* -------------------------------------------------------------------------- */
/*                             Supprimer le cours                             */
/* -------------------------------------------------------------------------- */

$conn = new DatabaseManagement();
$coursCRUD = new CoursCRUD($conn);

$cours = $coursCRUD->readCoursById($coursId);
if (!$cours) die("Cours n'existe pas.");

// Supprimer l'image du cours.
$image = $cours->getImageUrl();

if ($image) {
  $image = UPLOADS_COURS_IMGS_DIR . "$image";
  FileManager::delete($image);
}

// Supprimer le cours.
$coursCRUD->deleteCours($coursId);

redirect("/rechercher-cours", "success", "Suppression du cours avec succès.");
