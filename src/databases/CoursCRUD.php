<?php
require_once("models/Cours.php");
require_once("databases/DatabaseManagement.php");
require_once("models/EnumFormatCours.php");

class CoursCRUD
{
    private $db;

    public function __construct($db)
    {
        $this->db=$db;
    }

    public function setDb($db)
    {
        $this->db=$db;
    }
    
    public function getDb()
    {
        return $this->db;
    }

    public function createCours($cours)
    {
        try{
            $titre = $cours->getTitre();
            $description = $cours->getDescription();
            $imageUrl = $cours->getImageUrl();
            $tempsMoyen = $cours->getTempsMoyen();
            $niveauRecommande = $cours->getNiveauRecommande();
            $categorie = $cours->getCategorie();
            $dateCreation = $cours->getDateCreation();
            $format = $cours::FORMAT;

            if($cours->getId() == null)
            {
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO cours (titre, description, imageUrl, tempsMoyen, niveauRecommande, categorie, dateCreation, format)
                Values(:titre, :description, :imageUrl, :tempsMoyen, :niveauRecommande, :categorie, :dateCreation, :format);");   
            }
            else
            {
                $id=$cours->getId();
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO cours (id, titre, description, imageUrl, tempsMoyen, niveauRecommande, categorie, dateCreation, format)
                VALUES(:id, :titre, :description, :imageUrl, :tempsMoyen, :niveauRecommande, :categorie, :dateCreation, :format);");   
                $sth->bindValue(':id', $id);
            }
            $sth->bindValue(':titre', $titre);
            $sth->bindValue(':description', $description);
            $sth->bindValue(':imageUrl', $imageUrl);
            $sth->bindValue(':tempsMoyen', $tempsMoyen);
            $sth->bindValue(':niveauRecommande', $niveauRecommande);
            $sth->bindValue(':categorie', $categorie);
            $sth->bindValue(':dateCreation', $dateCreation->format("Y-m-d G:i:s"));
            $sth->bindValue(':format', $format);
            $sth->execute();

        }catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }

