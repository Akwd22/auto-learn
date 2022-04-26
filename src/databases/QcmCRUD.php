<?php
require_once("databases/DatabaseManagement.php");
require_once("databases/QuestionQcmCRUD.php");
require_once("databases/CoursCRUD.php");
require_once("models/QCM.php");
require_once("models/CoursRecommandeQCM.php");

class QcmCRUD
{
  private $db;
  private $questionCRUD;
  private $coursCRUD;

  public function __construct($db)
  {
    $this->db = $db;
    $this->questionCRUD = new QuestionQcmCRUD($db);
    $this->coursCRUD = new CoursCRUD($db);
  }

  /* ----------------------------------- QCM ---------------------------------- */

  public function readQcmById($idQcm)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM QCM WHERE id = :idQcm");
    $q->bindValue(":idQcm", $idQcm);
    $q->execute();

    $qcm = null;

    if (($row = $q->fetch())) {
      $qcm = new QCM($row["id"]);
      $qcm->setTitre($row["titre"]);
      $qcm->setCategorie($row["categorie"]);
      $qcm->setDescription($row["description"]);
      $qcm->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row["dateCreation"]));
      $qcm->setXmlUrl($row["xmlUrl"]);
      $qcm->setQuestions($this->questionCRUD->readAllQuestionsFromQcm($qcm->getId()));
      $qcm->setCoursRecommandes($this->readCoursRecommandesForQcm($qcm->getId()));
    }

    return $qcm;
  }

  public function readAllQcm()
  {
    $q = $this->db->getPDO()->prepare("SELECT id FROM QuestionQCM");
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $array[] = $this->readQcmById($row["id"]);
    }

    return $array;
  }

  /* ---------------------------- Cours recommandés --------------------------- */

  public function readCoursRecommandesForQcm($idQcm)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM CoursRecommandeQCM WHERE idQCM = :idQcm");
    $q->bindValue(":idQcm", $idQcm);
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $cours = new CoursRecommandeQCM();
      $cours->setMoyMin($row["moyMin"]);
      $cours->setMoyMax($row["moyMax"]);
      $cours->setCours($this->coursCRUD->readCoursById($row["idCours"]));
      $array[] = $cours;
    }

    return $array;
  }
}

// $conn = new DatabaseManagement();
// $crud = new QcmCRUD($conn);

// var_dump($crud->readAllQcm());
