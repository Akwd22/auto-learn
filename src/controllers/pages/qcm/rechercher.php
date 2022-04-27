<?php
require_once("databases/SessionManagement.php");
require_once("databases/QcmCRUD.php");
require_once("views/pages/qcm/rechercher/rechercher.php");

// TODO

$conn = new DatabaseManagement();
$crud = new QcmCRUD($conn);

$qcm = $crud->readAllQcm();
afficherQcm($qcm);
