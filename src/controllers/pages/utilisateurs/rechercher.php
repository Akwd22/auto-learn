<?php
require_once "databases/UtilisateurCRUD.php";
require_once "databases/SessionManagement.php";
require_once "views/pages/utilisateurs/utilisateurs.php";

SessionManagement::session_start();

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();

// Vérification des permissions.
if (!$isLogged || !$isAdmin) die("Vous devez être connecté et être admin.");

// Effectuer la recherche et afficher les utilisateurs.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$search = isset($_POST["site-search"]) ? $_POST["site-search"] : "";
$users = null;

if (!empty($_POST['site-search']) && isset($_POST['sub'])) {
    $users = $userCRUD->readUserForAdmin($_POST['site-search']);
} else {
    $users = $userCRUD->readAllUsers();
}

// Affichage de la vue.
afficherUtilisateurs($users, $search);
