<?php
require_once("databases/DatabaseManagement.php");
require_once("models/EnumTypeQuestion.php");
require_once("models/QuestionQCM.php");
require_once("models/ChoixQuestion.php");

class QuestionQcmCRUD
{
  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  /* -------------------------------- Questions ------------------------------- */

  public function readMaxQuestionId()
  {
    $q = $this->db->getPDO()->query("SELECT MAX(id) AS maxId FROM QuestionQCM");

    $maxId = null;

    if (($row = $q->fetch())) {
      $maxId = $row["maxId"];
    }

    return $maxId;
  }

  public function readQuestionById($idQuestion)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM QuestionQCM WHERE id = :idQuestion");
    $q->bindValue(":idQuestion", $idQuestion);
    $q->execute();

    $question = null;

    if (($rowParent = $q->fetch())) {
      $type = EnumTypeQuestion::get($rowParent["type"]);

      if ($type === EnumTypeQuestion::SAISIE)
      {
        $q = $this->db->getPDO()->prepare("SELECT * FROM QuestionSaisie WHERE idQuestionQCM = :idQuestion");
        $q->bindValue(":idQuestion", $idQuestion);
        $q->execute();

        $row = $q->fetch();

        $question = new QuestionSaisie($rowParent["id"]);
        $question->setPlaceHolder($row["placeholder"]);
        $question->setBonneReponse($row["bonneReponse"]);
        $question->setPoints($row["points"]);
      }
      else if ($type === EnumTypeQuestion::CHOIX)
      {
        $q = $this->db->getPDO()->prepare("SELECT * FROM QuestionChoix WHERE idQuestionQCM = :idQuestion");
        $q->bindValue(":idQuestion", $idQuestion);
        $q->execute();

        $row = $q->fetch();

        $question = new QuestionChoix($row["isMultiple"], $rowParent["id"]);
        $question->setChoix($this->readAllChoixFromQuestion($question->getId()));
      }

      $question->setQuestion($rowParent["question"]);
    }

    return $question;
  }

  public function readAllQuestionsFromQcm($idQcm)
  {
    $q = $this->db->getPDO()->prepare("SELECT id FROM QuestionQCM WHERE idQCM = :idQcm ORDER BY id ASC");
    $q->bindValue(":idQcm", $idQcm);
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $array[] = $this->readQuestionById($row["id"]);
    }

    return $array;
  }

  public function createQuestion($idQcm, $question)
  {
    $q = $this->db->getPDO()->prepare("INSERT INTO QuestionQCM (idQCM, question, type) VALUES (:idQCM, :question, :type)");
    $q->bindValue(":idQCM", $idQcm);
    $q->bindValue(":question", $question->getQuestion());
    $q->bindValue(":type", $question::TYPE);
    $q->execute();

    $newId = $this->readMaxQuestionId();

    if ($question::TYPE === EnumTypeQuestion::SAISIE)
    {
      $q = $this->db->getPDO()->prepare("INSERT INTO QuestionSaisie (idQuestionQCM, placeholder, bonneReponse, points) VALUES (:idQuestionQCM, :placeholder, :bonneReponse, :points)");
      $q->bindValue(":idQuestionQCM", $newId);
      $q->bindValue(":placeholder", $question->getPlaceHolder());
      $q->bindValue(":bonneReponse", $question->getBonneReponse());
      $q->bindValue(":points", $question->getPoints());
      $q->execute();
    }
    else if ($question::TYPE === EnumTypeQuestion::CHOIX)
    {
      $q = $this->db->getPDO()->prepare("INSERT INTO QuestionChoix (idQuestionQCM, isMultiple) VALUES (:idQuestionQCM, :isMultiple)");
      $q->bindValue(":idQuestionQCM", $newId);
      $q->bindValue(":isMultiple", $question->getIsMultiple());
      $q->execute();

      foreach ($question->getAllChoix() as $choix)
      {
        $this->createChoix($newId, $choix);
      }
    }
  }

  /* ---------------------------------- Choix --------------------------------- */

  public function readChoixById($idChoix)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM ChoixQuestion WHERE id = :idChoix");
    $q->bindValue(":idChoix", $idChoix);
    $q->execute();

    $choix = null;

    if (($row = $q->fetch())) {
      $choix = new ChoixQuestion($row["id"]);
      $choix->setIntitule($row["intitule"]);
      $choix->setIsValide($row["isValide"]);
      $choix->setPoints($row["points"]);
    }

    return $choix;
  }

  public function readAllChoixFromQuestion($idQuestion)
  {
    $q = $this->db->getPDO()->prepare("SELECT * FROM ChoixQuestion WHERE idQuestion = :idQuestion");
    $q->bindValue(":idQuestion", $idQuestion);
    $q->execute();

    $array = [];

    foreach ($q->fetchAll() as $row) {
      $choix = new ChoixQuestion($row["id"]);
      $choix->setIntitule($row["intitule"]);
      $choix->setIsValide($row["isValide"]);
      $choix->setPoints($row["points"]);

      $array[] = $choix;
    }

    return $array;
  }

  public function createChoix($idQuestion, $choix)
  {
    $q = $this->db->getPDO()->prepare("INSERT INTO ChoixQuestion (idQuestion, intitule, isValide, points) VALUES (:idQuestion, :intitule, :isValide, :points)");
    $q->bindValue(":idQuestion", $idQuestion);
    $q->bindValue(":intitule", $choix->getIntitule());
    $q->bindValue(":isValide", intval($choix->getIsValide()));
    $q->bindValue(":points", $choix->getPoints());
    $q->execute();
  }
}

// $conn = new DatabaseManagement();
// $crud = new QuestionQcmCRUD($conn);

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

// $crud->createQuestion(1, $qu);