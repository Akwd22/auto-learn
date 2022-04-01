<?php
require_once("models/Enum.php");

abstract class EnumFormatCours extends Enum
{
  const TEXTE = 1;
  const VIDEO = 2;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Texte",
      2 => "Vidéo",
    );
  }
}
