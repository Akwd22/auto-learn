<?php
require_once("models/Utilisateur.php");
require_once("databases/DatabaseManagement.php");
require_once("databases/TentativeCoursCRUD.php");
require_once("databases/TentativeQcmCRUD.php");

class UtilisateurCRUD
{

    private $db;

    private $tentativeCoursCRUD;
    private $tentativeQcmCRUD;

    public function __construct($db)
    {
        $this->db = $db;
        $this->tentativeCoursCRUD = new TentativeCoursCRUD($db);
        $this->tentativeQcmCRUD = new TentativeQcmCRUD($db);
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    public function readAllUsers()
    {
        $sth = $this->db->getPDO()->prepare("SELECT * FROM utilisateur");
        $sth->execute();
        $row = $sth->fetchAll();

        $users = array();

        foreach ($row as $r) {
            $user = new Utilisateur($r["id"]);
            $user->setPseudo($r["pseudo"]);
            $user->setEmail($r["email"]);
            $user->setPassHash($r["passHash"]);
            $user->setImageUrl($r["imageUrl"]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $r["dateCreation"]));
            $user->setTheme($r["theme"]);
            $user->setIsAdmin($r["isAdmin"]);
            $user->setIsConnected($r["isConnected"]);
            $user->setCoursTentes($this->tentativeCoursCRUD->readAllTentativeCoursByUserId($r["id"]));
            $user->setQcmTentes($this->tentativeQcmCRUD->readAllTentativesQcmFromUser($user->getId()));

            array_push($users, $user);
        }

        return $users;
    }

