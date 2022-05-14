<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>

<html>

<?php
/**
 * Afficher la liste filtrées des QCM.
 * @param array $qcm Liste des QCM.
 * @param string $lastSearch Dernière recherche dans la barre de recherche.
 * @param int $selectedCat Dernière catégorie choisie.
 * @param bool $completedOnly Faut-il afficher uniquement les QCM terminés ?
 * @return void
 */
function afficherQcm(array $qcm, string $lastSearch = "", int $selectedCat = EnumCategorie::AUCUNE, bool $completedOnly = false)
{
    $lastSearch = htmlspecialchars($lastSearch);
?>

    <head>
        <?php infoHead('Rechercher des tests', 'Rechercher des tests', '/views/pages/qcm/rechercher/rechercher.css'); ?>
        <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
        <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
    </head>

    <body>
        <div id="mainContainer">
            <header>
                <?php createrNavbar(); ?>
            </header>

            <main class="content">



                <form method="GET">
                    <div id="leftDiv">

                        <div id="divCreate">
                            <?php
                            $visible = 'invisible';
                            if (SessionManagement::isAdmin()) {
                                $visible = 'visible';
                            }
                            ?>
                            <input class="default s <?php echo $visible ?>" id="create" type="button" name="create" value="Créer un QCM" onclick="window.location.href = '/qcm/editer'">
                        </div>

                        <div id="divForm">
                            <!--formulaire de gauche-->

                            <p class="titlesForm">État QCM</p>
                            <div class="divCheckbox" id="divCheckbox">
                                <?php
                                $completedStatut = 'unchecked';
                                if ($completedOnly) {
                                    $completedStatut = 'checked';
                                }
                                createCheckbox('showCompleted', 'showCompleted', 'QCM terminés', 'm', '', 'enabled', $completedStatut)
                                ?>
                            </div>

                            <p class="titlesForm" id="titleFormCat">Catégories</p>
                            <select class="select m full-width" name="categorie" id="categorie">
                                <?php

                                $arr = EnumCategorie::getFriendlyNames();
                                foreach ($arr as $cat => $nom) {
                                    $status = '';
                                    if ($cat == $selectedCat) {
                                        $status = 'selected';
                                    }

                                    $cat = htmlspecialchars($cat);
                                    $nom = htmlspecialchars($nom);

                                    echo "<option value='$cat' $status>$nom</option>";
                                }

                                ?>
                            </select>
                            <div id="gridButton">
                                <input class="default s" id="apply" type="submit" name="apply" value="Appliquer les filtres">
                                <input class="outline s" id="reset" type="submit" name="reset" value="Réinitialiser les filtres">
                            </div>
                            <!--fin formulaire de gauche-->
                        </div>
                    </div>

                    <div id="rightDiv">
                        <!--formulaire de droite-->
                        <div id="labelSearchDiv">
                            <label id="labelSearch" for="titre" name="titre">Les tests de connaissances</label>
                        </div>
                        <input class="input l" type="search" id="titre" name="titre" value="<?php echo $lastSearch; ?>" placeholder="Rechercher un QCM">
                        <!--fin formulaire de droite-->

                        <div id="divListQcm">

                            <?php
                            $arr = EnumCategorie::getFriendlyNames();
                            for ($i = 0; $i < count($qcm); $i++) {
                                $tenta = SessionManagement::getUser()->getQcmTentesByQcmId($qcm[$i]->getId());
                                $qcmId = htmlspecialchars($qcm[$i]->getId());
                                $titre = htmlspecialchars($qcm[$i]->getTitre());
                                $descr = htmlspecialchars($qcm[$i]->getDescription());
                                $cat   = htmlspecialchars($arr[$qcm[$i]->getCategorie()]);

                                echo "<a href=\"/qcm?id=" . $qcmId . "\">";
                                echo "<div class=\"containerQcm\">";


                                echo "<div class=\"leftDivQcm\">";
                                echo "<p class=\"titleQcm\">" . $titre . "</p>";
                                echo "<p class=\"descriptionQcm\">" . $descr . "</p>";
                                echo "</div>";

                                echo "<div class=\"rightDivQcm\">";
                                echo "<p class=\"catQcm\">" . $cat . "</p>";
                                if ($tenta && $tenta->getIsTermine()) echo "<p class='noteQcm'>" . number_format($tenta->getMoy(), 2) . "/20</p>";
                                echo "</div>";


                                echo "</div>";
                                echo "</a>";
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