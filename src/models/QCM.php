<?php

require_once("models/EnumCategorie.php");
require_once("models/QuestionQCM.php");
require_once("models/CoursRecommandeQCM.php");

class QCM 
{
    private $id;

    private $titre;

    private $categorie;

    private $description;

    private $dateCreation;

    private $xmlUrl;

    private $questions = array();

    private $coursRecommandes = array();

    public function __construct($id = null)
    {
        if($id!=null)
            $this->id = intval($id);
        
        else
            $this->dateCreation = new DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitre($titre)
    {
        $this->titre=$titre;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = gettype($categorie) === "string" ? EnumCategorie::get($categorie) : $categorie;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setDescription($description)
    {
        $this->description=$description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDateCreation($dateCreation)
    {
        if (!is_a($dateCreation, "DateTime"))
            throw new Error("\$dateCreation doit être une instance de DateTime");
  
        $this->dateCreation = $dateCreation;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setXmlUrl($xmlUrl)
    {
        $this->xmlUrl=$xmlUrl;
    }

    public function getXmlUrl()
    {
        return $this->xmlUrl;
    }
    
    public function nbQuestions()
    {   
        return count($this->questions);
    }

    public function getAllCoursRecommandes()
    {
        return $this->coursRecommandes;
    }

    public function setCoursRecommandes($cours)
    {
        $this->coursRecommandes = $cours;
    }

    public function addCoursRecommandes($cours)
    {
        array_push($this->coursRecommandes,$cours);
    }

    public function removeCoursRecommandes($cours)
    {
        for($i=0;$i<count($this->coursRecommandes);$i++)
        {
            if ($this->coursRecommandes[$i] == $cours) {
                array_splice($this->coursRecommandes, $i, 1);
            }
        }
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    public function getAllQuestions()
    {
        return $this->questions;
    }

    public function getQuestionsByIndex($index)
    {
        return $this->questions[$index];
    }

    public function getQuestionsById($id)
    {
        for($i=0;$i<count($this->questions);$i++)
        {
            if($this->questions[$i]->getId()==$id)
                return $this->questions[$i];
        }        
    }

    public function addQuestion($question)
    {
        array_push($this->questions,$question);
    }

    public function removeQuestion($id)
    {
        for($i=0;$i<count($this->questions);$i++)
        {
            if($this->questions[$i]->getId()==$id)
                array_splice($this->questions, $i, 1);
        }    
    }

    public function getTotalPoints()
    {
        $points = 0;

        foreach ($this->questions as $question)
        {
            $points += $question->getPoints();
        }

        return $points;
    }
}
?>