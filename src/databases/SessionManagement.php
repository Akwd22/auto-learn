<?php
require_once "databases/DatabaseManagement.php";
require_once "databases/UtilisateurCRUD.php";

class SessionManagement
{
  /**
   * Démarrer une session PHP.
   */
  public static function session_start()
  {
    session_start();

    if (self::isLogged()) {
      $conn = new DatabaseManagement();
      $userCRUD = new UtilisateurCRUD($conn);

      $user = $userCRUD->readUserById(self::getUserId());

      // Si l'utilisateur n'existe plus, détruire la session.
      if (!$user) {
        self::session_destroy();
      }
    }
  }

  /**
   * Détruire les données de la session PHP.
   */
  public static function session_destroy()
  {
    $_SESSION = array();
  }

  /**
   * L'utilisateur est-il connecté à un compte ?
   */
  public static function isLogged()
  {
    return isset($_SESSION["isConnected"]);
  }

  /**
   * L'utilisateur est-il admin ?
   */
  public static function isAdmin()
  {
    return isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
  }

  /**
   * Retourner l'identifiant de l'utilisateur, ou `null` s'il n'est pas connecté.
   */
  public static function getUserId()
  {
    return isset($_SESSION["utilisateurId"]) ? $_SESSION["utilisateurId"] : null;
  }
}
