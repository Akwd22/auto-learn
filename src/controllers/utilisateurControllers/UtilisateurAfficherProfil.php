<?php
require_once("databases/SessionManagement.php");
require_once("databases/UtilisateurCRUD.php");

SessionManagement::session_start();

$userId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();
$isOwner = SessionManagement::isSame($userId);

// Vérification des données.
if (!$userId) die("ID de l'utilisateur non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");

// Récupération des données.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$user = $userCRUD->readUserById($userId);
if (!$user) die("Utilisateur inconnu.");

// Affichage de la vue.
$user = $user;
require("views/pages/profil/profil.php");
