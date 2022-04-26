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
    $q = $this->db->getPDO()->prepare("SELECT id FROM QuestionQCM");
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
}

// $conn = new DatabaseManagement();
// $crud = new QcmCRUD($conn);

// $c = new CoursRecommandeQCM();
// $c->setCours(new CoursTexte("x", 1));
// $c->setMoyMin(1);
// $c->setMoyMax(5);

// $c1 = new ChoixQuestion();
// $c1->setIntitule("c1");
// $c1->setIsValide(false);
// $c1->setPoints(-5.1);

// $c2 = new ChoixQuestion();
// $c2->setIntitule("c2");
// $c2->setIsValide(true);
// $c2->setPoints(56);

// $qu = new QuestionChoix(true);
// $qu->setQuestion("question blabla");
// $qu->setIsMultiple(true);
// $qu->addChoix($c1);
// $qu->addChoix($c2);

// $qcm = new QCM();
// $qcm->setTitre("test qcm");
// $qcm->setCategorie(EnumCategorie::DESIGN);
// $qcm->setDescription("blabla");
// $qcm->setXmlUrl("coucou.xml");

// $qcm->addCoursRecommandes($c);
// $qcm->addQuestion($qu);


// $crud->createQcm($qcm);