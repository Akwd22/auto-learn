<?php
require_once("config.php");

class DatabaseManagement
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(DB_DBMS . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            if (DB_DEBUG_MODE) $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $this->pdo = null;
    }
}
