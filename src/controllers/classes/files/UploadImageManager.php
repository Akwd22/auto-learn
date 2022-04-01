<?php
require_once("UploadFileManager.php");

/**
 * Classe de gestion de fichier image importé.
 */
class UploadImageManager extends UploadFileManager
{
  protected $validExtensions = array("jpg", "jpeg", "png");
  protected $maxSize = 10 * 1000000; // 1 Mo.

  public function validateType()
  {
    return boolval(getimagesize($this->file["tmp_name"]));
  }
}
