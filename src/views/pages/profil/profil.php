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
  $url_profilImage = $user->getImageUrl() ? UPLOADS_PROFIL_URL . $user->getImageUrl() : DEFAULT_PROFIL_IMG;
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
                  $cours = $cours_tente[$i]->getCours();

                  echo "<div class=\"list-cours-container-component\">";
                  echo "<img class=\"list-cours-container-component-img\" src='" . ($cours->getImageUrl() ? UPLOADS_COURS_IMGS_URL . $cours->getImageUrl() : DEFAULT_COURS_IMG) . "'>";
                  echo "<p class=\"list-cours-container-component-title\">" . $cours_tente[$i]->getCours()->getTitre() . "</p>";
                  printf(
                    "<p class='list-cours-container-component-avancé %s'>%s</p>",
                    ($cours_tente[$i]->getIsTermine() ? "avance-Compléter" : "avance-enCours"),
                    ($cours_tente[$i]->getIsTermine() ? "Terminé" : "En cours")
                  );
                  echo "</div>";
                }
                ?>
              </div>
            </div>

            <!-- TEST DE CONNAISSANCES -->
            <div class="profil-container test-connaissance-container">
              <h2 class="test-connaissance-container-title title">Test de connaissances</h2>
              <div class="test-connaissance-list-qcm-container">
                <?php
                $arr = EnumCategorie::getFriendlyNames();
                $qcm_tente = $user->getAllQcmTentes();
                for ($i = 0; $i < count($qcm_tente); $i++) {
                  $qcm = $qcm_tente[$i]->getQcm();
                  $qcm_id = $qcm->getId();
                  $qcm_titre =  $qcm->getTitre();
                  $qcm_cat = $arr[$qcm->getCategorie()];
                  $pourcentage_completion = ($qcm_tente[$i]->getNumQuestionCourante() / $qcm->nbQuestions()) * 100;
                  $qcm_etat = $qcm_tente[$i]->getIsTermine() ?  $qcm_tente[$i]->getMoy() . '/20' : $pourcentage_completion . '% completé';
                  $qcm_date = $qcm_tente[$i]->getIsTermine() ?  $qcm_tente[$i]->getDateTermine()->format('d/m/Y') : $qcm_tente[$i]->getDateCommence()->format('d/m/Y');
                  $classe =  ($qcm_tente[$i]->getMoy() && $qcm_etat < 10) ? "qcm_etat_bad" : (($qcm_tente[$i]->getMoy() >= 10) ? "qcm_etat_great" : "qcm_etat_other");

                  echo "<a href='qcm?id=$qcm_id'><div class='qcm-list-component'>
                  <div class='qcm-list-component-row'>

                  <h2 class='qcm-list-component-title'>$qcm_titre</h2>
                  <p class='qcm-list-component-cat'>$qcm_cat</p>
                  </div>

                  <div class='qcm-list-component-row'>
                  <h2 class='qcm-list-component-date'>$qcm_date</h2>
                  <p class='$classe'>$qcm_etat</p>
                  </div>

                  </div>
                  </a>";
                }
                ?>

              </div>
            </div>

          </div>
        </div>
      </main>


      <?php createFooter(); ?>
  </body>

<?php
}
