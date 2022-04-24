<?php

require_once("models/EnumTypeQuestion.php");
require_once("models/ChoixReponse.php");

abstract class ReponseQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::NONE;

    public function __construct()
    {}
}

class ReponseChoixUnique extends ReponseQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::CHOIX_UNIQUE;
    
    private $choix = array();

    public function __construct(){
        parent::__construct();
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
}

class ReponseChoixMultiples extends ReponseQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::CHOIX_MULTIPLES;
    
    private $choix = array();

    public function __construct(){
        parent::__construct();
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
}

class ReponseSaisie extends ReponseQCM
{
    const ETYPEQUESTION = EnumTypeQuestion::SAISIE;

    private $saisie;

    public function __construct($saisie)
    {
        parent::__construct();
        $this->saisie=$saisie;
    }

    public function setSaisie($saisie)
    {
        $this->saisie=$saisie;
    }

    public function getSaisie()
    {
        return $this->saisie;
    }
}

?>