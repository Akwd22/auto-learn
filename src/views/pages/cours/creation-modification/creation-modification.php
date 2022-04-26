<?php require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/radio/radio.php';
require 'views/components/message/message.php';


function afficherVue(bool $isEditMode, Cours $cours = null)
{

    // CONTAINER DE DROITE 
    //Il s'agit de la div qui contiens le lien des videos de formations si le cours est de format vidéo
    $isVideo = function () {
        global $cours; //On importe la variable $cours donnée en parametre dans le scope de la fonction
        if ($cours::FORMAT === EnumFormatCours::VIDEO) {
            return <<<HTML
            <div class='lien-container'>
                <form class="lien-container-form">
                </form>
            </div>
HTML;
        }
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
                    <form action="" class="creation-container-form">
                        <!-- FORMAT -->
                        <div class="creation-container-format-container">
                            <label for="radio-format">Format du cours</label>
                            <?php createRadio('radio-format-texte', 'radio-format', 'Texte', 'texte', 'm', 'enabled', ($cours::FORMAT === EnumFormatCours::TEXTE ? "checked" : "")); ?>
                            <?php createRadio('radio-format-video', 'radio-format', 'Vidéo', 'video', 'm', 'enabled', ($cours::FORMAT === EnumFormatCours::VIDEO ? "checked" : "")); ?>
                        </div>

                        <!-- FICHIER PDF -->
                        <div class="creation-container-pdf-container">
                            <label for="pdfFile" id='pdf-file'>Fichier PDF</label>
                            <input type="file" name="pdfFile" id="pdfFile">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                        </div>
                    </form>
                </div>

                <!-- CONTAINER DES LIENS VERS LES VIDEOS -->
                <?php echo $isVideo(); ?>
            </main>
        </div>
        <?php createFooter(); ?>
        <script src="../views/pages/cours/creation-modification/creation-modification.js"></script>
    </body>
<?php
}
