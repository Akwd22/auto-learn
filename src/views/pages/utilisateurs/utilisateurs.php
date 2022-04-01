<?php

/**
 * Afficher la page de la liste des utilisateurs.
 *
 * @param Utilisateur[] $users Tableau des utilisateurs recherchés.
 * @param string $lastSearch Dernière recherche du champ de recherche.
 * @return void
 */
function afficherUtilisateurs(array $users, string $lastSearch)
{
  echo "<h1>Utilisateurs du site</h1>";

?>
  <div id="containerRecherche">
    <form method="POST">
      <label for="site-search" name="site-search">Rechercher un utilisateur sur le site</label>
      <input type="search" id="site-search" name="site-search" value="<?php echo $lastSearch ?>">
      <input type="submit" id='sub' name="sub" value="Rechercher">
    </form>
  </div>

  <h1>Résultats</h1>
<?php

  var_dump($users);
}
