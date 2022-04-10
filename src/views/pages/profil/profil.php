<?php

/**
 * Afficher la page du profil.
 *
 * @param Utilisateur $user Utilisateur du profil à afficher.
 * @return void
 */
function afficherProfil(Utilisateur $user)
{
  $url_profilImage = UPLOADS_PROFIL_URL. $user->getImageUrl();

?>
  <!-- <a href="/profil/modifier?id=<?php echo $user->getId() ?>">Aller sur la page de modification du profil</a> -->
  <main class="page">
    <div class="profil-container">
      <div class="profil-container-block-top">
        <div class="block-top-img">

        </div>
        <div class="block-top-content">
          <img class="img-profil" src=<?php echo $url_profilImage ?>>
        </div>
      </div>
    </div>
  </main>

<?php
}

