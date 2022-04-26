<?php

require_once("models/EnumTypeQuestion.php");
require_once("models/ChoixReponse.php");

abstract class ReponseQCM
{
    const TYPE = EnumTypeQuestion::NONE;

    public function __construct()
    {}
}

class ReponseChoixUnique extends ReponseQCM
{
    const TYPE = EnumTypeQuestion::CHOIX_UNIQUE;
    
    private $choix = array();

    public function __construct(){
        parent::__construct();
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
            if($this->choix[$i]->getIdChoix()==$id)
            {
                return $this->choix[$i];
            }
        }
    }

    public function removeChoix($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getIdChoix()==$id)
            {
                unset($this->choix[$i]);
            }
        }
    }
}

class ReponseChoixMultiples extends ReponseQCM
{
    const TYPE = EnumTypeQuestion::CHOIX_MULTIPLES;
    
    private $choix = array();

    public function __construct(){
        parent::__construct();
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
            if($this->choix[$i]->getIdChoix()==$id)
            {
                return $this->choix[$i];
            }
        }
    }

    public function removeChoix($id)
    {
        for($i=0;$i<count($this->choix);$i++)
        {
            if($this->choix[$i]->getIdChoix()==$id)
            {
                unset($this->choix[$i]);
            }
        }
    }
}

class ReponseSaisie extends ReponseQCM
{
    const TYPE = EnumTypeQuestion::SAISIE;

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