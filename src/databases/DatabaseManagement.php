<?php

class DatabaseManagement
{
    private $pdo;

    public function __construct()
    {  
        try {
            $user = "root";
            $pass = "root";
            $this->pdo = new PDO('mysql:host=localhost;dbname=daw', $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
		    print "Erreur !: " . $e->getMessage() . "<br/>";
		    die();
		}
    }

    public function getPDO()
    {
        return $this->pdo;

    }

    public function close()
    {
        $this->pdo=null;
    }
}

?>