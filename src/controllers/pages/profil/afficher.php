<?php
require_once("databases/SessionManagement.php");
require_once("databases/UtilisateurCRUD.php");
require_once("views/pages/profil/profil.php");
require_once('config.php');

SessionManagement::session_start();

$userId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();

// Vérification des paramètres URL.
if (!$userId) die("ID de l'utilisateur non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");

// Récupération des données.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$user = $userCRUD->readUserById($userId);
if (!$user) die("Utilisateur inconnu.");

// Affichage de la vue.
afficherProfil($user);
