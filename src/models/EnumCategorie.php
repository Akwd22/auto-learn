<?php
require_once("models/Enum.php");

abstract class EnumCategorie extends Enum
{
  const AUCUNE = 1;
  const BUREAUTIQUE = 2;
  const LANGAGES = 3;
  const ALGORITHMIQUE = 4;
  const WEB = 5;
  const DESIGN = 6;
  const RESEAUX = 7;
  const SECURITE = 8;
  const BASES_DE_DONNEES = 9;
  const JEUX_VIDEO = 10;
  const MICRO_CONTROLEUR = 11;
  const ELECTRONIQUE = 12;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Aucune",
      2 => "Bureautique",
      3 => "Langages",
      4 => "Algorithmique",
      5 => "Web",
      6 => "Design",
      7 => "Réseaux",
      8 => "Sécurité",
      9 => "Base de données",
      10 => "Jeux-vidéo",
      11 => "Micro-contrôleur",
      12 => "Électronique"
    );
  }
}
