<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/radio/radio.php';
require 'views/components/message/message.php';

/**
 * Afficher le formulaire d'édition d'un cours.
 * @param boolean $isEditMode Formulaire est-il en mode d'édition d'un cours existant ?
 * @param CoursTexte|CoursVideo|null $cours Cours à éditer, sinon `null` si en mode création.
 * @return void
 */
function afficherVue(bool $isEditMode, Cours $cours = null)
{


    // PDF CONTAINER
    // Cette div doit s'afficher uniquement quand nous sommes en mode creation, sinon nous sommes en mode edition
    $pdf_container = function () {
        global $isEditMode; //On importe la variable $isEditMode donnée en parametre dans le scope de la fonction
        if ($isEditMode === false) { //mode create
            return <<<HTML
                <div class="creation-container-pdf-container">
                    <label for="pdfFile" id='pdf-file'>Fichier PDF</label>
                    <input type="file" name="fichPdf" id="pdfFile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                </div>
HTML;
        }
    };

    // FONCTION POUR REMPLIR LES CHAMPS EXISTANTS SI MODIFICATIONS
    $handleForm_isEditMode = function ($type) {
        global $isEditMode;
        global $cours;

        $value = "";
        if ($isEditMode and $type === "titre")
            $value = $cours->getTitre();
        else if ($isEditMode and $type === "tempsMoyen")
            $value = $cours->getTempsMoyen();
        else if ($isEditMode and $type === "niveauRecommandé")
            $value = $cours->getNiveauRecommande();
        else if ($isEditMode and $type == "description")
            $value = $cours->getDescription();

        return $value;
    };

    // Ecriture des bons mots suivant l'état de $isEditMode
    $modification_creation = function ($type) {
        global $isEditMode;
        $value = "";

        if ($isEditMode === true and $type === "titre") { //Si mode édition et titre 
            $value = "Modification du cours";
        } else if ($isEditMode === false and $type === "titre") { //Si mode création et titre 
            $value = "Création d'un cours";
        } else if ($isEditMode === true and $type === "btn") { //Si mode édition et boutton 
            $value = "'Modifier le cours'";
        } else if ($isEditMode === false and $type === "btn") { //Si mode création et boutton 
            $value = "'Créer le cours'";
        }

        return $value;
    };

?>

    <head>
        <?php infoHead('Éditer un cours', 'Éditer un cours', '/views/pages/cours/creation-modification/creation-modification.css'); ?>
        <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
        <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
    </head>

    <body>
        <div id="mainContainer">
            <header>
                <?php createrNavbar(); ?>
            </header>
            <main class="coursCreation-page">
                <form action="<?php echo $cours ? ('/cours/editer?id=' . $cours->getId()) : '/cours/editer'  ?>" class="creation-container-form" method="post" enctype="multipart/form-data">
                    <div class="creation-container">
                        <div class="creation-container-form-structure">
                            <!-- TITRE -->
                            <h2 class="creation-container-titre"><?php echo $modification_creation("titre") ?></h2>
                            <div class="parametre-message-container">
                                <?php createMessage(); ?>
                            </div>
                            <!-- TITRE CONTAINER -->
                            <div class="form-container-input creation-container-titre-container">
                                <label for="input-titre">Titre du cours</label>
                                <input required class="input l" type="text" name="titre" id="input-titre" placeholder='Titre du cours' value="<?php echo $handleForm_isEditMode("titre"); ?>">
                            </div>

                            <!-- TEMPS MOYENS -->
                            <div class="form-container-input creation-container-temps-container">
                                <label for="temps-input">Temps moyen de complétion</label>
                                <input required class="input l" type="text" name='tempsMoyen' id="temps-input" placeholder='Durée du cours (en heures)' value="<?php echo $handleForm_isEditMode("tempsMoyen"); ?>">
                            </div>

                            <!-- NIVEAU RECOMMANDÉ -->
                            <div class="form-container-input creation-container-niveau-container">
                                <label for="niveau-select">Niveau recommandé</label>
                                <select name="niveauRecommande" id="niveau-select" required>
                                    <?php
                                    $arr = EnumNiveauCours::getFriendlyNames();

                                    foreach ($arr as $niv => $nom) {
                                        $selected = ($cours && $cours->getNiveauRecommande() === $niv) ? "selected" : "";
                                        echo "<option value='$niv' $selected>$nom</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                            <!-- CATEGORIE COURS -->
                            <div class="form-container-input creation-container-niveau-container">
                                <label for="niveau-cat">Catégorie</label>
                                <select name="categorie" id="cat-select" required>
                                    <?php
                                    $arr = EnumCategorie::getFriendlyNames();

                                    foreach ($arr as $cat => $nom) {
                                        $selected = ($cours && $cours->getCategorie() === $cat) ? "selected" : "";
                                        echo "<option value='$cat' $selected>$nom</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="form-container-input creation-container-description-container">
                                <textarea required name="description" id="description-area" placeholder="Description du cours"><?php echo $handleForm_isEditMode("description"); ?></textarea>
                            </div>
                            <!-- NEW IMAGE -->

                            <div class="form-container-input creation-container-image-container">
                                <label for="image" id='new-image'>Nouvelle image</label>
                                <input type="file" name="image" id="image" accept="image/png, image/jpeg">
                            </div>

                            <!-- FORMAT -->
                            <div class="creation-container-format-container">
                                <label for="radio-format">Format du cours</label>
                                <?php createRadio('radio-format-texte', 'format', 'Texte', '1', 'm', ($isEditMode) ? 'disabled' : 'enabled', ($cours ? ($cours::FORMAT === EnumFormatCours::TEXTE ? "checked" : "") : "checked")); ?>
                                <?php createRadio('radio-format-video', 'format', 'Vidéo', '2', 'm', ($isEditMode) ? 'disabled' : 'enabled', ($cours ? ($cours::FORMAT === EnumFormatCours::VIDEO ? "checked" : "") : "")); ?>
                            </div>

                            <!-- FICHIER PDF -->
                            <!-- <?php echo $pdf_container() ?> -->
                            <div class="creation-container-pdf-container">
                                <label for="pdfFile" id='pdf-file'>Fichier PDF</label>
                                <input type="file" name="fichPdf" id="pdfFile" accept="application/pdf">
                            </div>

                            <!-- BOUTON SUBMIT -->
                            <input class="default m" type="submit" id="submit-btn" value=<?php echo $modification_creation('btn') ?>>

                            <hr>

                            <div class="delete-container-form">
                                <label for="btn-delete">Supprimer le cours</label>
                                <a href=<?php echo $isEditMode ? '/cours/supprimer?id=' . $cours->getId() : "#"; ?>><input class="default s" type="button" id="btn-delete" value="Supprimer"></a>
                            </div>
                        </div>

                        <!-- CONTAINER DES LIENS VERS LES VIDEOS -->
                        <div class='lien-container'>
                            <div class="lien-container-form">
                                <h2 class="creation-container-titre">Liens vidéo de la formation</h2>

                                <div class="lien-container-lien-container">

                                    <div class="lien-container-list-lien">
                                        <?php
                                        if ($cours && $cours::FORMAT === EnumFormatCours::VIDEO) {
                                            $nbLiensValue = count($cours->getVideosUrl());

                                            foreach ($cours->getVideosUrl() as $n => $url) {
                                                $n++;
                                                echo "<div class='lien-container-input-container'>";
                                                echo "<label for='input-lien-{$n}'>$n</label>";
                                                echo "<input class='input m' type='text' name='lien{$n}' id='input-lien-{$n}' placeholder='Lien de la vidéo YouTube' value='{$url}'>";
                                                echo "</div>";
                                            }
                                        } else { // Mode creation on importe une div par défaut
                                            $nbLiensValue = 1;

                                            echo "<div class='lien-container-input-container'>";
                                            echo "<label for='input-lien-{$nbLiensValue}'>$nbLiensValue</label>";
                                            echo "<input class='input m' type='text' name='lien{$nbLiensValue}' id='input-lien-{$nbLiensValue}' placeholder='Lien de la vidéo YouTube'>";
                                            echo "</div>";
                                        }

                                        echo "<input class='lien-container-hidden' type='hidden' name='nbLiens' value={$nbLiensValue}>";
                                        ?>
                                    </div>


                                    <!-- BOUTON D'AJOUT -->
                                    <input class="default s" type="button" id="submit-btn-lien" value='Ajouter un lien de vidéo'>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
        <?php createFooter(); ?>
        <script src="../views/pages/cours/creation-modification/creation-modification.js"></script>
    </body>
<?php
}
