<?php

/**
 * Afficher la page de fin d'un QCM.
 * @param QCM $qcm QCM concerné.
 * @param TentativeQCM $tentative Tentative du QCM concerné (contient les infos. sur la progression).
 * @return void
 */
function afficherQcmFin(QCM $qcm, TentativeQCM $tentative)
{
  $coursRecommande = $tentative->getCoursRecommande() ? $tentative->getCoursRecommande()->getCours() : null;

?>
  <h1>Page de fin du QCM : Moyenne <?php echo $tentative->getMoy() ?> / 20</h1>

  <form method="POST">
    <input type="submit" name="restart" value="Recommencer le QCM">
  </form>

  <?php
  if ($coursRecommande) {
    $id    = $coursRecommande->getId();
    $titre = $coursRecommande->getTitre();
    echo "<h2>Cours recommandé : <a href='/cours?id=$id'>$titre</a></h2>";
  }
  ?>
<?php

  var_dump($qcm);
  var_dump($tentative);
}
