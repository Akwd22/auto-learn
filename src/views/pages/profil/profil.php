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
  $url_profilImage = htmlspecialchars($user->getImageUrl() ? UPLOADS_PROFIL_URL . $user->getImageUrl() : DEFAULT_PROFIL_IMG);
  $pseudo = htmlspecialchars($user->getPseudo());
  $userId = htmlspecialchars($user->getId());
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
                <h2 class="top-content-pseudo title"><?php echo $pseudo ?></h2>
                <?php if (SessionManagement::isAdmin() || SessionManagement::isSame($userId)) { ?>
                  <a href="/profil/modifier?id=<?php echo $userId ?>"><button id="btn-parametres" class="btn2" type="button" value="Paramètre">Paramètres</button></a>
                <?php } ?>
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
                  $imgUrl = htmlspecialchars($cours->getImageUrl() ? UPLOADS_COURS_IMGS_URL . $cours->getImageUrl() : DEFAULT_COURS_IMG);
                  $titre = htmlspecialchars($cours_tente[$i]->getCours()->getTitre());

                  echo "<div class=\"list-cours-container-component\">";
                  echo "<img class=\"list-cours-container-component-img\" src='" . $imgUrl . "'>";
                  echo "<p class=\"list-cours-container-component-title\">" . $titre . "</p>";
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
                  $qcm_id = htmlspecialchars($qcm->getId());
                  $qcm_titre =  htmlspecialchars($qcm->getTitre());
                  $qcm_cat = htmlspecialchars($arr[$qcm->getCategorie()]);
                  $pourcentage_completion = $qcm_tente[$i]->getIsCommence() ? (($qcm_tente[$i]->getNumQuestionCourante() - 1) / $qcm->nbQuestions()) * 100 : 0;
                  $qcm_moy = number_format($qcm_tente[$i]->getMoy(), 2);
                  $qcm_etat = $qcm_tente[$i]->getIsTermine() ?  $qcm_moy . '/20' : $pourcentage_completion . '% complété';
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
