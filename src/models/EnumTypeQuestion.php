<?php
require_once("models/Enum.php");

abstract class EnumTypeQuestion extends Enum
{
  const CHOIX_UNIQUE = 1;
  const CHOIX_MULTIPLES = 2;
  const SAISIE = 3;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Choix unique",
      2 => "Choix multiples",
      3 => "Saisie",
    );
  }
}
