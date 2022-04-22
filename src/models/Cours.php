<?php
require_once("models/EnumCategorie.php");
require_once("models/EnumFormatCours.php");
require_once("models/EnumNiveauCours.php");

abstract class Cours
{
  private $id;
  private $titre;
  private $description;
  private $imageUrl;
  private $tempsMoyen;
  private $niveauRecommande = EnumNiveauCours::DEBUTANT;
  private $categorie = EnumCategorie::AUCUNE;
  private $dateCreation;

  const FORMAT = EnumFormatCours::NONE;

  public function __construct($id = null)
  {
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

  public function getTitre()
  {
    return $this->titre;
  }

  public function setTitre($titre)
  {
    if (!$titre)
      throw new Error("\$titre est obligatoire");

    $this->titre = strval($titre);
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description)
  {
    $this->description = strval($description);
  }

  public function getImageUrl()
  {
    return $this->imageUrl ? $this->imageUrl : "default.png";
  }

  public function setImageUrl($imageUrl)
  {
    $this->imageUrl = strval($imageUrl);
  }

  public function getTempsMoyen()
  {
    return $this->tempsMoyen;
  }

  public function setTempsMoyen($tempsMoyen)
  {
    if ($tempsMoyen < 0)
      throw new Error("\$tempsMoyen doit être positif ou nul");

    $this->tempsMoyen = floatval($tempsMoyen);
  }

  public function getNiveauRecommande()
  {
    return $this->niveauRecommande;
  }

  public function setNiveauRecommande($niveauRecommande)
  {
    $this->niveauRecommande = gettype($niveauRecommande) === "string" ? EnumNiveauCours::get($niveauRecommande) : $niveauRecommande;
  }

  public function getCategorie()
  {
    return $this->categorie;
  }

  public function setCategorie($categorie)
  {
    $this->categorie = gettype($categorie) === "string" ? EnumCategorie::get($categorie) : $categorie;
  }

  public function getDateCreation()
  {
    return $this->dateCreation;
  }

  public function setDateCreation($dateCreation)
  {
    if (!is_a($dateCreation, "DateTime"))
      throw new Error("\$dateCreation doit être une instance de DateTime");

    $this->dateCreation = $dateCreation;
  }
}

class CoursTexte extends Cours
{
  const FORMAT = EnumFormatCours::TEXTE;

  private $fichierUrl;

  public function __construct($fichierUrl, $id = null)
  {
    parent::__construct($id);

    $this->setFichierUrl($fichierUrl);
  }

  public function getFichierUrl()
  {
    return $this->fichierUrl;
  }

  public function setFichierUrl($fichierUrl)
  {
    if (!$fichierUrl)
      throw new Error("\$fichierUrl est obligatoire");

    $this->fichierUrl = strval($fichierUrl);
  }
}

class CoursVideo extends Cours
{
  const FORMAT = EnumFormatCours::VIDEO;

  private $videosUrl;

  public function __construct($videosUrl, $id = null)
  {
    parent::__construct($id);

    $this->setVideosUrl($videosUrl);
  }

  public function getVideosUrl()
  {
    return $this->videosUrl;
  }

  public function setVideosUrl($videosUrl)
  {
    if (!is_array($videosUrl) || empty($videosUrl))
      throw new Error("\$videosUrl doit être un tableau de string non vide");

    $this->videosUrl = $videosUrl;
  }
}
