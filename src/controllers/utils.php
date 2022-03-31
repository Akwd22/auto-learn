<?php

/**
 * Rediriger vers une URL.
 * 
 * Il est possible d'afficher une réponse (bandeau de succès ou d'erreur) avec les paramètres
 * `$responseType` et `$responseMsg`.
 *
 * Exemple :
 * ```php
 * redirect("index.php");
 * redirect("index.php", "error", "Accès refusé");
 * redirect("index.php", "success", "Accès autorisé", array("id" => 5));
 * redirect("index.php", null, null, array("id" => 5));
 * ```
 *
 * @param string $url URL de redirection.
 * @param string $responseType Type de la réponse (valeurs possibles : `success`, `error`). Facultatif.
 * @param string $responseMsg Message de la réponse. Facultatif, sauf si `$responseType` spécifié.
 * @param array $params Paramètres à placer dans l'URL. Facultatif.
 * @return void
 */
function redirect($url, $responseType = null, $responseMsg = null, $params = array())
{
  if ($responseType && !in_array($responseType, array("success", "error")))
    throw new Error("\$responseType ne peut prendre que : null, 'success', ou 'error'");

  if ($responseType && !$responseMsg)
    throw new Error("\$responseMsg est obligatoire avec \$responseType");

  if ($responseType && $responseMsg)
    $params[$responseType] = $responseMsg;

  if (!empty($params)) {
    $params = http_build_query($params);
    $url .= "?$params";
  }

  header("Location: $url");
  exit();
}
