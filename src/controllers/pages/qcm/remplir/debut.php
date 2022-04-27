<?php
require_once("views/pages/qcm/remplir/debut.php");

if (empty($_POST)) {
  showView();
} else {
  handleForm();
}

function showView()
{
  global $qcm;

  afficherQcmDebut($qcm);
}

function handleForm()
{
  global $qcm;
  global $tentative;
  global $tentaCRUD;

  $tentative->commencer();
  $tentaCRUD->updateTentativeQcm($tentative);

  redirect("/qcm", null, null, array("id" => $qcm->getId()));
}
