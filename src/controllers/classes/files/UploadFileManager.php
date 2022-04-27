<?php
require_once("FileManager.php");

/**
 * Classe de gestion de fichier importé.
 */
abstract class UploadFileManager
{
  protected $file;
  protected $realFilePath = null;

  protected $validExtensions = array();
  protected $maxSize = 0;

  /**
   * Retourner si un fichier est importé.
   * @param $name Clé dans le tableau global `$_FILES`.
   * @return boolean `true` s'il y a un fichier importé, `false` sinon.
   */
  public static function exists($name)
  {
    return $_FILES[$name]["size"] > 0;
  }

  /**
   * @param string $name Clé dans le tableau global `$_FILES`.
   * @throws Error Clé inexistante.
   */
  public function __construct($name)
  {
    if (!isset($_FILES[$name])) {
      throw new Error("La clé '$name' n'existe pas dans la variable globale \$_FILES");
    }

    $this->file = $_FILES[$name];
  }

  /**
   * Enregistrer le fichier dans un répertoire.
   * @param string $filePath Nouveau chemin et nom du fichier où copier.
   * @return boolean `true` si réussite, sinon `false`.
   */
  public function save($filePath)
  {
    $ok = move_uploaded_file($this->file["tmp_name"], $filePath);

    if ($ok) {
      $this->realFilePath = $filePath;
    }

    return $ok;
  }

  /**
   * Retourner si l'extension du fichier importé est autorisée.
   * @return boolean `true` si l'extension est autorisée, sinon `false`.
   */
  public function validateExtension()
  {
    return in_array(FileManager::getExtension($this->file["name"]), $this->validExtensions);
  }

  /**
   * Retourner si la taille du fichier importé est autorisée.
   * @return boolean `true` si la taille du fichier est autorisée, sinon `false`.
   */
  public function validateSize()
  {
    return filesize($this->file["tmp_name"]) <= $this->maxSize;
  }

  /**
   * Retourner si le type du fichier importé est autorisé.
   * @return boolean `true` si le type du fichier est autorisé, sinon `false`.
   */
  public abstract function validateType();

  /**
   * Retourner les extensions autorisées pour le fichier importé.
   * @return string[] Extensions autorisées.
   */
  public function getValidExtensions()
  {
    return $this->validExtensions;
  }

  /**
   * Retourner la taille maximale autorisée pour le fichier importé.
   * @return integer Taille maximale autorisée.
   */
  public function getMaxSize()
  {
    return $this->maxSize;
  }

  /**
   * Retourner le chemin et le nom du fichier où le fichier importé est sauvegardé.
   * @return string|null Chemin et nom du fichier, sinon `null` si le fichier n'a pas été sauvegardé.
   */
  public function getRealFilePath()
  {
    return $this->realFilePath;
  }

  /**
   * Retourner le nom du fichier importé sauvegardé.
   * @return string|null Nom du fichier, sinon `null` si le fichier n'a pas été sauvegardé.
   */
  public function getRealFileName()
  {
    return $this->realFilePath ? basename($this->realFilePath) : null;
  }

  /**
   * Retourner le chemin et le nom du fichier où le fichier importé est temporairement stocké.
   * @return string Chemin et nom du fichier.
   */
  public function getTmpFilePath()
  {
    return $this->file["tmp_name"];
  }

  /**
   * Retourner le nom du fichier importé temporairement stocké.
   * @return string|null Nom du fichier.
   */
  public function getTmpFileName()
  {
    return basename($this->file["tmp_name"]);
  }

  /**
   * Retourner le hash du fichier importé.
   * @return string Hash du fichier.
   */
  public function getFileHash()
  {
    return FileManager::getFileHash($this->getTmpFilePath());
  }

  /**
   * Retourner l'extension du fichier importé.
   * @return string Extension du fichier importé.
   */
  public function getExtension()
  {
    return FileManager::getExtension($this->file["name"]);
  }
}
