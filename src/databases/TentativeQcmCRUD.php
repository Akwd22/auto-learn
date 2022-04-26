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

  public function readMaxTentativeQcmId()
  {
    $q = $this->db->getPDO()->query("SELECT MAX(id) AS maxId FROM TentativeQCM");

    $maxId = null;

    if (($row = $q->fetch())) {
      $maxId = $row["maxId"];
    }

    return $maxId;
  }

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

  public function createTentativeQcm($idUtilisateur, $tentative)
  {
    $q = $this->db->getPDO()->prepare("INSERT INTO TentativeQCM (idQCM, moy, pointsActuels, isTermine, dateCommence, dateTermine, numQuestionCourante) VALUES (:idQCM, :moy, :pointsActuels, :isTermine, :dateCommence, :dateTermine, :numQuestionCourante)");
    $q->bindValue(":idQCM", $tentative->getQcm()->getId());
    $q->bindValue(":moy", $tentative->getMoy());
    $q->bindValue(":pointsActuels", $tentative->getPointsActuels());
    $q->bindValue(":isTermine", intval($tentative->getIsTermine()));
    $q->bindValue(":dateCommence", $tentative->getDateCommence()->format("Y-m-d G:i:s"));
    $q->bindValue(":dateTermine", $tentative->getDateTermine() ? $tentative->getDateTermine()->format("Y-m-d G:i:s") : null);
    $q->bindValue(":numQuestionCourante", $tentative->getNumQuestionCourante());
    $q->execute();

    $newId = $this->readMaxTentativeQcmId();

    $q = $this->db->getPDO()->prepare("INSERT INTO UtilisateurTentativesQCM (idTentativeQCM, idUtilisateur) VALUES (:idTentativeQCM, :idUtilisateur)");
    $q->bindValue(":idTentativeQCM", $newId);
    $q->bindValue(":idUtilisateur", $idUtilisateur);
    $q->execute();
  }

  public function updateTentativeQcm($tentative)
  {
    $q = $this->db->getPDO()->prepare("UPDATE TentativeQCM SET moy = :moy, pointsActuels = :pointsActuels, isTermine = :isTermine, dateCommence = :dateCommence, dateTermine = :dateTermine, numQuestionCourante = :numQuestionCourante WHERE id = :idTentative");
    $q->bindValue(":idTentative", $tentative->getId());
    $q->bindValue(":moy", $tentative->getMoy());
    $q->bindValue(":pointsActuels", $tentative->getPointsActuels());
    $q->bindValue(":isTermine", intval($tentative->getIsTermine()));
    $q->bindValue(":dateCommence", $tentative->getDateCommence()->format("Y-m-d G:i:s"));
    $q->bindValue(":dateTermine", $tentative->getDateTermine() ? $tentative->getDateTermine()->format("Y-m-d G:i:s") : null);
    $q->bindValue(":numQuestionCourante", $tentative->getNumQuestionCourante());
    $q->execute();
  }

  public function deleteTentativeQcm($idTentative)
  {
    $q = $this->db->getPDO()->prepare("DELETE FROM TentativeQCM WHERE id = :idTentative");
    $q->bindValue(":idTentative", $idTentative);
    $q->execute();
  }
}

// $conn = new DatabaseManagement();
// $crud = new TentativeQcmCRUD($conn);

// $t = $crud->readTentativeQcmById(1);
// $t->setNumQuestionCourante(666);
// $t->setPointsActuels(555);

// $crud->updateTentativeQcm($t);

// $crud->deleteTentativeQcm(1);

// $t = new TentativeQCM();
// $t->setMoy(15.5);
// $t->setPointsActuels(30);
// $t->setIsTermine(true);
// $t->setNumQuestionCourante(5);

// $t->setQcm(new QCM(1));

// $crud->createTentativeQcm(1, $t);
