<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>

<html>

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
            <?php
            function afficherCours(array $cours, string $lastSearch, string $selectedRadio, string $selectedCat)
            {
            ?>


                <form method="POST">
                    <div id="leftDiv">
                        <div id="divForm">
                            <!--formulaire de gauche-->
                            <p class="titlesForm">Format cours</p>
                            <div class="divRadios" id="radio1">
                                <?php
                                $textStatus = 'unchecked';
                                if ($selectedRadio == 'Texte') {
                                    $textStatus = 'checked';
                                }
                                createRadio('redioCoursText', 'radioCours', 'Texte', 'Texte', 'm', 'enabled', $textStatus);
                                ?>
                            </div>
                            <div class="divRadios" id="radio2">
                                <?php
                                $videoStatus = 'unchecked';
                                if ($selectedRadio == 'Video') {
                                    $videoStatus = 'checked';
                                }
                                createRadio('radioCoursVideo', 'radioCours', 'Video', 'Video', 'm', 'enabled', $videoStatus);
                                ?>
                            </div>

                            <p class="titlesForm" id="titleFormCat">Catégories</p>
                            <select class="select m" name="selectCat" id="selectCat">
                                <?php
                                $defaultStatus = '';
                                if ($selectedCat == '') {
                                    $defaultStatus = 'selected';
                                }
                                $cppStatus = '';
                                if ($selectedCat == 'cpp') {
                                    $cppStatus = 'selected';
                                }
                                $javascriptStatus = '';
                                if ($selectedCat == 'javascript') {
                                    $javascriptStatus = 'selected';
                                }
                                ?>
                                <option value="" <?php echo $defaultStatus; ?>>Aucune catégorie</option>
                                <option value="cpp" <?php echo $cppStatus; ?>>C++</option>
                                <option value="javascript" <?php echo $javascriptStatus; ?>>Javascript</option>
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

                        <div id="divDisplay">

                            <?php
                            for ($i = 0; $i < count($cours); $i++) {

                                echo "<div class=\"containerFlexCours\">";
                                echo "<div class=\"containerCours\">";
                                echo   "<a href=\"/cours?id=" . $cours[$i]->getId() . "\">";

                                $urlImg = '';
                                if ($cours[$i]->getImageUrl() != '') {
                                    //à revoir
                                    //$urlImg=UPLOADS_COURS_URL . $cours[$i]->getImageUrl();
                                    $urlImg = 'assets\img\profil\profil.png';
                                } else {
                                    $urlImg = 'assets\img\profil\profil.png';
                                }
                                echo "<img class=\"imgCours\" src=\"" . $urlImg . "\">";

                                echo "<p class=\"titleCours\">" . $cours[$i]->getTitre() . "</p>";
                                echo "<p class=\"descriptionCours\">" . $cours[$i]->getDescription() . "</p>";

                                echo "</a>";
                                echo "</div>";
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