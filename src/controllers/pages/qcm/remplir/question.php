<?php
require_once("views/pages/qcm/remplir/question.php");

if (empty($_POST)) {
  showView();
}
else
{
  if (isset($_POST["restart"]))
  {
    handleRestartQcm();
  }
  else
  {
    if (isset($_POST["skip"])) $_POST = array();
    handleNextQuestionForm();
  }
}

function showView()
{
  global $qcm;
  global $tentative;
  global $question;

  afficherQcmQuestion($qcm, $question, $tentative);
}

function handleNextQuestionForm()
{
  global $qcm;
  global $tentative;
  global $tentaCRUD;
  global $question;

  if ($question::TYPE === EnumTypeQuestion::CHOIX)
  {
    $reponse = new ReponseChoix();

    foreach ($question->getAllChoix() as $choixQuestion)
    {
      $idChoix = $choixQuestion->getId();

      if ($question->getIsMultiple())
      {
        $isCoche = isset($_POST["choix-" . $idChoix]);
      }
      else
      {
        $isCoche = isset($_POST["choix"]) && $_POST["choix"] == $idChoix;
      }

      $choixReponse = new ChoixReponse($idChoix, $isCoche);
      $reponse->addChoix($choixReponse);
    }
  }
  else
  {
    $saisie = $_POST["response"];
    $reponse = new ReponseSaisie($saisie);
  }

  $tentative->questionSuivante($reponse);
  $tentaCRUD->updateTentativeQcm($tentative);

  redirect("/qcm", null, null, array("id" => $qcm->getId()));
}

function handleRestartQcm()
{
  global $qcm;
  global $tentative;
  global $tentaCRUD;

  $tentative->recommencer();
  $tentaCRUD->updateTentativeQcm($tentative);

  redirect("/qcm", null, null, array("id" => $qcm->getId()));
}