<?php

require_once "models/QCM.php";
require_once "models/ReponseQCM.php";

class TentativeQCM
{
    private $id;

    private $moy;

    private $pointsActuels;

    private $isTermine;

    private $dateCommence;

    private $dateTermine;

    private $numQuestionCourante;

    private $qcm;

    public function __construct($id = null)
    {
        if($id != null)
            $this->id=intval($id);
        else{
            $this->moy = null;
            $this->pointsActuels = 0;
            $this->isTermine = false;
            $this->dateCommence = new DateTime();
            $this->dateTermine = null;
            $this->numQuestionCourante = null;
        }     
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMoy($moy)
    {
        if ($moy != null && $moy >= 0 && $moy <= 20) 
            $this->moy = floatval($moy);
        else
            throw new Error("\$moy doit être compris entre 0 et 20");
    }

    public function getMoy()
    {
        return $this->moy;
    }

    public function setPointsActuels($pointsActuels)
    {
        $this->pointsActuels = floatval($pointsActuels);
    }

    public function getPointsActuels()
    {
        return $this->pointsActuels;
    }

    public function setIsTermine($isTermine)
    {
        $this->isTermine = boolval($isTermine);
    }

    public function getIsTermine()
    {
        return $this->isTermine;
    }

    public function setDateCommence($dateCommence)
    {
        if (!is_a($dateCommence, "DateTime"))
            throw new Error("\$dateCommence doit être une instance de DateTime");
  
        $this->dateCommence = $dateCommence;
    }

    public function getDateCommence()
    {
        return $this->dateCommence;
    }  
    
    public function setDateTermine($dateTermine)
    {
        if (!is_a($dateTermine, "DateTime"))
            throw new Error("\$dateTermine doit être une instance de DateTime");

        $this->dateTermine = $dateTermine;
    }

    public function getDateTermine()
    {
        return $this->dateTermine;
    }

    public function setNumQuestionCourante($numQuestionCourante)
    {
        $this->numQuestionCourante = intval($numQuestionCourante);
    }

    public function getNumQuestionCourante()
    {
        return $this->numQuestionCourante;
    }

    public function setQcm($qcm)
    {
        $this->qcm=$qcm;
    }

    public function getQcm()
    {
        return $this->qcm;
    }

    public function nbQuestionRestante()
    {
        return $this->qcm->nbQuestions();
    }

    public function questionCourante()
    {
        return $this->qcm->getQuestionsByIndex($this->numQuestionCourante);
    }

    public function questionSuivante($reponseQCM)
    {  
        if($this->questionCourante()->isCorrecte($reponseQCM)==true)
        {
            $this->pointsActuels+=$this->questionCourante()->getPoints();
            $this->numQuestionCourante++;
        }
        elseif($this->questionCourante()==null)
        {
            $this->terminer();
        }
    }

    public function recommencer()
    {
        $this->moy = null;
        $this->pointsActuels = 0;
        $this->isTermine = false;
        $this->dateCommence = new DateTime();
        $this->dateTermine = null;
        $this->numQuestionCourante = null;
    }

    public function terminer()
    {
        $this->moy = $this->pointsActuels / $this->numQuestionCourante;
        $this->isTermine = true;
        $this->dateTermine = new DateTime();
    }

    public function getCoursRecommande()
    {
        if($this->isTermine!=true)
        {
            return null;
        }
        else
        {
            foreach($this->qcm->coursRecomandes as $value)
            {
                if($this->moy>=$value->getMoyMin() && $this->moy<=$value->getMoyMax())
                    return $value;
            }
        }
    }
}

?>