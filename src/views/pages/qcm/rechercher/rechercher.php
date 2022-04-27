<?php

/**
 * Afficher la liste filtrées des QCM.
 * @param array $qcm Liste des QCM.
 * @param string $lastSearch Dernière recherche dans la barre de recherche.
 * @param EnumCategorie $selectedCat Dernière catégorie choisie.
 * @return void
 */
function afficherQcm(array $qcm, string $lastSearch = "", int $selectedCat = EnumCategorie::AUCUNE)
{
  echo "<h1>Rechercher des QCM</h1>";

  foreach ($qcm as $q) {
    $idQcm = $q->getId();
    echo "<a href=/qcm?id=$idQcm>" . $q->getTitre() . "</a>";
    echo "<br>";
  }
}
