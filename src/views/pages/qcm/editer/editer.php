<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/radio/radio.php';
require 'views/components/message/message.php';

/**
 * Afficher le formulaire d'édition d'un QCM.
 * @param boolean $isEditMode Formulaire est-il en mode d'édition d'un QCM existant ?
 * @param QCM|null $qcm QCM à éditer, sinon `null` si en mode création.
 * @return void
 */
function afficherFormulaire(bool $isEditMode, QCM $qcm = null)
{
  // var_dump($isEditMode);
  // var_dump($qcm);

  $modification_intitule = function ($type) {
    global $isEditMode;
    $value = "";

    if ($isEditMode && $type === "titre") {
      $value = "Mofication QCM";
    } else if (!$isEditMode && $type === "titre") {
      $value = "Création QCM";
    } else if ($isEditMode && $type === "btn") {
      $value = "'Modifier le QCM'";
    } else if (!$isEditMode && $type === "btn") {
      $value = "'Créer le QCM'";
    }
    return $value;
  }


?>

  <head>
    <?php infoHead('Créer ou éditer un QCM', 'Créer ou éditer un cours', '/views/pages/qcm/editer/editer.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
  </head>

  <body>
    <div id="mainContainer">
      <header>
        <?php createrNavbar(); ?>
      </header>
      <main class="qcmCreation-page">
        <form class="qcmCreation-page-form" action="<?php echo $qcm ? ('/qcm/editer?id=' . $qcm->getId()) : '/qcm/editer'  ?>" class="qcm-container-form" method="post" enctype="multipart/form-data">
          <!-- CONTAINER DE GAUCHE -->
          <div class="qcm-container">
            <div class="qcm-container-structure">
              <!-- TITRE -->
              <h2 class="qcm-container-titre"><?php echo $modification_intitule('titre'); ?></h2>
              <div class="parametre-message-container">
                <?php createMessage(); ?>
              </div>

              <!-- TITRE CONTAINER -->
              <div class="form-container-input qcm-container-titre-container">
                <label for="input-titre">Titre du qcm</label>
                <input required class="input l" type="text" name="titre" id="input-titre" placeholder="Titre du qcm">
              </div>

              <!-- CATEGORIE CONTAINER-->
              <div class="form-container-input qcm-container-categorie-container">
                <label for="input-cat">Catégorie</label>
                <input required type="text" class="input l" id="input-cat" name="categorie" placeholder="Catégorie du qcm">
              </div>

              <!-- DESCRIPTION CONTAINER -->
              <div class="form-container-input qcm-container-description-container">
                <label for="description-area">Description</label>
                <textarea required name="description" id="description-area" placeholder="Description du qcm"></textarea>
              </div>
              <!-- NEW FICHIER -->
              <div class="form-container-input qcm-container-fichier-container">
                <label for="input-fichier" class="label-input-file">Fichier XML</label>
                <input type="file" name="xml" id="input-fichier" accept="application/xml">
              </div>


              <!-- BOUTON SUBMIT -->
              <input type="submit" class="default m" id="submit-btn" value=<?php echo $modification_intitule('btn') ?>>

              <hr>

              <div class="delete-qcm-container">
                <label for="btn-delete">Supprimer le QCM</label>
                <a href="#"><input class="default s" type="button" id="btn-delete" value="Supprimer"></a>
              </div>
            </div>
          </div>

          <!-- CONTAINER DE DROITE -->
          <div class="cours-recommande-container">
            <div class="cours-recommande-container-structure">
              <h2 class="cours-recommande-container-titre">Cours recommandés</h2>

              <div class="cours-recomande-container-input-contaienr">

                <div class="cours-recommande-list">
                  <?php

                  //Si mode édition
                  if ($qcm && $isEditMode) {
                    $list_cours_recommande = $qcm->getAllCoursRecommandes();
                    for ($i = 0; $i < count($list_cours_recommande); $i++) {
                      $cours_recommande = $list_cours_recommande[$i]->getCours();
                    
                    echo "
                    <div class='cours-recomande-list-item'>
                      <label for='input-id-1'>Entre</label>
                    </div>
                    ";
                    
                    }
                  } else { //Mode création

                  }
                  echo "<input type='hidden' name='nbCoursRecommandes'>";
                  ?>
                </div>

                <input type="button" class="default s" id='submit-btn-recommandation' value='Ajouter une recommandation'>
              </div>
            </div>

          </div>
        </form>

      </main>
    </div>
    <?php createFooter(); ?>

  </body>
<?php
}
