<?php
require_once("models/EnumTheme.php");
require_once("models/TentativeCours.php");

class Utilisateur
{
    private $id;

    private $pseudo;

    private $email;

    private $passHash;

    private $imageUrl;

    private $dateCreation;

    private $theme = EnumTheme::CLAIR;

    private $isAdmin;

    private $isConnected;

    private $coursTentes;

    private $qcmTentes;

    public function __construct($id = null)
    {
        $this->coursTentes = array();
        $this->qcmTentes = array();
        
        if ($id) {
            $this->id = intval($id);
        } else {
            $this->dateCreation = new DateTime();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPseudo($pseudo)
    {
        if (!$pseudo)
            throw new Error("\$pseudo est obligatoire");

        $this->pseudo = $pseudo;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setEmail($email)
    {
        if (!$email)
            throw new Error("\$email est obligatoire");

        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassHash($passHash)
    {
        if (!$passHash)
            throw new Error("\$passHash est obligatoire");

        $this->passHash = $passHash;
    }

    public function getPassHash()
    {
        return $this->passHash;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImageUrl()
    {
        return $this->imageUrl ? $this->imageUrl : "default.png";
    }

    public function setDateCreation($dateCreation)
    {
        if (!is_a($dateCreation, "DateTime"))
            throw new Error("\$dateCreation doit être une instance de DateTime");

        $this->dateCreation = $dateCreation;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setTheme($theme)
    {
        $this->theme = gettype($theme) === "string" ? EnumTheme::get($theme) : $theme;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = boolval($isAdmin);
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setIsConnected($isConnected)
    {
        $this->isConnected = boolval($isConnected);
    }

    public function getIsConnected()
    {
        return $this->isConnected;
    }

    public function getAllCoursTentes()
    {
        return $this->coursTentes;
    }

    public function getCoursTentes($id)
    {
        foreach($this->coursTentes as $value)
        {
            if($value->getId()==$id)
                return $value;
        }
    }

    public function hasCoursTente($idCours)
    {
        foreach($this->coursTentes as $value)
        {
            if($value->getCours()->getId() == $idCours)
                return true;
        }

        return false;
    }

    public function setCoursTentes($coursTentes)
    {
        $this->coursTentes=$coursTentes;
    }

    public function addCoursTentes($coursTentes)
    {
        array_push($this->coursTentes,$coursTentes);
    }

    public function removeCoursTentes($id)
    {
        for ($i=0; $i<=count($this->coursTentes)-1;$i++)
        {
            if($this->coursTentes[$i]->getId()==$id)
            {
                unset($this->coursTentes[$i]);
            }      
        }
    }

    public function getAllQcmTentes()
    {
        return $this->qcmTentes;
    }

    public function getQcmTentesByTentativeId($id)
    {
        foreach($this->qcmTentes as $value)
        {
            if($value->getId()==$id)
                return $value;
        }
    }

    public function getQcmTentesByQcmId($id)
    {
        foreach($this->qcmTentes as $value)
        {
            if($value->getQCM()->getId()==$id)
                return $value;
        }        
    }

    public function setQcmTentes($qcmTentes)
    {
        $this->qcmTentes=$qcmTentes;
    }

    public function addQcmTentes($qcmTente)
    {
        array_push($this->qcmTentes,$qcmTente);
    }

    public function removeQcmTentes($id)
    {
        for ($i=0; $i<=count($this->qcmTentes)-1;$i++)
        {
            if($this->qcmTentes[$i]->getId() == $id)
            {
                array_splice($this->qcmTentes, $i, 1);
            }      
        }
    }

    public function toString()
    {
        return "$this->id. $this->pseudo. $this->email. $this->passHash. $this->imageUrl. $this->dateCreation. $this->theme. $this->isAdmin. $this->isConnected. <br>";
    }
}
