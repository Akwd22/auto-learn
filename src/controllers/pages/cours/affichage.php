<?php
require_once("databases/SessionManagement.php");
require_once("databases/CoursCRUD.php");
require_once("controllers/utils.php");
require_once("databases/UtilisateurCRUD.php");
require_once("models/Cours.php");
require_once("models/TentativeCours.php");
require_once("views/pages/cours/affichage.php");



SessionManagement::session_start();

$coursId = $_GET["id"];

$isLogged = SessionManagement::isLogged();

//verif URL
if (!$coursId) die("ID du cours non spécifié.");

// Vérification connexion.
if (!$isLogged) die("Vous devez être connecté");

$userId=SessionManagement::getUserId();

// Effectuer la récupération du cours
$conn = new DatabaseManagement();
$coursCRUD = new CoursCRUD($conn);
$userCRUD = new UtilisateurCRUD($conn);
$user=$userCRUD->readUserById($userId);

$cours = $coursCRUD->readCoursById($coursId);
if (!$cours) die("Cours n'existe pas.");

if($user->hasCoursTente($coursId)==false){
   $tenta=new TentativeCours();
   $tenta->setDateCommence(new DateTime());
   $tenta->setIsTermine(false);
   $tenta->setCours($cours);

   $user->addCoursTentes($tenta);
   $userCRUD->updateUser($user, $userId); 
}


// Affichage de la vue.
// TODO : afficher la vue
// afficherCours($cours);
