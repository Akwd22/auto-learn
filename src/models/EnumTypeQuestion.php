<?php
require_once("models/Enum.php");

abstract class EnumTypeQuestion extends Enum
{
  const CHOIX = 1;
  const SAISIE = 2;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Choix",
      2 => "Saisie",
    );
  }
}
