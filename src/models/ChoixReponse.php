<?php

class ChoixReponse
{
    private $idChoix;

    private $isCoche;

    public function __construct($idChoix, $isCoche)
    {
        $this->idChoix = intval($idChoix);
        $this->isCoche = boolval($isCoche);
    }

    public function setIdChoix($idChoix)
    {
        $this->idChoix = intval($idChoix);   
    }

    public function getIdChoix()
    {
        return $this->idChoix;
    }

    public function setIsCoche($isCoche)
    {
        $this->isCoche=boolval($isCoche);
    }

    public function getIsCoche()
    {
        return $this->isCoche;
    }
}

?>