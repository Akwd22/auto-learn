<?php

/**
 * Classe de gestion de fichier.
 */
abstract class FileManager
{
  /**
   * Supprimer un fichier.
   * @param string $filePath Chemmin du fichier.
   * @return boolean `true` si réussite, sinon `false`.
   */
  public static function delete($filePath)
  {
    if (self::exists($filePath)) {
      return unlink($filePath);
    }

    return false;
  }

  /**
   * Retourner si un fichier existe.
   * @param string $filePath Chemmin du fichier.
   * @return boolean `true` s'il existe, sinon `false`.
   */
  public static function exists($filePath)
  {
    return file_exists($filePath);
  }

  /**
   * Retourner l'extension d'un fichier.
   * @param string $filePath Chemmin du fichier.
   * @return string Extension du fichier.
   */
  public static function getExtension($filePath)
  {
    return strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
  }
}
