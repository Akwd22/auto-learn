<?php

/**
 * Afficher la page du profil.
 *
 * @param Utilisateur $user Utilisateur du profil à afficher.
 * @return void
 */
function afficherProfil(Utilisateur $user)
{
  echo "<h1>Page de profil</h1>";
  var_dump($user);

?>
  <a href="/profil/modifier?id=<?php echo $user->getId() ?>">Aller sur la page de modification du profil</a>
<?php
}
