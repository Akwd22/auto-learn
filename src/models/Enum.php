<?php

/**
 * Classe pour représenter une énumération.
 */
abstract class Enum
{
  const NONE = 0;

  /**
   * Retourner la valeur d'une énumération à partir de son nom.
   * @param string $name Nom de l'énumération (ex. `NONE`).
   * @return integer Valeur de l'énumération (ex. 0 si `$name === NONE`).
   */
  public static final function get($name)
  {
    return constant(get_class() . "::" . $name);
  }
}
