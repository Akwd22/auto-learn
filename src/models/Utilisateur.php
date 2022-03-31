<?php
require_once("models/Enum.php");

abstract class EnumTheme extends Enum
{
    const CLAIR = 1;
    const SOMBRE = 2;
}

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

    public function __construct($id = NULL)
    {
        if ($id != NULL) {
            $this->id = intval($id);
        }
    }

    public function setId($id)
    {
        $this->id = intval($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassHash($passHash)
    {
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
        return $this->imageUrl;
    }

    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = DateTime::createFromFormat("Y-m-d G:i:s", $dateCreation);
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

    public function toString()
    {
        return "$this->id. $this->pseudo. $this->email. $this->passHash. $this->imageUrl. $this->dateCreation. $this->theme. $this->isAdmin. $this->isConnected. <br>";
    }
}
