<?php
require_once("models/Utilisateur.php");
require_once("databases/DatabaseManagement.php");

class UtilisateurCRUD {

    private $db;

    public function __construct($db)
    {
        $this->db=$db;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db=$db;
    }

    public function readUserByPseudo($pseudo){
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where pseudo = :pseudo");
        $sth->bindValue(':pseudo', $pseudo);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row)){
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            return $user;
        }
    }

    public function readUserByEmail($email){
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where email = :email");
        $sth->bindValue(':email', $email);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row)){
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            return $user;
        }
    }

    public function readUserById($id){
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur where id = :id");
        $sth->bindValue(':id', $id);
        $sth->execute();
        $row = $sth->fetchAll();

        if (!empty($row)){
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            return $user;
        }
    }

    public function readUserForAdmin($search){
        $sth = $this->db->getPDO()->prepare("
        SELECT * FROM utilisateur WHERE pseudo LIKE '%$search%' OR email LIKE '%$search%' ");
        $sth->execute();
        $row = $sth->fetchAll();

        $users = array();
        foreach($row as $r){
            $user = new Utilisateur($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation(DateTime::createFromFormat("Y-m-d G:i:s", $row[0][5]));
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            array_push($users,$user);
        }
        return $users;
    }

    public function updateUser($user, $id) {
		try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected = $user->getIsConnected();

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
			
		}
	    catch(PDOException $e) {
	    	echo $e->getMessage(). "<br>";
	    }
	}

    public function createUser($user) {
		try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $dateCreation = $user->getDateCreation();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected=$user->getIsConnected();

            if($user->getId()==null)
            {
                $sth = $this->db->getPDO()->prepare("
                    INSERT INTO utilisateur (pseudo, email, passHash, imageUrl, dateCreation, theme, isAdmin, isConnected) 
                    VALUES (:pseudo, :email, :passHash, :imageUrl, :dateCreation, :theme, :isAdmin, :isConnected)");
            }
            else
            {
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
            $sth->bindValue(':dateCreation', $dateCreation->format("Y-m-d G:i:s"));
            $sth->bindValue(':theme', $theme);
            $sth->bindValue(':isAdmin', +$isAdmin);
            $sth->bindValue(':isConnected', +$isConnected);
            $sth->execute();
		}
	    catch(PDOException $e) {
	    	echo $e->getMessage(). "<br>";
            die();
	    }
	}

    public function deleteUser($id) {
		try {
			$sth = $this->db->getPDO()->prepare("
            DELETE from utilisateur where id = :id ");
            $sth->bindValue(':id', $id);                
            $sth->execute();			
		}
	    catch(PDOException $e) {
	    	echo $e->getMessage(). "<br>";
	    }
	}

}
