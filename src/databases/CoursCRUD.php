<?php
require_once("models/Cours");
require_once("models/TentativeCours.php");
require_once("databases/DatabaseManagement.php");

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
            $sth->bindValue(':isTermine', $isTermine);
            $sth->bindValue(':dateCommence', $dateCommence);
            $sth->bindValue(':dateTermine', $dateTermine);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }    
    }

    public function readAllTentativeCours($userId)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM tentativecours 
        NATURAL JOIN utilisateurtentativecours
        NATURAL JOIN utilisateur
        WHERE utilisateur.id = :id");
        $sth->bindValue(':id', $userId);
        $sth->execute();
        $row = $sth->fetchAll();
        $coursTentes = array();

        foreach ($row as $r)
        {
            $coursTente = new TentativeCours($r["id"]);
            //$coursTente->setCours(); SET LE COURS
            $coursTente->setIsTermine($r["isTermine"]);
            $coursTente->setDateCommence($r["dateCommence"]);
            $coursTente->setDateTermine($r["dateTermine"]);

            array_push($coursTentes, $coursTente);
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
            //$coursTente->setCours(); SET LE COURS
            $coursTente->setIsTermine($row[0][2]);
            $coursTente->setDateCommence(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][3]));
            $coursTente->setDateTermine(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][4]));
            return $coursTente;
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
            $sth->bindValue(':isTermine', $isTermine);
            $sth->bindValue(':dateCommence', $dateCommence);
            $sth->bindValue(':dateTermine', $dateTermine);
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