<?php

class CoursRecommandeQCM
{
    private $moyMin;
    private $moyMax;
    private $cours;

    public function setMoyMin($moyMin){
        if ($moyMin >= 0 && $moyMin <= 20) 
            $this->moyMin = floatval($moyMin);
        else
        throw new Error("\$moyMin doit être compris entre 0 et 20");
    }

    public function getMoyMin()
    {
        return $this->moyMin;
    }

    public function setMoyMax($moyMax)
    {
        if ($moyMax >= 0 && $moyMax <= 20) 
            $this->moyMax = floatval($moyMax);
        else
            throw new Error("\$moyMax doit être compris entre 0 et 20");
    }

    public function getMoyMax()
    {
        return $this->moyMax;
    }

    public function setCours($cours)
    {
        $this->cours = $cours;
    }

    public function getCours()
    {
        return $this->cours;
    }
}
?>