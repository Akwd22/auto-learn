<?php
require_once("models/Enum.php");

abstract class EnumNiveauCours extends Enum
{
  const DEBUTANT = 1;
  const INTERMEDIAIRE = 2;
  const AVANCE = 3;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Débutant",
      2 => "Intermédiaire",
      3 => "Avancé",
    );
  }
}
