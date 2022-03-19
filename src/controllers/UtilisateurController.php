<?php

include 'models/Utilisateur.php';

class UtilisateurController {

    public static function getDatabaseConnexion()
    {
        try {
            $user = "root";
            $pass = "root";
            $pdo = new PDO('mysql:host=localhost;dbname=daw', $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
		    print "Erreur !: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

    public static function readUser($id){
        $con = self::getDatabaseConnexion();
        $requete = "SELECT * FROM utilisateur where id = '$id'";
        $stmt = $con->query($requete);
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

    public static function updateUser($user, $id) {
		try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected = $user->getIsConnected();

			$con = self::getDatabaseConnexion();
			$requete = "UPDATE utilisateur set 
						pseudo = '$pseudo',
						email = '$email',
						passHash = '$passHash',
						imageUrl = '$imageUrl',
                        theme = '$theme',
                        isAdmin = '$isAdmin',
                        isConnected = '$isConnected'
						where id = '$id' ";
			$stmt = $con->query($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
	    }
	}

    public static function createUser($user) {
		try {
            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $passHash = $user->getPassHash();
            $imageUrl = $user->getImageUrl();
            $dateCreation = $user->getDateCreation();
            $theme = $user->getTheme();
            $isAdmin = $user->getisAdmin();
            $isConnected=$user->getIsConnected();

            $con = self::getDatabaseConnexion();

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

	    	$con->exec($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
	    }
	}

    public static function deleteUser($id) {
		try {
			$con = self::getDatabaseConnexion();
			$requete = "DELETE from utilisateur where id = '$id' ";
			$stmt = $con->query($requete);
		}
	    catch(PDOException $e) {
	    	echo $requete . "<br>" . $e->getMessage(). "<br>";
	    }
	}

}

?>