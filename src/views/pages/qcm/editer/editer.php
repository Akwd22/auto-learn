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

  $handleForm_isEditMode = function ($type) {
    global $isEditMode;
    global $qcm;

    $value = '';
    if ($isEditMode and $type === "titre")
      $value = $qcm->getTitre();
    else if ($isEditMode and $type === "description")
      $value = $qcm->getDescription();

    return $value;
  };

  $modification_intitule = function ($type) {
    global $isEditMode;
    $value = "";

    if ($isEditMode && $type === "titre") {
      $value = "Modification QCM";
    } else if (!$isEditMode && $type === "titre") {
      $value = "Création QCM";
    } else if ($isEditMode && $type === "btn") {
      $value = "'Modifier le QCM'";
    } else if (!$isEditMode && $type === "btn") {
      $value = "'Créer le QCM'";
    }
    return $value;
  };

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
        <form class="qcmCreation-page-form" action="<?php echo $qcm ? ('/qcm/edition?id=' . $qcm->getId()) : '/qcm/edition'  ?>" class="qcm-container-form" method="post" enctype="multipart/form-data">
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
                <label for="input-titre">Titre du QCM</label>
                <input required class="input l" type="text" name="titre" id="input-titre" placeholder="Titre du QCM" value=<?php echo $handleForm_isEditMode('titre') ?>>
              </div>

              <!-- CATEGORIE CONTAINER-->
              <div class="form-container-input qcm-container-categorie-container">
                <label for="input-cat">Catégorie</label>
                <select name="categorie" id='cat-select' class="select m " required>
                  <?php
                  $arr = EnumCategorie::getFriendlyNames();

                  foreach ($arr as $cat => $nom) {
                    $selected = ($qcm && $qcm->getCategorie() === $cat) ? "selected" : "";
                    echo "<option value='$cat' $selected>$nom</option>";
                  }
                  ?>
                </select>
              </div>

              <!-- DESCRIPTION CONTAINER -->
              <div class="form-container-input qcm-container-description-container">
                <label for="description-area">Description</label>
                <textarea required name="description" id="description-area" placeholder="Description du QCM"><?php echo $handleForm_isEditMode('description') ?></textarea>
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
                <a href=<?php echo $isEditMode ? '/qcm/supprimer?id=' . $qcm->getId() : "#" ?>><input class="default s" type="button" id="btn-delete" value="Supprimer"></a>
              </div>
            </div>
          </div>

          <!-- CONTAINER DE DROITE -->
          <div class="cours-recommande-container">
            <div class="cours-recommande-container-structure">
              <h2 class="cours-recommande-container-titre">Cours recommandés</h2>

              <div class="cours-recomande-container-input-contaienr">

                <div class="cours-recommande-list">

                  <datalist id="liste-cours"></datalist>

                  <?php

                  //Si mode édition
                  if ($qcm && $isEditMode) {
                    $list_cours_recommande = $qcm->getAllCoursRecommandes();
                    $nb_cours = count($list_cours_recommande);

                    foreach ($list_cours_recommande as $i => $reco) {
                      $i++;
                      $cours_recommande = $reco->getCours();
                      $id_cours_recommande = $cours_recommande->getId();
                      $moyenne_min = $reco->getMoyMin();
                      $moyenne_max = $reco->getMoyMax();

                      echo "
                    <div class='cours-recomande-list-item'>
                      <label for='min-{$i}'>Entre</label>
                      <input min='0' max='20' placeholder='0' class='input m input-moyenne' type='number' name='min-{$i}' value='{$moyenne_min}'>
                      <label for='max-{$i}'>et</label>
                      <input min='0' max='20' placeholder='20'class='input m input-moyenne' type='number' name='max-{$i}' value='{$moyenne_max}'>
                      <label for='id-{$i}'>:</label>
                      <input class='input m input-id' type='text' name='id-{$i}' list='liste-cours' placeholder='Identifiant du cours' value='{$id_cours_recommande}'>
                    </div>
                    ";
                    }
                  } else { //Mode création
                    $nb_cours = 1;
                    echo "
                    <div class='cours-recomande-list-item'>
                    <label for='min-{$nb_cours}'>Entre</label>
                    <input min='0' max='20' placeholder='0' class='input m input-moyenne' type='number' name='min-{$nb_cours}' >
                    <label for='max-{$nb_cours}'>et</label>
                    <input min='0' max='20' placeholder='20'class='input m input-moyenne' type='number' name='max-{$nb_cours}' >
                    <label for='id-{$nb_cours}'>:</label>
                    <input class='input m input-id' type='text' name='id-{$nb_cours}' list='liste-cours' placeholder='Identifiant du cours' >
                    </div>
                    ";
                  }
                  echo "<input class='item-container-hidden' type='hidden' name='nbCoursRecommandes' value={$nb_cours}>";
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

    <script src="../views/pages/qcm/editer/editer.js"></script>
  </body>
<?php
}
