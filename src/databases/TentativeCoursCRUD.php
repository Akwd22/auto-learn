<?php
require_once("models/Cours.php");
require_once("models/TentativeCours.php");
require_once("databases/DatabaseManagement.php");
require_once("databases/CoursCRUD.php");

class TentativeCoursCRUD
{
    private $db;

    private $coursCRUD;

    public function __construct($db)
    {
        $this->db=$db;
        $this->coursCRUD = new CoursCRUD($db);
    }

    public function setDb($db)
    {
        $this->db=$db;
    }
    
    public function getDb()
    {
        return $this->db;
    }

    public function createTentativeCours($coursTente)
    {
        try{
            $isTermine = $coursTente->getIsTermine();
            $dateCommence = $coursTente->getDateCommence();
            $dateTermine = $coursTente->getDateTermine();
            $idCours = $coursTente->getCours()->getId();

            if($coursTente->getId() == null)
            {
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO tentativecours (idCours, isTermine, dateCommence, dateTermine)
                VALUES (:idCours, :isTermine, :dateCommence, :dateTermine)");
            }
            else
            {
                $id = $coursTente->getID();
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO tentativecours (id, idCours, isTermine, dateCommence, dateTermine)
                VALUES (:id, :idCours, :isTermine, :dateCommence, :dateTermine)");
                $sth->bindValue(':id', $id);
            }
            $sth->bindValue(':idCours', $idCours);
            $sth->bindValue(':isTermine', +$isTermine);
            if($dateCommence!=null)
                $sth->bindValue(':dateCommence', $dateCommence->format("Y-m-d G:i:s"));
            else
                $sth->bindValue(':dateCommence', NULL);
            if($dateTermine!=null)
                $sth->bindValue(':dateTermine', $dateTermine->format("Y-m-d G:i:s"));
            else
                $sth->bindValue(':dateTermine', NULL);

            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }    
    }

    public function readAllTentativeCoursByUserId($userId)
    {
        $coursTentes = array();

        $sth = $this->db->getPDO()->prepare("
        SELECT id, idUtilisateur from tentativeCours 
        INNER JOIN UtilisateurTentativesCours ON id=idTentativeCours 
        WHERE idUtilisateur=:id;");
        $sth->bindValue(':id', $userId);
        $sth->execute();
        $coursTentesId = $sth->fetchAll();      
        
        if(!empty($coursTentesId))
        {
            foreach($coursTentesId as $r)
            {

                array_push($coursTentes, $this->readTentativeCoursById($r['id']));
            }
        }
        return $coursTentes;
    }

    public function readTentativeCoursById($id)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM tentativecours WHERE id = :id");
        $sth->bindValue(':id', $id);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row))
        {
            $coursTente = new TentativeCours($row[0][0]);
            $coursTente->setCours($this->coursCRUD->readCoursById($row[0][1]));
            $coursTente->setIsTermine($row[0][2]);
            if($row[0][3]!=null)
                $coursTente->setDateCommence(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][3]));
            if($row[0][4]!=null)
                $coursTente->setDateTermine(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][4]));
            return $coursTente;
        }
    }

    public function readMaxTentativeCoursId()
    {
        try{        
            $sth = $this->db->getPDO()->prepare("
            SELECT id FROM TentativeCours ORDER BY id DESC LIMIT 0,1;");
            $sth->execute();
            $row = $sth->fetchAll();

            if (!empty($row))
                return $row[0][0];
            
        } catch (PDOException $e) {
        echo $e->getMessage() . "<br>";
        }
    }

    public function updateTentativeCours($coursTente, $id)
    {
        try{
            $idCours = $coursTente->getCours()->getId();
            $isTermine = $coursTente->getIsTermine();
            $dateCommence = $coursTente->getDateCommence();
            $dateTermine = $coursTente->getDateTermine();

            $sth = $this->db->getPDO()->prepare("UPDATE tentativecours SET
                        idCours = :idCours,
                        isTermine = :isTermine,
                        dateCommence = :dateCommence,
                        dateTermine = :dateTermine
                        WHERE id = :id");

            $sth->bindValue(':id', $id);
            $sth->bindValue(':idCours', $idCours);
            $sth->bindValue(':isTermine', +$isTermine);
            $sth->bindValue(':dateCommence', $dateCommence->format("Y-m-d G:i:s"));
            $sth->bindValue(':dateTermine', $dateTermine ? $dateTermine->format("Y-m-d G:i:s") : null);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }

    public function deleteTentativeCours($id)
    {
        try {
            $sth = $this->db->getPDO()->prepare("
            DELETE FROM tentativecours WHERE id = :id");
            $sth->bindValue(':id', $id);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }
}

?>