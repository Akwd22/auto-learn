<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>

<html>

<?php
function afficherCours($cours)
{
?>

    <head>
        <?php infoHead('Cours', 'Cours', '/views/pages/cours/cours.css'); ?>
        <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
        <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
    </head>

    <body>
        <div id="mainContainer">
            <header>
                <?php createrNavbar(); ?>
            </header>
            <main class="content">

                <?php createMessage(); ?>

                <div id="topDiv">

                    <div id="imgDiv">
                        <?php
                        if ($cours->getImageUrl()) {
                            $urlImg = UPLOADS_COURS_IMGS_URL . $cours->getImageUrl();
                        } else {
                            $urlImg = DEFAULT_COURS_IMG;
                        }

                        $urlImg = htmlspecialchars($urlImg);
                        ?>
                        <img id="img" src="<?php echo $urlImg ?>">
                    </div>

                    <div id="infoDiv">
                        <div id="leftInfoDiv">
                            <h1 id="titleCours"><?php echo htmlspecialchars($cours->getTitre()) . ' – '; ?></h1>
                            <?php
                            $idNiveau = $cours->getNiveauRecommande();

                            $niveau = EnumNiveauCours::getFriendlyNames()[$idNiveau];
                            $niveauClass = "niveau-$idNiveau";

                            $niveau = htmlspecialchars($niveau);
                            $niveauClass = htmlspecialchars($niveauClass);

                            echo "<p class='niveauCours $niveauClass'>$niveau</p>";
                            ?>
                            <p id="descriptionCours"><?php echo htmlspecialchars($cours->getDescription()); ?>
                            <p>
                        </div>

                        <div id="rightInfoDiv">
                            <p id="timeCours">Environ <?php echo htmlspecialchars($cours->getTempsMoyen()); ?> heures de
                                <?php
                                $type = 'lecture';

                                if ($cours instanceof CoursVideo) {
                                    $type = 'vidéo';
                                }

                                echo $type; ?>
                            </p>
                            <p id="dateCours">Date de création : <?php echo htmlspecialchars($cours->getDateCreation()->format('d/m/Y')); ?> </p>
                            <div id="divEdit">
                                <?php
                                $visible = 'invisible';

                                if (SessionManagement::isAdmin()) {
                                    $visible = 'visible';
                                }
                                ?>
                                <input class="default s <?php echo $visible ?>" id="edit" type="button" name="edit" value="Modifier le cours" onclick="window.location.href = '/cours/editer?id=<?php echo htmlspecialchars($cours->getId()); ?>'">
                            </div>
                            <div id="divMark">
                                <?php
                                $isMark = null;
                                if (SessionManagement::getUser()->getCoursTentesByCoursId($cours->getId()) != null && SessionManagement::getUser()->getCoursTentesByCoursId($cours->getId())->getIsTermine()) {
                                    $isMark = "non-";
                                }
                                ?>

                                <input class="default s" id="mark" type="button" name="mark" value="Marquer comme <?php echo $isMark; ?>terminé" onclick="window.location.href = '/cours/marquer?id=<?php echo htmlspecialchars($cours->getId()); ?>'">
                            </div>

                        </div>
                    </div>

                </div>

                <div id="bottomDiv">

                    <?php if ($cours instanceof CoursTexte) { ?>
                        <embed src="<?php echo htmlspecialchars(UPLOADS_COURS_DOCS_URL . $cours->getFichierUrl()); ?>" width=100% height=1000 type='application/pdf' />
                    <?php } ?>

                    <?php if ($cours instanceof CoursVideo) { ?>

                        <div id="divVideo">
                            <iframe id="iframeVideo" width="100%" height="100%" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                        <div id="divLinksVideo">
                            <?php
                            for ($i = 0; $i < count($cours->getVideosUrl()); $i++) {
                                $num = $i + 1;
                                echo "<input class=\"urlButton\" id=\"urlButton" . $i . "\" type=\"button\" name=\"urlButton" . $i . "\" value=\"Vidéo " . $num . "\" onClick=\"addSrc('" . htmlspecialchars($cours->getVideosUrl()[$i]) . "');\">";
                            }
                            ?>
                        </div>

                    <?php } ?>
                </div>

            </main>
        </div>
        <?php createFooter(); ?>

        <script src="../views/pages/cours/cours.js"></script>
        <script>
            <?php if ($cours instanceof CoursVideo) {
                echo "addSrc('" . htmlspecialchars($cours->getVideosUrl()[0]) . "');";
            } ?>
        </script>
    </body>
<?php } ?>