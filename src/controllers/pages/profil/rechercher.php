<?php
require_once "databases/UtilisateurCRUD.php";
require_once "databases/SessionManagement.php";
require_once "views/pages/profil/rechercher/rechercher.php";

SessionManagement::session_start();

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();

// Vérification des permissions.
if (!$isLogged || !$isAdmin) die("Vous devez être connecté et être admin.");

// Effectuer la recherche et afficher les utilisateurs.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$search = isset($_GET["site-search"]) ? $_GET["site-search"] : "";
$users = null;

if (!empty($_GET['site-search']) && isset($_GET['sub'])) {
    $users = $userCRUD->readUserForAdmin($_GET['site-search']);
} else {
    $users = $userCRUD->readAllUsers();
}

// Affichage de la vue.
afficherUtilisateurs($users, $search);
