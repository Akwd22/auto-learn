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
}

// $conn = new DatabaseManagement();
// $crud = new QuestionQcmCRUD($conn);

// var_dump($crud->readAllQuestionsFromQcm(1));
