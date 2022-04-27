<?php

/**
 * Afficher la page de début d'un QCM.
 * @param QCM $qcm QCM concerné.
 * @return void
 */
function afficherQcmDebut(QCM $qcm)
{
?>
  <h1>Page de début du QCM : <?php echo $qcm->getTitre() ?></h1>

  <form method="POST">
    <input type="submit" name="start" value="Commencer le QCM">
  </form>
<?php

  var_dump($qcm);
}
