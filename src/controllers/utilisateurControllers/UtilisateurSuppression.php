<?php
require_once "databases/SessionManagement.php";

SessionManagement::session_start();

$userId = $_GET["id"] ?? null;
$sessionUserId = SessionManagement::getUserId();

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();
$isOwner = $sessionUserId == $userId;

// Vérification des données.
if (!$userId) die("ID de l'utilisateur non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin && !$isOwner) die("Vous ne pouvez pas supprimer un autre utilisateur.");

// Suppression de l'utilisateur.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$userCRUD->deleteUser($userId);

echo "Suppression de l'utilisateur OK.";
