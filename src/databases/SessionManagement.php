<?php
require_once "databases/DatabaseManagement.php";
require_once "databases/UtilisateurCRUD.php";

class SessionManagement
{
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
        self::setUser($user->getId(), $user->getIsAdmin());
      }
    }
  }

  /**
   * Détruire les données de la session PHP.
   * @return void
   */
  public static function session_destroy()
  {
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
    return isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;
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
    return isset($_SESSION["utilisateurId"]) ? $_SESSION["utilisateurId"] : null;
  }

  /**
   * Définir l'utilisateur connecté pour la session PHP.
   *
   * @param integer $userId Identifiant de l'utilisateur.
   * @param boolean $isAdmin Est-il admin ?
   * @return void
   */
  public static function setUser($userId, $isAdmin)
  {
    $_SESSION["utilisateurId"] = intval($userId);
    $_SESSION["isAdmin"] = boolval($isAdmin);
  }
}
