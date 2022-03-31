<?php
require_once("UploadFileManager.php");

/**
 * Classe de gestion de fichier PDF importé.
 */
class UploadPdfManager extends UploadFileManager
{
  protected $validExtensions = array("pdf");
  protected $maxSize = 10 * 1000000; // 10 Mo.

  public function validateType()
  {
    return mime_content_type($this->file["tmp_name"]) === "application/pdf";
  }
}
