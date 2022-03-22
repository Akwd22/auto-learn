<?php

if(!@include("models/Utilisateur.php")) include '/../../models/Utilisateur.php';
include 'DatabaseManagement.php';

class UtilisateurCRUD {

    private $db;

    public function __construct()
    {
        $this->db = new DatabaseManagement();
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
        $requete = "SELECT * FROM utilisateur where pseudo = '$pseudo'";
        $stmt = $this->db->getPDO()->query($requete);
        $row = $stmt->fetchAll();
        if (!empty($row)){

            $user = new Utilisateur();
            $user->setId($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation($row[0][5]);
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            return $user;
        }
    }

    public function readUserByEmail($email){
        $requete = "SELECT * FROM utilisateur where email = '$email'";
        $stmt = $this->db->getPDO()->query($requete);
        $row = $stmt->fetchAll();
        if (!empty($row)){

            $user = new Utilisateur();
            $user->setId($row[0][0]);
            $user->setPseudo($row[0][1]);
            $user->setEmail($row[0][2]);
            $user->setPassHash($row[0][3]);
            $user->setImageUrl($row[0][4]);
            $user->setDateCreation($row[0][5]);
            $user->setTheme($row[0][6]);
            $user->setIsAdmin($row[0][7]);
            $user->setIsConnected($row[0][8]);
            return $user;
        }
    }

    public function updateUser($user, $id) {
		try {
            var_dump($user);
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected = $user->getIsConnected();

			$requete = "UPDATE utilisateur set 
						pseudo = '$pseudo',
						email = '$email',
						passHash = '$passHash',
						imageUrl = '$imageUrl',
                        theme = '$theme',
                        isAdmin = '$isAdmin',
                        isConnected = '$isConnected'
						where id = '$id' ";
			$stmt = $this->db->getPDO()->query($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
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

                $requete = "INSERT INTO utilisateur (pseudo, email, passHash, imageUrl, dateCreation, theme, isAdmin, isConnected) 
                        VALUES ('$pseudo', '$email', '$passHash' ,'$imageUrl', '$dateCreation', '$theme', '$isAdmin', '$isConnected')";
            }
            else
            {
                $id = $user->getId();
                $requete = "INSERT INTO utilisateur (id, pseudo, email, passHash, imageUrl, dateCreation, theme, isAdmin, isConnected) 
                        VALUES ('$id', '$pseudo', '$email', '$passHash' ,'$imageUrl', '$dateCreation', '$theme', '$isAdmin', '$isConnected')";

            }

	    	$this->db->getPDO()->exec($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
	    }
	}

    public function deleteUser($id) {
		try {
			$requete = "DELETE from utilisateur where id = '$id' ";
			$stmt = $this->db->getPDO()->query($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
	    }
	}

}

?>