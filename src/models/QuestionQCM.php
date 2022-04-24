<?php

require_once("models/EnumTypeQuestion.php");
require_once("models/ReponseQCM.php");
require_once("models/ChoixQuestion.php");

abstract class QuestionQCM
{
    private $id;

    private $question;

    const ETYPEQUESTION = EnumTypeQuestion::NONE;

    public function __construct($id = null)
    {
        if($id != null)
            $this->id = intval($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setQuestion($question)
    {
        $this->question=$question;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    abstract public function isCorrecte($reponseQCM);
}

class QuestionChoixUnique extends QuestionQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::CHOIX_UNIQUE;

    private $choix = array();
    
    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function getAllChoix()
    {
        return $this->choix;
    }

    public function getChoixById($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getId()==$id)
            {
                return $this->choix[$i];
            }
        }
    }

    public function removeChoix($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getId()==$id)
            {
                unset($this->choix[$i]);
            }
        }
    }

    public function isCorrecte($reponseQCM) 
    {
        $res=true;

        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->getChoixById($i)->getIsValide()!=$reponseQCM->getChoixById($i)->getIsCoche())
            {
                $res=false;
            }
        }
        return $res;
    }
}

class QuestionChoixMultiples extends QuestionQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::CHOIX_MULTIPLES;

    private $choix = array();
    
    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function getAllChoix()
    {
        return $this->choix;
    }

    public function getChoixById($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getId()==$id)
                return $this->choix[$i];
        }
    }

    public function removeChoix($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getId()==$id)
                unset($this->choix[$i]);
        }
    }

    public function isCorrecte($reponseQCM) 
    {
        $res=true;

        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->getChoixById($i)->getIsValide()!=$reponseQCM->getChoixById($i)->getIsCoche())
                $res=false;
        }
        return $res;
    }
}
class QuestionSaisie extends QuestionQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::SAISIE;

    private $placeHolder;

    private $bonneReponse;

    private $points;

    
    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function setPlaceHolder($placeHolder)
    {
        $this->placeHolder=$placeHolder;
    }

    public function getPlaceHolder()
    {
        return $this->placeHolder;
    }

    public function setBonneReponse($bonneReponse)
    {
        $this->bonneReponse=$bonneReponse;
    }

    public function getBonneReponse()
    {
        return $this->bonneReponse;
    }

    public function setPoints($points)
    {
        $this->points=floatval($points);
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function isCorrecte($reponseQCM)
    {
        $res=false;

        if($reponseQCM->getSaisie()==$this->bonneReponse)
            $res=true;

        return $res;
    }
}

?>