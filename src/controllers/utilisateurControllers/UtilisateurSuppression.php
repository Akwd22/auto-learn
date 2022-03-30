<?php
require_once "databases/SessionManagement.php";

SessionManagement::session_start();

$userId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();
$isOwner = SessionManagement::isSame($userId);

// Vérification des données.
if (!$userId) die("ID de l'utilisateur non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin && !$isOwner) die("Vous ne pouvez pas supprimer un autre utilisateur.");

// Suppression de l'utilisateur.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$user = $userCRUD->readUserById($userId);
if (!$user) die("Utilisateur n'existe pas.");

// Supprimer l'image de profil.
$image = $user->getImageUrl();

if ($image) {
  $url = dirname(__DIR__) . "../../assets/uploads/profils/$image";
  unlink($url);
}

// Supprimer l'utilisateur.
$userCRUD->deleteUser($userId);

echo "Suppression de l'utilisateur OK.";
