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

  public function readMaxQcmId()
  {
    $q = $this->db->getPDO()->query("SELECT MAX(id) AS maxId FROM QCM");

    $maxId = null;

    if (($row = $q->fetch())) {
      $maxId = $row["maxId"];
    }

    return $maxId;
  }

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
    $q = $this->db->getPDO()->prepare("SELECT id FROM QCM");
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $array[] = $this->readQcmById($row["id"]);
    }

    return $array;
  }

  public function readQcmFiltres($titre = "", $cat = null)
  {
    $q = $this->db->getPDO()->prepare(
      "SELECT id FROM QCM WHERE
          titre LIKE :titre"
          . ($cat    ? " AND categorie = :cat" : "")
      );

      $q->bindValue(":titre", "%$titre%");
      if ($cat) $q->bindValue(":cat", $cat, PDO::PARAM_INT);

      $q->execute();   

      $array = [];

      foreach ($q->fetchAll() as $row) {
        $array[] = $this->readQcmById($row["id"]);
      }
      
      return $array;
  }

  public function createQcm($qcm)
  {
    $q = $this->db->getPDO()->prepare("INSERT INTO QCM (titre, categorie, description, dateCreation, xmlUrl) VALUES (:titre, :categorie, :description, :dateCreation, :xmlUrl)");
    $q->bindValue(":titre", $qcm->getTitre());
    $q->bindValue(":categorie", $qcm->getCategorie());
    $q->bindValue(":description", $qcm->getDescription());
    $q->bindValue(":dateCreation", $qcm->getDateCreation()->format("Y-m-d G:i:s"));
    $q->bindValue(":xmlUrl", $qcm->getXmlUrl());
    $q->execute();

    $newId = $this->readMaxQcmId();

    foreach ($qcm->getAllQuestions() as $question)
    {
      $this->questionCRUD->createQuestion($newId, $question);
    }

    foreach ($qcm->getAllCoursRecommandes() as $cours)
    {
      $this->createCoursRecommande($newId, $cours);
    }
  }

  public function updateQcm($qcm)
  {
    $q = $this->db->getPDO()->prepare("UPDATE QCM SET titre = :titre, categorie = :categorie, description = :description, dateCreation = :dateCreation, xmlUrl = :xmlUrl WHERE id = :idQcm");
    $q->bindValue(":idQcm", $qcm->getId());
    $q->bindValue(":titre", $qcm->getTitre());
    $q->bindValue(":categorie", $qcm->getCategorie());
    $q->bindValue(":description", $qcm->getDescription());
    $q->bindValue(":dateCreation", $qcm->getDateCreation()->format("Y-m-d G:i:s"));
    $q->bindValue(":xmlUrl", $qcm->getXmlUrl());
    $q->execute();

    $this->questionCRUD->deleteAllQuestionsFromQcm($qcm->getId());
    $this->deleteAllCoursRecommandesForQcm($qcm->getId());

    foreach ($qcm->getAllQuestions() as $question)
    {
      $this->questionCRUD->createQuestion($qcm->getId(), $question);
    }

    foreach ($qcm->getAllCoursRecommandes() as $cours)
    {
      $this->createCoursRecommande($qcm->getId(), $cours);
    }
  }

  public function deleteQcm($idQcm)
  {
    $q = $this->db->getPDO()->prepare("DELETE FROM QCM WHERE id = :idQcm");
    $q->bindValue(":idQcm", $idQcm);
    $q->execute();
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

  public function createCoursRecommande($idQcm, $coursRecommande)
  {
    $q = $this->db->getPDO()->prepare("INSERT INTO CoursRecommandeQCM (idQCM, idCours, moyMin, moyMax) VALUES (:idQCM, :idCours, :moyMin, :moyMax)");
    $q->bindValue(":idQCM", $idQcm);
    $q->bindValue(":idCours", $coursRecommande->getCours()->getId());
    $q->bindValue(":moyMin", $coursRecommande->getMoyMin());
    $q->bindValue(":moyMax", $coursRecommande->getMoyMax());
    $q->execute();
  }

  public function deleteAllCoursRecommandesForQcm($idQcm)
  {
    $q = $this->db->getPDO()->prepare("DELETE FROM CoursRecommandeQCM WHERE idQCM = :idQcm");
    $q->bindValue(":idQcm", $idQcm);
    $q->execute();
  }
}

// $conn = new DatabaseManagement();
// $crud = new QcmCRUD($conn);

// $q = $crud->readQcmFiltres("", EnumCategorie::WEB);
// var_dump($q);

// $c = new CoursRecommandeQCM();
// $c->setCours(new CoursTexte("x", 4));
// $c->setMoyMax(20);
// $c->setMoyMin(19);

// $q = new QuestionSaisie();
// $q->setPoints(666);
// $q->setBonneReponse("dans ton cul");
// $q->setQuestion("cest quoi ?");

// $qcm = $crud->readQcmById(1);
// $qcm->setTitre("autre title");
// $qcm->addCoursRecommandes($c);
// $qcm->addQuestion($q);

// $crud->updateQcm($qcm);