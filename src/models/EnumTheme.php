<?php
require_once("models/Enum.php");

abstract class EnumTheme extends Enum
{
  const CLAIR = 1;
  const SOMBRE = 2;

  public static function getFriendlyNames()
  {
    return array(
      1 => "Clair",
      2 => "Sombre",
    );
  }
}
