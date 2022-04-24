<?php

class ChoixQuestion
{
    private $id;

    private $intitule;

    private $isValide;

    private $points;

    public function __construct($id = null)
    {
        if($id != null)
            $this->id = intval($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIntitule($intitule)
    {
        $this->intitule=$intitule;
    }

    public function getIntitule()
    {
        return $this->intitule;
    }

    public function setIsValide($isValide)
    {
        $this->isValide=boolval($isValide);
    }

    public function getIsValide()
    {
        return $this->isValide;
    }

    public function setPoints($points)
    {
        $this->points=floatval($points);
    }

    public function getPoints()
    {
        return $this->points;
    }
}
?>