        if ($format === EnumFormatCours::VIDEO)
        {   
            try{ 
                $sthVideo = $this->db->getPDO()->prepare("
                    INSERT INTO CoursVideo(idCours)
                    VALUES(:idCours);");
                if($cours->getId()==null)
                {
                    $sthVideo->bindValue(':idCours', $this->readMaxCoursId());
                }
                else
                {
                    $sthVideo->bindValue(':idCours', $cours->getId());
                }

                $sthVideo->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }  

            for($i=0; $i<count($cours->getVideosUrl()); $i++)
            {
                try{
                $sthVideosUrl = $this->db->getPDO()->prepare("
                INSERT INTO CoursVideosUrl(idCours, videoUrl, ordre)
                VALUES(:id, :videoUrl, :ordre);");
                if($cours->getId()==null)
                    $sthVideosUrl->bindValue(':id', $this->readMaxCoursId());
                else
                    $sthVideosUrl->bindValue(':id', $cours->getId());

                $sthVideosUrl->bindValue(':videoUrl', $cours->getVideosUrl()[$i]);
                $sthVideosUrl->bindValue(':ordre', $i+1);
                $sthVideosUrl->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }  
            }
        }

        if ($format === EnumFormatCours::TEXTE)
        {
            try{
                $fichierUrl = $cours->getFichierUrl();
                $sthTexte = $this->db->getPDO()->prepare("
                INSERT INTO CoursTexte(idCours, fichierUrl)
                VALUES(:id, :fichierUrl);");
                if($cours->getId()==null)
                    $sthTexte->bindValue(':id', $this->readMaxCoursId());
                else
                    $sthTexte->bindValue(':id', $cours->getId());
                $sthTexte->bindValue(':fichierUrl', $fichierUrl);
                $sthTexte->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }
        }
    }    

    public function readAllCours()
    {
        $cours = array();

        $sth = $this->db->getPDO()->prepare("
        SELECT id from Cours;");
        $sth->execute();
        $coursId = $sth->fetchAll();      
        
        if(!empty($coursId))
        {
            foreach($coursId as $r)
            {
                array_push($cours, $this->readCoursById($r['id']));
            }
        }

        return $cours;
    }

    public function readCoursById($coursId)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM Cours WHERE id = :id");
        $sth->bindValue(':id', $coursId);
        $sth->execute();
        $row = $sth->fetchAll();

        $cours = null;

        if (!empty($row))        
        {
            $format = gettype($row[0][8]) === "string" ? EnumFormatCours::get($row[0][8]) : $row[0][8];
            
            if ($format === EnumFormatCours::VIDEO)
            {
                $sthVideoCOUNT = $this->db->getPDO()->prepare("
                SELECT COUNT(idCours) FROM CoursVideosUrl WHERE idCours = :id");
                $sthVideoCOUNT->bindValue(':id', $coursId);
                $sthVideoCOUNT->execute();
                $rowVideoCOUNT = $sthVideoCOUNT->fetchAll();


                $sthVideo = $this->db->getPDO()->prepare("
                SELECT idCours, videoUrl FROM CoursVideosUrl WHERE idCours = :id");
                $sthVideo->bindValue(':id', $coursId);
                $sthVideo->execute();
                $rowVideo = $sthVideo->fetchAll();

                if (!empty($rowVideo))
                {
                    $countNbVideos=$rowVideoCOUNT[0][0];
                    $videosUrl = array();

                    for($i=0;$i<$countNbVideos;$i++)
                    {
                        array_push($videosUrl,$rowVideo[$i][1]);
                    }

                    $cours = new CoursVideo($videosUrl, $row[0][0]);
                    $cours->setTitre($row[0][1]);
                    $cours->setDescription($row[0][2]);
                    $cours->setImageUrl($row[0][3]);
                    $cours->setTempsMoyen($row[0][4]);
                    $cours->setNiveauRecommande($row[0][5]);
                    $cours->setCategorie($row[0][6]);
                    $cours->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s",$row[0][7]));
                }
            }
            if ($format === EnumFormatCours::TEXTE)
            {
                $sthTexte = $this->db->getPDO()->prepare("
                SELECT fichierUrl FROM CoursTexte WHERE idCours = :id");
                $sthTexte->bindValue(':id', $coursId);
                $sthTexte->execute();
                $rowTexte = $sthTexte->fetchAll();
        
                if (!empty($rowTexte))
                {
                    $cours = new CoursTexte($rowTexte[0][0], $row[0][0]);
                    $cours->setTitre($row[0][1]);
                    $cours->setDescription($row[0][2]);
                    $cours->setImageUrl($row[0][3]);
                    $cours->setTempsMoyen($row[0][4]);
                    $cours->setNiveauRecommande($row[0][5]);
                    $cours->setCategorie($row[0][6]);
                    $cours->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s",$row[0][7]));               
                }
            }
        }
        
        return $cours;
    }

    public function readCoursFiltres($titre = "", $format = null, $cat = null) {
        $q = $this->db->getPDO()->prepare(
        "SELECT id FROM Cours WHERE
            titre LIKE :titre"
            . ($format ? " AND format = :format" : "")
            . ($cat    ? " AND categorie = :cat" : "")
        );

        $q->bindValue(":titre", "%$titre%");
        if ($format) $q->bindValue(":format", $format, PDO::PARAM_INT);
        if ($cat)    $q->bindValue(":cat", $cat, PDO::PARAM_INT);

        $q->execute();
        $rows = $q->fetchAll();      

        $cours = [];

        if(!empty($rows))
        {
            foreach($rows as $row)
            {
                array_push($cours, $this->readCoursById($row["id"]));
            }
        }
        
        return $cours;
    }

    public function readMaxCoursId()
    {
        try {
            $sth = $this->db->getPDO()->prepare("
            SELECT id FROM Cours ORDER BY id DESC LIMIT 0,1;");
            $sth->execute();
            $row = $sth->fetchAll();

            if (!empty($row))
                return $row[0][0];
        
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }

    public function updateCours($cours, $id)
    {
        $titre = $cours->getTitre();
        $description = $cours->getDescription();
        $imageUrl = $cours->getImageUrl();
        $tempsMoyen = $cours->getTempsMoyen();
        $niveauRecommande = $cours->getNiveauRecommande();
        $categorie = $cours->getCategorie();
        $dateCreation = $cours->getDateCreation();
        $format = $cours::FORMAT;
        
        try{
            $sth = $this->db->getPDO()->prepare("
            UPDATE Cours SET
            titre = :titre,
            description = :description,
            imageUrl = :imageUrl,
            tempsMoyen = :tempsMoyen,
            niveauRecommande = :niveauRecommande,
            categorie = :categorie,
            dateCreation = :dateCreation,
            format = :format
            WHERE id = :id");
            $sth->bindValue(':titre', $titre);
            $sth->bindValue(':description', $description);
            $sth->bindValue(':imageUrl', $imageUrl);
            $sth->bindValue(':tempsMoyen', $tempsMoyen);
            $sth->bindValue(':niveauRecommande', $niveauRecommande);
            $sth->bindValue(':categorie', $categorie);
            $sth->bindValue(':dateCreation', $dateCreation->format("Y-m-d G:i:s"));
            $sth->bindValue(':format', $format);
            $sth->bindValue(':id', $id);
            $sth->execute();
        }catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }

        if($format===EnumFormatCours::VIDEO)
        {
            try{ 
                $sthVideo = $this->db->getPDO()->prepare("
                    UPDATE CoursVideo SET id = :id WHERE id = :id;");                    
                $sthVideo->bindValue(':idCours', $cours->getId());
                $sthVideo->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }  

            try{
                $sth = $this->db->getPDO()->prepare("
                DELETE FROM CoursVideosUrl WHERE idCours = :id");
                $sth->bindValue(':id', $id);
                $sth->execute();

            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            } 

            for($i=0; $i<count($cours->getVideosUrl()); $i++)
            {
                try{
                $sthVideosUrl = $this->db->getPDO()->prepare("
                INSERT INTO CoursVideosUrl(idCours, videoUrl, ordre)
                VALUES(:id, :videoUrl, :ordre);");
                if($cours->getId()==null)
                    $sthVideosUrl->bindValue(':id', $this->readMaxCoursId());
                else
                    $sthVideosUrl->bindValue(':id', $cours->getId());

                $sthVideosUrl->bindValue(':videoUrl', $cours->getVideosUrl()[$i]);
                $sthVideosUrl->bindValue(':ordre', $i+1);
                $sthVideosUrl->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }  
            }
        }

        if($format===EnumFormatCours::TEXTE)
        {
            $fichierUrl = $cours->getFichierUrl();
            try{
            $sthTexte = $this->db->getPDO()->prepare("  
            UPDATE CoursTexte SET    
            fichierUrl = :fichierUrl
            WHERE coursId = :id");
            $sthTexte->bindValue(':fichierUrl', $fichierUrl);
            $sthTexte->bindValue(':coursId', $id);
            $sthTexte->execute();
            }catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();         
            }
        }
    }

    public function deleteCours($coursId)
    {
        try {
            $sth = $this->db->getPDO()->prepare("
            DELETE FROM Cours WHERE id = :id");
            $sth->bindValue(':id', $coursId);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }
}
?>