<?php
include 'databases/UtilisateurCRUD.php';

session_start();

if (isset($_SESSION["isConnected"]) && $_SESSION["isConnected"]) {
  echo "Vous êtes connecté (Utilisateur ID " . $_SESSION['utilisateurId'] . " | Admin ? " . $_SESSION['isAdmin'] . ")";
} else {
  echo "Vous êtes déconnecté.";
}
