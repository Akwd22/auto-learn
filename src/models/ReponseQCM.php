<?php
require_once("models/EnumTypeQuestion.php");
require_once("models/ChoixReponse.php");

abstract class ReponseQCM
{
    const TYPE = EnumTypeQuestion::NONE;
}

class ReponseChoix extends ReponseQCM
{
    const TYPE = EnumTypeQuestion::CHOIX;

    private $choix = array();

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
        for ($i = 0; $i < count($this->choix); $i++)
        {
            if ($this->choix[$i]->getIdChoix() == $id)
            {
                return $this->choix[$i];
            }
        }
    }

    public function removeChoix($id)
    {
        for ($i = 0; $i < count($this->choix); $i++)
        {
            if ($this->choix[$i]->getIdChoix() == $id)
            {
                array_splice($this->choix, $i, 1);
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
        $this->saisie = $saisie;
    }

    public function setSaisie($saisie)
    {
        $this->saisie = $saisie;
    }

    public function getSaisie()
    {
        return $this->saisie;
    }
}
