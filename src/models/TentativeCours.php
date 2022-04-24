<?php

require_once("models/Cours.php");

class TentativeCours
{

    private $id;

    private $isTermine;

    private $dateCommence;

    private $dateTermine;

    private $cours;

    public function __construct($id = null)
    {
        if ($id) {
            $this->id = intval($id);
        } else {
            $this->dateCommence = new DateTime();
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function setIsTermine($isTermine)
    {
        $this->isTermine=boolval($isTermine);
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

    public function setCours($cours)
    {
        $this->cours=$cours;
    }

    public function getCours()
    {
        return $this->cours;
    }

    public function terminer($oui)
    {
        if($oui)
        {
            $this->isTermine=true;
            $this->dateTermine = new DateTime();
        }
        else
        {
            $this->isTermine=false;
            $this->dateTermine=null;
        }
    }   
}
?>