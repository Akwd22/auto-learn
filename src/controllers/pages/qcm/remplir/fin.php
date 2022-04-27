<?php
require_once("views/pages/qcm/remplir/fin.php");

if (empty($_POST)) {
  showView();
} else {
  handleForm();
}

function showView()
{
  global $qcm;
  global $tentative;

  afficherQcmFin($qcm, $tentative);
}

function handleForm()
{
  global $qcm;
  global $tentative;
  global $tentaCRUD;

  $tentative->recommencer();
  $tentaCRUD->updateTentativeQcm($tentative);

  redirect("/qcm", null, null, array("id" => $qcm->getId()));
}
