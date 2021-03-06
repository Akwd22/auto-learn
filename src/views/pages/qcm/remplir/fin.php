<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>
<?php require 'views/components/progressBar/progressBar.php'; ?>

<html>

<?php
/**
 * Afficher la page de fin d'un QCM.
 * @param QCM $qcm QCM concerné.
 * @param TentativeQCM $tentative Tentative du QCM concerné (contient les infos. sur la progression).
 * @return void
 */
function afficherQcmFin(QCM $qcm, TentativeQCM $tentative)
{
    $titre = htmlspecialchars($qcm->getTitre());
    $coursRecommande = $tentative->getCoursRecommande() ? $tentative->getCoursRecommande()->getCours() : null;
?>

    <head>
        <?php infoHead('Résultat du QCM', 'Résultat du QCM', '/views/pages/qcm/remplir/fin.css'); ?>
        <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
        <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
    </head>

    <body>
        <div id="mainContainer">
            <header>
                <?php createrNavbar(); ?>
            </header>

            <main class="content">

                <div id="centerDiv">
                    <div id="topDiv">

                        <div id="topDivInfo">
                            <p id="titleQcm"><?php echo $titre; ?></p>
                            <p id="date">Date de complétion : <?php echo $tentative->getDateTermine()->format('d/m/Y'); ?></p>
                        </div>

                        <div id="topDivButton">
                            <?php
                            $colorResult = null;
                            if ($tentative->getMoy() < 10) {
                                $colorResult = 'red';
                            } elseif ($tentative->getMoy() == 10) {
                                $colorResult = 'orange';
                            } elseif ($tentative->getMoy() > 10) {
                                $colorResult = 'green';
                            }
                            $moy = number_format($tentative->getMoy(), 2);
                            ?>
                            <p class="result <?php echo $colorResult; ?>"><?php echo $moy . "/20"; ?></p>
                            <form method="POST">
                                <input class="default s" type="submit" name="restart" value="Recommencer">
                            </form>
                        </div>

                    </div>

                    <?php if ($coursRecommande) { ?>
                        <div id="bottomDiv">
                            <p id="recommendedCours"><?php echo htmlspecialchars($coursRecommande->getTitre()); ?></p>
                            <div id="divButtonRecommendedCours">
                                <input class="default s" id="buttonRecommendedCours" type="button" name="buttonRecommendedCours" value="Voir le cours" onclick="window.location.href = '/cours?id=<?php echo htmlspecialchars($coursRecommande->getId()); ?>'">
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </main>
        </div>
        <?php createFooter(); ?>

    </body>


</html>
<?php } ?>