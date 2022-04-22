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
  //VARIABLES PHP
  $url_profilImage = UPLOADS_PROFIL_URL . $user->getImageUrl();
  function EtatCours($user)
  {
  }
?>

  <head>
    <?php infoHead('Profil', 'Page du profil', '/views/pages/profil/profil.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">

  </head>

  <body>
    <div id="mainContainer">
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
                <a href="/profil/modifier?id=<?php echo $user->getId() ?>"><button id="btn-parametres" class="btn2" type="button" value="Paramètre">Paramètres</button></a>
              </div>
            </div>
          </div>
          <img src="">
          <div class="profil-container-bottom-part-col">

            <!-- COURS -->
            <div class="profil-container cours-container">
              <h2 class="cours-container-title title">Progression des cours</h2>
              <div class="cours-container-list-cours-container">
                <?php
                $cours_tente =  $user->getAllCoursTentes();
                for ($i = 0; $i < count($cours_tente); $i++) {
                  echo "<div class=\"list-cours-container-component\">";
                  echo "<img class=\"list-cours-container-component-img\" src='" . UPLOADS_COURS_IMGS_URL . $cours_tente[$i]->getCours()->getImageUrl() . "'>";
                  echo "<p class=\"list-cours-container-component-title\">" . $cours_tente[$i]->getCours()->getTitre() . "</p>";
                  printf(
                    "<p class='list-cours-container-component-avancé %s'>%s</p>",
                    ($cours_tente[$i]->getIsTermine() ? "avance-Compléter" : "avance-enCours"),
                    ($cours_tente[$i]->getIsTermine() ? "Compléter" : "En cours")
                  );
                  echo "</div>";
                }
                ?>
              </div>
            </div>

            <!-- TEST DE CONNAISSANCES -->
            <div class="profil-container test-connaissance-container">
              <h2 class="test-connaissance-container-title title">Test de connaissances</h2>
            </div>

          </div>
        </div>
      </main>


      <?php createFooter(); ?>

  </body>

<?php
}
