<?php

/**
 * Afficher la liste filtrées des QCM.
 * @param array $qcm Liste des QCM.
 * @param string $lastSearch Dernière recherche dans la barre de recherche.
 * @param int $selectedCat Dernière catégorie choisie.
 * @param bool $completedOnly Faut-il afficher uniquement les QCM terminés ?
 * @return void
 */
function afficherQcm(array $qcm, string $lastSearch = "", int $selectedCat = EnumCategorie::AUCUNE, bool $completedOnly = false)
{
  echo "<h1>Rechercher des QCM</h1>";

  foreach ($qcm as $q) {
    $idQcm = $q->getId();
    echo "<a href=/qcm?id=$idQcm>" . $q->getTitre() . "</a>";
    echo "<br>";
  }
}