    public function readUserByPseudo($pseudo)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where pseudo = :pseudo");
        $sth->bindValue(':pseudo', $pseudo);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row)) {
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]); 
            $user->setCoursTentes($this->tentativeCoursCRUD->readAllTentativeCoursByUserId($row[0][0]));
            $user->setQcmTentes($this->tentativeQcmCRUD->readAllTentativesQcmFromUser($user->getId()));
        }

        return $user;
    }

    public function readUserByEmail($email)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where email = :email");
        $sth->bindValue(':email', $email);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row)) {
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            $user->setCoursTentes($this->tentativeCoursCRUD->readAllTentativeCoursByUserId($row[0][0]));
            $user->setQcmTentes($this->tentativeQcmCRUD->readAllTentativesQcmFromUser($user->getId()));
            return $user;
        }
    }

    public function readUserById($id)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where id = :id");
        $sth->bindValue(':id', $id);
        $sth->execute();
        $row = $sth->fetchAll();
       
        if (!empty($row)) {
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);          
            $user->setCoursTentes($this->tentativeCoursCRUD->readAllTentativeCoursByUserId($row[0][0]));
            $user->setQcmTentes($this->tentativeQcmCRUD->readAllTentativesQcmFromUser($user->getId()));
            return $user;
        }
    }
    
    public function readMaxUserId()
    {
        try {
            $sth = $this->db->getPDO()->prepare("
            SELECT id FROM Utilisateur ORDER BY id DESC LIMIT 0,1;");
            $sth->execute();
            $row = $sth->fetchAll();

            if (!empty($row))
                return $row[0][0];
            
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }

    public function readUserForAdmin($search)
    {
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur WHERE pseudo LIKE '%$search%' OR email LIKE '%$search%' ");
        $sth->execute();
        $row = $sth->fetchAll();

        $users = array();

        foreach ($row as $r) {
            $user = new Utilisateur($r["id"]);
            $user->setPseudo($r["pseudo"]);
            $user->setEmail($r["email"]);
            $user->setPassHash($r["passHash"]);
            $user->setImageUrl($r["imageUrl"]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $r["dateCreation"]));
            $user->setTheme($r["theme"]);
            $user->setIsAdmin($r["isAdmin"]);
            $user->setIsConnected($r["isConnected"]);
            $user->setCoursTentes($this->tentativeCoursCRUD->readAllTentativeCoursByUserId($row[0][0]));
            $user->setQcmTentes($this->tentativeQcmCRUD->readAllTentativesQcmFromUser($user->getId()));

            array_push($users, $user);
        }

        return $users;
    }

    public function updateUser($user, $id)
    {
        try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected = $user->getIsConnected();
            $coursTentes = $user->getAllCoursTentes();

            $sth = $this->db->getPDO()->prepare("UPDATE utilisateur set 
						pseudo = :pseudo,
						email = :email,
						passHash = :passHash,
						imageUrl = :imageUrl,
                        theme = :theme,
                        isAdmin = :isAdmin,
                        isConnected = :isConnected
						where id = :id");

            $sth->bindValue(':id', $id);
            $sth->bindValue(':pseudo', $pseudo);
            $sth->bindValue(':email', $email);
            $sth->bindValue(':passHash', $passHash);
            $sth->bindValue(':imageUrl', $imageUrl);
            $sth->bindValue(':theme', $theme);
            $sth->bindValue(':isAdmin', +$isAdmin);
            $sth->bindValue(':isConnected', +$isConnected);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }

        foreach($coursTentes as $c)
        {
            $this->tentativeCoursCRUD->updateTentativeCours($c,$c->getId());
        }

    }

    public function createUser($user)
    {
        try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $dateCreation = $user->getDateCreation();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected = $user->getIsConnected();
            $coursTentes = $user->getAllCoursTentes();

            if ($user->getId() == null) {
                $sth = $this->db->getPDO()->prepare("
                    INSERT INTO utilisateur (pseudo, email, passHash, imageUrl, dateCreation, theme, isAdmin, isConnected) 
                    VALUES (:pseudo, :email, :passHash, :imageUrl, :dateCreation, :theme, :isAdmin, :isConnected)");
            } else {
                $id = $user->getId();
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO utilisateur (id, pseudo, email, passHash, imageUrl, dateCreation, theme, isAdmin, isConnected) 
                VALUES (:id, :pseudo, :email, :passHash, :imageUrl, :dateCreation, :theme, :isAdmin, :isConnected)");
                $sth->bindValue(':id', $id);
            }
            $sth->bindValue(':pseudo', $pseudo);
            $sth->bindValue(':email', $email);
            $sth->bindValue(':passHash', $passHash);
            $sth->bindValue(':imageUrl', $imageUrl);
            if($dateCreation!=null)
                $sth->bindValue(':dateCreation', $dateCreation->format("Y-m-d G:i:s"));
            else
                $sth->bindValue(':dateCreation', NULL);
            $sth->bindValue(':theme', $theme);
            $sth->bindValue(':isAdmin', +$isAdmin);
            $sth->bindValue(':isConnected', +$isConnected);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
            die();
        }
        foreach ($coursTentes as $c)
        {
            $this->tentativeCoursCRUD->createTentativeCours($c);
            try{
                $sth = $this->db->getPDO()->prepare("
                INSERT INTO utilisateurtentativescours (idTentativeCours, idUtilisateur)
                VALUES (:idTentativeCours, :idUtilisateur);"); 
                if($c->getId()!=null)
                    $sth->bindValue(':idTentativeCours', $c->getId());
                else
                    $sth->bindValue(':idTentativeCours', $this->tentativeCoursCRUD->readMaxTentativeCoursId());

                if ($user->getId() != null) 
                    $sth->bindValue(':idUtilisateur', $user->getId());
                else
                    $sth->bindValue(':idUtilisateur', $this->readMaxUserId());

                $sth->execute();
            } catch (PDOException $e) {
                echo $e->getMessage() . "<br>";
                die();
            }
        }
    }

    public function deleteUser($id)
    {
        try {
            $sth = $this->db->getPDO()->prepare("
            DELETE from utilisateur where id = :id ");
            $sth->bindValue(':id', $id);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage() . "<br>";
        }
    }
}
