<?php
require_once("controllers/classes/files/FileManager.php");
require_once("models/QuestionQCM.php");
require_once("models/ChoixQuestion.php");
require_once("config.php");

/**
 * Parser XML pour les questions de QCM.
 */
class XmlParserQcm
{
  /*** @var string Chemin et nom du fichier XML. */
  private $filePath;
  /*** @var SimpleXMLElement Racine du fichier XML. */
  private $xmlRoot;

  /**
   * Créer un parser XML pour les questions de QCM.
   * @param string $fileName Nom du fichier XML.
   * @throws Error Fichier inexistant.
   */
  public function __construct(string $fileName)
  {
    $this->filePath = UPLOADS_QCM_DIR . $fileName;

    if (!FileManager::exists($this->filePath)) {
      throw new Error("Fichier XML inexistant : '$this->filePath'");
    }

    $this->xmlRoot = simplexml_load_file($this->filePath);
  }

  /**
   * Parser le fichier XML.
   * @return QuestionQCM[] Tableau des instances de questions QCM.
   */
  public function parse()
  {
    return $this->parseQuestions();
  }

  /**
   * Parser toutes les questions.
   * @return QuestionQCM[] Tableau des instances de questions QCM.
   */
  private function parseQuestions()
  {
    $listeQuestions = [];

    foreach ($this->xmlRoot->children() as $nodeQuestion) {
      $parserNode = "parse" . $nodeQuestion->getName();
      $listeQuestions[] = $this->$parserNode($nodeQuestion);
    }

    return $listeQuestions;
  }

  /**
   * Parser une question à choix.
   * @param SimpleXMLElement $node Noeud `QuestionChoix`.
   * @return QuestionChoix Instance de la question à choix.
   */
  private function parseQuestionChoix($node)
  {
    $question = new QuestionChoix($node["isMultiple"] == "true" ? true : false);
    $question->setQuestion((string) $node["question"]);

    $listeChoix = [];

    foreach ($node->children() as $nodeChoix) {
      $choix = new ChoixQuestion();
      $choix->setIntitule((string) $nodeChoix);
      $choix->setIsValide($nodeChoix["isValide"] == "true" ? true : false);
      $choix->setPoints((float) $nodeChoix["points"]);
      $listeChoix[] = $choix;
    }

    $question->setChoix($listeChoix);

    return $question;
  }

  /**
   * Parser une question de saisie.
   *
   * @param SimpleXMLElement $node Noeud `QuestionSaisie`.
   * @return QuestionSaisie Instance de la question à saisie.
   */
  private function parseQuestionSaisie($node)
  {
    $question = new QuestionSaisie();
    $question->setQuestion((string) $node["question"]);
    $question->setBonneReponse((string) $node["bonneReponse"]);
    $question->setPlaceHolder((string) $node["placeholder"]);
    $question->setPoints((float) $node["points"]);

    return $question;
  }
}
