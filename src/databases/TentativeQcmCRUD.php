<?php
require_once("databases/DatabaseManagement.php");
require_once("databases/QcmCRUD.php");
require_once("models/TentativeQCM.php");

class TentativeQcmCRUD
{
  private $db;
  private $qcmCRUD;

  public function __construct($db)
  {
    $this->db = $db;
    $this->qcmCRUD = new QcmCRUD($db);
  }

  /* ----------------------------- Tentatives QCM ----------------------------- */

  public function readTentativeQcmById($idTentative)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM TentativeQCM WHERE id = :idTentative");
    $q->bindValue(":idTentative", $idTentative);
    $q->execute();

    $tentative = null;

    if (($row = $q->fetch())) {
      $tentative = new TentativeQCM($row["id"]);
      $tentative->setMoy($row["moy"]);
      $tentative->setPointsActuels($row["pointsActuels"]);
      $tentative->setIsTermine($row["isTermine"]);
      $tentative->setDateCommence(DateTime::createFromFormat("Y-m-d G:i:s", $row["dateCommence"]));
      if ($row["dateTermine"]) $tentative->setDateTermine(DateTime::createFromFormat("Y-m-d G:i:s", $row["dateTermine"]));
      $tentative->setNumQuestionCourante($row["numQuestionCourante"]);
      $tentative->setQcm($this->qcmCRUD->readQcmById($row["idQCM"]));
    }

    return $tentative;
  }

  public function readAllTentativesQcmFromUser($idUtilisateur)
  {
    $q = $this->db->getPDO()->prepare("SELECT id FROM TentativeQCM
      INNER JOIN UtilisateurTentativesQCM ON TentativeQCM.id = UtilisateurTentativesQCM.idTentativeQCM
      WHERE idUtilisateur = :idUtilisateur");
    $q->bindValue(":idUtilisateur", $idUtilisateur);
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $array[] = $this->readTentativeQcmById($row["id"]);
    }

    return $array;
  }
}

// $conn = new DatabaseManagement();
// $crud = new TentativeQcmCRUD($conn);

// var_dump($crud->readAllTentativesQcmFromUser(2));
