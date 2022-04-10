<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';


/**
 * Afficher la page du profil.
 *
 * @param Utilisateur $user Utilisateur du profil à afficher.
 * @return void
 */
function afficherProfil(Utilisateur $user)
{
  $url_profilImage = UPLOADS_PROFIL_URL . $user->getImageUrl();

?>
  <!-- <a href="/profil/modifier?id=<?php echo $user->getId() ?>">Aller sur la page de modification du profil</a> -->

  <head>
    <?php infoHead('Profil', 'Page du profil', '/views/pages/profil/profil.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">

  </head>

  <body>

    <header>
      <?php createrNavbar(); ?>
    </header>

    <main class="page">
      <div class="profil-container-structure">
        <div class="profil-container profil-parametre-container">
          <div class="profil-container-block-top">
            <div class="block-top-img">
              <img id='img-profil-parametres' class="img-profil" src=<?php echo $url_profilImage ?>>
            </div>
            <div class="block-top-content">
              <h2 class="top-content-pseudo title"><?php echo $user->getPseudo() ?></h2>
              <button id="btn-parametres" class="btn2" type="button" value="Paramètre">Paramètres</button>
            </div>
          </div>
        </div>

        <div class="profil-container-bottom-part">
          <!-- DERNIER COURS VISITÉ -->
          <div class="profil-container dernier-cours-container">
            <h2 class="dernier-cours-container-title title">Dernier cours visité</h2>
          </div>


          <div class="profil-container-bottom-part-col">

            <!-- COURS -->
            <div class="profil-container cours-container">
              <h2 class="cours-container-title title">Cours</h2>
            </div>

            <!-- TEST DE CONNAISSANCES -->
            <div class="profil-container test-connaissance-container">
              <h2 class="test-connaissance-container-title title">Test de connaissances</h2>
            </div>

          </div>
        </div>
      </div>
      <!-- PROFIL CONTAINER -->
    </main>

    <?php createFooter(); ?>
  </body>

<?php
}
