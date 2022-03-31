<?php
require_once "databases/DatabaseManagement.php";
require_once "databases/UtilisateurCRUD.php";

/**
 * Classe de gestion de session PHP et de l'utilisateur connecté.
 */
class SessionManagement
{
  private static $user = null;

  /**
   * Démarrer une session PHP.
   * @return void
   */
  public static function session_start()
  {
    session_start();

    if (self::isLogged()) {
      $conn = new DatabaseManagement();
      $userCRUD = new UtilisateurCRUD($conn);

      $user = $userCRUD->readUserById(self::getUserId());

      if (!$user) {
        // Si l'utilisateur n'existe plus, détruire la session.
        self::session_destroy();
      } else {
        self::setUser($user);
      }
    }
  }

  /**
   * Détruire les données de la session PHP.
   * @return void
   */
  public static function session_destroy()
  {
    self::$user = null;
    $_SESSION = array();
  }

  /**
   * L'utilisateur est-il connecté à un compte ?
   * @return boolean
   */
  public static function isLogged()
  {
    return isset($_SESSION["isConnected"]);
  }

  /**
   * L'utilisateur est-il admin ?
   * @return boolean
   */
  public static function isAdmin()
  {
    return self::isLogged() ? boolval(self::$user->getIsAdmin()) : false;
  }

  /**
   * Comparer l'utilisateur avec un autre.
   * @param mixed $userId Identifiant de l'autre utilisateur
   * @return boolean `true` si les deux utilisateurs sont les mêmes, sinon `false`.
   */
  public static function isSame($userId)
  {
    return self::getUserId() == $userId;
  }

  /**
   * Retourner l'identifiant de l'utilisateur, ou `null` s'il n'est pas connecté.
   * @return integer|null
   */
  public static function getUserId()
  {
    return isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
  }

  /**
   * Retourner l'utilisateur connecté, ou `null` s'il n'est pas connecté.
   * @return Utilisateur|null
   */
  public static function getUser()
  {
    return self::$user;
  }

  /**
   * Définir l'utilisateur connecté pour la session PHP.
   * @param Utilisateur|null $user Instance de l'tilisateur, ou `null` pour aucun utilisateur.
   * @return void
   */
  public static function setUser($user)
  {
    if (!$user) {
      self::session_destroy();
    } else {
      self::$user = $user;
      $_SESSION["isConnected"] = true;
      $_SESSION["userId"] = intval($user->getId());
    }
  }
}
