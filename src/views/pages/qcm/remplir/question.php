<?php

/**
 * Afficher la page de fin d'un QCM.
 * @param QCM $qcm QCM concerné.
 * @param QuestionChoix|QuestionSaisie $question Question actuelle.
 * @param TentativeQCM $tentative Tentative du QCM concerné (contient les infos. sur la progression).
 * @return void
 */
function afficherQcmQuestion(QCM $qcm, QuestionQCM $question, TentativeQCM $tentative)
{
  $choix = function () use (&$question) {
    foreach ($question->getAllChoix() as $choix)
    {
      $idChoix = $choix->getId();

      if ($question->getIsMultiple())
      {
        echo "<input type=checkbox name=choix-$idChoix id=choix-$idChoix>";
      }
      else
      {
        echo "<input type=radio name=choix id=choix-$idChoix value=$idChoix>";
        
      }

      echo "<label for=choix-$idChoix>" . $choix->getIntitule() . "</label>";
      echo "<br>";
    }
  };

  $saisie = function () use (&$question) {
    $placeholder = $question->getPlaceHolder();
    echo "<input type=text name=response placeholder='$placeholder'>";
  };

?>
  <h1>Page de question du QCM : <?php echo $tentative->getNumQuestionCourante() . " sur " . $qcm->nbQuestions() ?> questions</h1>

  <form method="POST">
    <div>
      <h2>Question : <?php echo $question->getQuestion() ?></h2>
      <?php
      if ($question::TYPE === EnumTypeQuestion::CHOIX)
        $choix();
      else
        $saisie();
      ?>
    </div>

    <input type="submit" name="next" value="Question suivante">
    <input type="submit" name="skip" value="Ignorer la question">
    <input type="submit" name="restart" value="Recommencer le QCM">
  </form>
<?php

  var_dump($qcm);
  var_dump($question);
  var_dump($tentative);
}
