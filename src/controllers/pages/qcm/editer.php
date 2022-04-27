<?php
require_once("databases/DatabaseManagement.php");
require_once("databases/QcmCRUD.php");
require_once("views/pages/qcm/editer/editer.php");

$qcmId = $_GET["id"] ?? null;

// TODO

$conn = new DatabaseManagement();
$crud = new QcmCRUD($conn);

$qcm = null;
$isEditMode = $qcmId ? true : false;

if ($isEditMode)
  $qcm = $crud->readQcmById($qcmId);

afficherFormulaire($isEditMode, $qcm);
