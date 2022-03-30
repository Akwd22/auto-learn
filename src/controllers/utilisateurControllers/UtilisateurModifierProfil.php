<?php
require_once("databases/SessionManagement.php");
require_once("databases/UtilisateurCRUD.php");
require_once("views/pages/profil/profil.php");

SessionManagement::session_start();

$userId = $_GET["id"] ?? null;

$isLogged = SessionManagement::isLogged();
$isAdmin = SessionManagement::isAdmin();
$isOwner = SessionManagement::isSame($userId);

// Vérification des données.
if (!$userId) die("ID de l'utilisateur non spécifié.");

// Vérification des permissions.
if (!$isLogged) die("Vous n'êtes pas connecté.");
if (!$isAdmin && !$isOwner) die("Vous ne pouvez pas modifier un autre utilisateur.");

// Récupération de l'utilisateur.
$conn = new DatabaseManagement();
$userCRUD = new UtilisateurCRUD($conn);

$user = $userCRUD->readUserById($userId);
if (!$user) die("Utilisateur n'existe pas.");

// Traitement des données du formulaire.
function redirectUrl($userId, $type, $msg)
{
  header("Location: /controllers/utilisateurControllers/UtilisateurAfficherProfil.php?id=$userId&$type=$msg");
  exit();
}

if (isset($_POST["submit"])) {
  $email = $_POST["email"] ?? null;
  $pass = $_POST["pass"] ?? null;
  $theme = $_POST["theme"] ?? null;
  $admin = $_POST["admin"] ?? null;
  $image = $_FILES["image"]["size"] > 0;

  // E-mail.
  if ($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      redirectUrl($userId, "error", "E-mail invalide.");

    if ($email != $user->getEmail() && $userCRUD->readUserByEmail($email))
      redirectUrl($userId, "error", "E-mail déjà existant.");

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  } else {
    redirectUrl($userId, "error", "E-mail obligatoire.");
  }

  // Mot de passe.
  if ($pass) {
    $pass = password_hash($pass, PASSWORD_DEFAULT);
  } else {
    $pass = $user->getPassHash();
  }

  // Thème utilisé.
  if ($theme) {
    $theme = $theme === "light" ? EnumTheme::CLAIR : EnumTheme::SOMBRE;
  } else {
    redirectUrl($userId,  "error", "Thème obligatoire.");
  }

  // Admin.
  if ($isAdmin) {
    $admin = $admin === "on" ? "1" : "0";
  }

  // Image de profil.
  if ($image) {
    $fileExt = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $filePath = dirname(__DIR__) . "../../assets/uploads/profils/";
    $fileName = "$userId.$fileExt";
    $fileSize = $_FILES["image"]["size"];
    $tmpFile = $_FILES["image"]["tmp_name"];

    if (!getimagesize($tmpFile))
      redirectUrl($userId,  "error", "Image importée doit être un fichier image.");

    if ($fileSize > 1 * 1000000)
      redirectUrl($userId,  "error", "Image importée ne doit pas dépasser 1 Mo.");

    if (!in_array($fileExt, array("jpg", "jpeg", "png")))
      redirectUrl($userId,  "error", "Image importée doit avoir le format jpg, png.");

    if (!move_uploaded_file($tmpFile, $filePath . $fileName))
      redirectUrl($userId,  "error", "Erreur lors de l'importation de l'image.");

    $image = $fileName;
  } else {
    $image = $user->getImageUrl();
  }

  // Mettre à jour les données.
  $user->setEmail($email);
  $user->setPassHash($pass);
  $user->setTheme($theme);
  $user->setImageUrl($image);
  if ($isAdmin) $user->setIsAdmin($admin);

  $userCRUD->updateUser($user, $userId);

  redirectUrl($userId, "success", "Profil modifié avec succès.");
}
