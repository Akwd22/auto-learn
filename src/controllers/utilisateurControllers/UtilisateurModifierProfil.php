<?php
require_once("config.php");
require_once("databases/SessionManagement.php");
require_once("databases/UtilisateurCRUD.php");
require_once("controllers/utils.php");
require_once("controllers/classes/UploadImageManager.php");
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
$redirectUrl = "/controllers/utilisateurControllers/UtilisateurAfficherProfil.php";

if (isset($_POST["submit"])) {
  $email = $_POST["email"] ?? null;
  $pass = $_POST["pass"] ?? null;
  $theme = $_POST["theme"] ?? null;
  $admin = $_POST["admin"] ?? null;
  $image = UploadFileManager::exists("image");

  // E-mail.
  if ($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      redirect($redirectUrl, "error", "E-mail invalide.", array("id" => $userId));

    if ($email != $user->getEmail() && $userCRUD->readUserByEmail($email))
      redirect($redirectUrl, "error", "E-mail déjà existante.", array("id" => $userId));

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  } else {
    redirect($redirectUrl, "error", "E-mail obligatoire.", array("id" => $userId));
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
    redirect($redirectUrl, "error", "Thème obligatoire.", array("id" => $userId));
  }

  // Admin.
  if ($isAdmin) {
    $admin = $admin === "on" ? true : false;
  }

  // Image de profil.
  if ($image) {
    $upload = new UploadImageManager("image");

    if (!$upload->validateType())
      redirect($redirectUrl, "error", "Image importée doit être un fichier image.", array("id" => $userId));

    if (!$upload->validateSize())
      redirect($redirectUrl, "error", "Image importée ne doit pas dépasser 1 Mo.", array("id" => $userId));

    if (!$upload->validateExtension())
      redirect($redirectUrl, "error", "Image importée doit avoir un format : " . implode(", ", $upload->getValidExtensions()) . ".", array("id" => $userId));

    if (!$upload->save(UPLOADS_PROFIL_DIR . "$userId." . $upload->getExtension()))
      redirect($redirectUrl, "error", "Erreur lors de l'importation de l'image.", array("id" => $userId));

    $image = $upload->getRealFileName();
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

  redirect($redirectUrl, "success", "Profil modifié avec succès.", array("id" => $userId));
}
