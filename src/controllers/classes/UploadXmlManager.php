<?php
require_once("UploadFileManager.php");

/**
 * Classe de gestion de fichier XML importé.
 */
class UploadXmlManager extends UploadFileManager
{
  protected $validExtensions = array("xml");
  protected $maxSize = 0.5 * 1000000; // 500 Ko.

  public function validateType()
  {
    return mime_content_type($this->file["tmp_name"]) === "application/xml";
  }
}
