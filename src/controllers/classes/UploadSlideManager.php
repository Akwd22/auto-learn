<?php
require_once("UploadFileManager.php");

/**
 * Classe de gestion de fichier slide (PowerPoint, etc.) importé.
 */
class UploadSlideManager extends UploadFileManager
{
  protected $validExtensions = array("ppt", "pptx", "odp");
  protected $maxSize = 0.5 * 1000000; // 500 Ko.

  public function validateType()
  {
    $mimeType = mime_content_type($this->file["tmp_name"]);

    return in_array($mimeType, array(
      "application/vnd.ms-powerpoint",
      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
      "application/vnd.oasis.opendocument.presentation",
    ));
  }
}
