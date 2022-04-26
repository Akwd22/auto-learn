<?php

use LDAP\Result;

require_once("models/EnumTypeQuestion.php");
require_once("models/ReponseQCM.php");
require_once("models/ChoixQuestion.php");

abstract class QuestionQCM
{
    private $id;

    private $question;

    const TYPE = EnumTypeQuestion::NONE;

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
    abstract public function getPoints();
}

class QuestionChoixUnique extends QuestionQCM
{
    const TYPE = EnumTypeQuestion::CHOIX_UNIQUE;

    private $choix = array();
    
    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function addChoix($choix)
    {
        array_push($this->choix, $choix);
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
                array_splice($this->choix, $i, 1);
            }
        }
    }

    public function isCorrecte($reponseQCM) 
    {
        $points = 0;

        foreach ($this->choix as $choixQuestion)
        {
            $choixReponse = $reponseQCM->getChoixById($choixQuestion->getId());

            if ($choixReponse->getIsCoche())
            {
                $points += $choixQuestion->getPoints(); // Ajouter les points (ou retirer car dans le cas d'une réponse fausse, les points sont négatifs).
            }
        }

        return $points;
    }

    public function getPoints()
    {
        $points = 0;

        foreach ($this->choix as $choix)
        {
            if ($choix->getIsValide()) {
                $points += $choix->getPoints();
            }
        }

        return $points;
    }
}

class QuestionChoixMultiples extends QuestionQCM
{
    const TYPE = EnumTypeQuestion::CHOIX_MULTIPLES;

    private $choix = array();
    
    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function addChoix($choix)
    {
        array_push($this->choix, $choix);
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
                array_splice($this->choix, $i, 1);
        }
    }

    public function isCorrecte($reponseQCM) 
    {
        $points = 0;

        foreach ($this->choix as $choixQuestion)
        {
            $choixReponse = $reponseQCM->getChoixById($choixQuestion->getId());

            if ($choixReponse->getIsCoche())
            {
                $points += $choixReponse->getPoints(); // Ajouter les points (ou retirer car dans le cas d'une réponse fausse, les points sont négatifs).
            }
        }

        return $points;
    }

    public function getPoints()
    {
        $points = 0;

        foreach ($this->choix as $choix)
        {
            if ($choix->getIsValide()) {
                $points += $choix->getPoints();
            }
        }

        return $points;
    }
}
class QuestionSaisie extends QuestionQCM
{
    const TYPE = EnumTypeQuestion::SAISIE;

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
        $points = 0;

        if($reponseQCM->getSaisie()==$this->bonneReponse)
        {
            $points = $this->points;
        }

        return $points;
    }
}
?>