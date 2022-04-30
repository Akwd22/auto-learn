<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>

<html>

            <?php
            function afficherCours(array $cours, string $lastSearch = null, string $selectedRadio = null, int $selectedCat = EnumCategorie::AUCUNE)
            {
            ?>

<head>
    <?php infoHead('Cours', 'Liste des cours', '/views/pages/cours/rechercher/rechercher.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
</head>

<body>
    <div id="mainContainer">
        <header>
            <?php createrNavbar(); ?>
        </header>

        <main class="content">
            


                <form method="POST">
                    <div id="leftDiv">

                        <div id="divCreate">
                            <?php
                                $visible='invisible';
                                if (SessionManagement::isAdmin()){$visible='visible';}
                            ?>
                            <input class="default s <?php echo $visible?>" id="create" type="button" name="create" value="Créer un cours" onclick="window.location.href = '/cours/editer'">
                        </div>    

                        <div id="divForm">
                            <!--formulaire de gauche-->

                            <p class="titlesForm">Format cours</p>
                            <div class="divRadios" id="radio1">
                                <?php
                                $textStatus = 'unchecked';
                                if ($selectedRadio == 'TEXTE') {
                                    $textStatus = 'checked';
                                }
                                createRadio('redioCoursText', 'radioCours', 'Texte', 'TEXTE', 'm', 'enabled', $textStatus);
                                ?>
                            </div>
                            <div class="divRadios" id="radio2">
                                <?php
                                $videoStatus = 'unchecked';
                                if ($selectedRadio == 'VIDEO') {
                                    $videoStatus = 'checked';
                                }
                                createRadio('radioCoursVideo', 'radioCours', 'Video', 'VIDEO', 'm', 'enabled', $videoStatus);
                                ?>
                            </div>

                            <p class="titlesForm" id="titleFormCat">Catégories</p>
                            <select class="select m" name="selectCat" id="selectCat">
                                <?php
                                
                                $arr = EnumCategorie::getFriendlyNames();
                                foreach ($arr as $cat => $nom) {
                                    $status='';
                                    if($cat==$selectedCat){$status='selected';}
                                    echo "<option value='$cat' $status>$nom</option>"; 
                                }

                                ?>
                            </select>
                            <input class="outline s" id="reset" type="submit" name="reset" value="Réinitialiser les filtres">
                            <input class="default s" id="sub" type="submit" name="sub" value="Appliquer les filtres">
                            <!--fin formulaire de gauche-->
                        </div>
                    </div>

                    <div id="rightDiv">
                        <!--formulaire de droite-->
                        <div id="labelSearchDiv">
                            <label id="labelSearch" for="site-search" name="site-search">Les cours</label>
                        </div>
                        <input class="input l" type="search" id="site-search" name="site-search" value="<?php echo $lastSearch; ?>" placeholder="Rechercher un cours">
                        <!--fin formulaire de droite-->

                        <div id="divGrid">

                            <?php 
                            for ($i = 0; $i < count($cours); $i++) {

                                echo "<div class=\"containerCours\">";
                                echo "<a href=\"/cours/affichage?id=" . $cours[$i]->getId() . "\">";

                                $urlImg = '';

                                if ($cours[$i]->getImageUrl()) {
                                    $urlImg = UPLOADS_COURS_IMGS_URL . $cours[$i]->getImageUrl();
                                } else {
                                    $urlImg = DEFAULT_COURS_IMG;
                                }

                                echo "<img class=\"imgCours\" src=\"" . $urlImg . "\">";

                                

                                echo "<p class=\"titleCours\">" . $cours[$i]->getTitre() . "</p>";
                                echo "<p class=\"descriptionCours\">" . $cours[$i]->getDescription() . "</p>";

                                echo "</a>";
                                echo "</div>";
                            }

                            ?>

                        </div>
                    </div>

                </form>


    </div>




    </main>
    </div>
    <?php createFooter(); ?>

</body>


<?php } ?>