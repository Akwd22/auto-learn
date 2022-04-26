<?php require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/radio/radio.php';
require 'views/components/message/message.php';

function afficherVue(bool $isEditMode, Cours $cours = null)
{
    // PDF CONTAINER
    // Cette div doit s'afficher uniquement quand nous sommes en mode d'édition, sinon nous sommes en mode création
    $pdf_container = function () {
        global $isEditMode; //On importe la variable $isEditMode donnée en parametre dans le scope de la fonction
        if ($isEditMode === true) { //mode edition
            return <<<HTML
                <div class="creation-container-pdf-container">
                    <label for="pdfFile" id='pdf-file'>Fichier PDF</label>
                    <input type="file" name="pdfFile" id="pdfFile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                </div>
HTML;
        }
    };

    $modification_creation = function ($type) {
        global $isEditMode;
        $value = "";

        if ($isEditMode === true and $type === "titre") { //Si mode édition et titre 
            $value = "Modificationcours";
        } else if ($isEditMode === false and $type === "titre") { //Si mode création et titre 
            $value = "Création cours";
        } else if ($isEditMode === true and $type === "btn") { //Si mode édition et boutton 
            $value = "'Modifier le cours'";
        } else if ($isEditMode === false and $type === "btn") { //Si mode création et boutton 
            $value = "'Créer le cours's";
        }

        return $value;
    };

?>


    <head>
        <?php infoHead('Modifier son profil', 'Modifier son profil', '/views/pages/cours/creation-modification/creation-modification.css'); ?>
        <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
        <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
    </head>

    <body>
        <div id="mainContainer">
            <header>
                <?php createrNavbar(); ?>
            </header>
            <main class="coursCreation-page">
                <div class="creation-container">
                    <div class="creation-container-form-structure">
                        <form action="" class="creation-container-form">
                            <!-- TITRE -->
                            <h2 class="creation-container-titre"><?php echo $modification_creation("titre") ?></h2>

                            <!-- TITRE CONTAINER -->
                            <div class="form-container-input creation-container-titre-container">
                                <label for="input-titre">Titre du cours</label>
                                <input class="input l" type="text" name="titre" id="input-titre">
                            </div>

                            <!-- TEMPS MOYENS -->
                            <div class="form-container-input creation-container-temps-container">
                                <label for="temps-input">Temps moyen de complétion</label>
                                <input class="input l" type="text" name='tempsMoyen' id="temps-input">
                            </div>

                            <!-- NIVEAU RECOMMANDÉ -->
                            <div class="form-container-input creation-container-niveau-container">

                            </div>
                            <!-- DESCRIPTION -->
                            <div class="form-container-input creation-container-description-container">

                            </div>
                            <!-- NEW IMAGE -->

                            <div class="form-container-input creation-container-image-container">
                                <label for="image" id='new-image'>Nouvelle image</label>
                                <input type="file" name="image" id="image">
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                            </div>

                            <!-- FORMAT -->
                            <div class="creation-container-format-container">
                                <label for="radio-format">Format du cours</label>
                                <?php createRadio('radio-format-texte', 'radio-format', 'Texte', 'texte', 'm', 'enabled', ($cours::FORMAT === EnumFormatCours::TEXTE ? "checked" : "")); ?>
                                <?php createRadio('radio-format-video', 'radio-format', 'Vidéo', 'video', 'm', 'enabled', ($cours::FORMAT === EnumFormatCours::VIDEO ? "checked" : "")); ?>
                            </div>

                            <!-- FICHIER PDF -->
                            <?php echo $pdf_container() ?>

                            <!-- BOUTON SUBMIT -->
                            <input class="default m" type="submit" id="submit-btn" value=<?php echo $modification_creation('btn') ?>>

                            <hr>

                        </form>


                        <form action="" class="delete-container-form">
                            <label for="btn-delete">Supprimer le cours</label>
                            <input class="default s" type="submit" id="btn-delete" value="Supprimer">
                        </form>
                    </div>
                    
                    <!-- CONTAINER DES LIENS VERS LES VIDEOS -->
                    <div class='lien-container'>
                        <form class="lien-container-form">
                            video
                        </form>
                    </div>
                </div>
            </main>
        </div>
        <?php createFooter(); ?>
        <script src="../views/pages/cours/creation-modification/creation-modification.js"></script>
    </body>
<?php
}
