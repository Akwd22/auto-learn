<?php
require_once("databases/SessionManagement.php");
require_once("databases/TentativeCoursCRUD.php");
require_once("controllers/utils.php");

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

/* -------------------------------------------------------------------------- */
/*                         Marquer/démarquer le cours                         */
/* -------------------------------------------------------------------------- */

$user = SessionManagement::getUser();
$tentative = null;

// Rechercher la tentative associée au cours ...
foreach ($user->getAllCoursTentes() as $t) {
  if ($t->getCours()->getId() == $coursId) {
    $tentative = $t;
    break;
  }
}

// ... et la marquer/démarquer.
if ($tentative) {
  $tentative->terminer(!$tentative->getIsTermine());

  $conn = new DatabaseManagement();
  $crud = new TentativeCoursCRUD($conn);
  $crud = $crud->updateTentativeCours($tentative, $tentative->getId());

  redirect("/cours/affichage", "success", "Le cours a été marqué comme " . ($tentative->getIsTermine() ? "complété" : "non complété") . ".", array("id" => $coursId));
} else {
  redirect("/cours/affichage", "error", "Ce cours n'a jamais été commencé.", array("id" => $coursId));
}
