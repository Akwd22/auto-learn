<?php
    include 'databases/UtilisateurCRUD.php';

    require_once "databases/SessionManagement.php";

    SessionManagement::session_start();
    
    $isLogged = SessionManagement::isLogged();
    $isAdmin = SessionManagement::isAdmin();
    
    if (!$isLogged || !$isAdmin) die("Vous devez être connecté et être admin.");
    
    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(!empty($_POST['site-search']) && isset($_POST['sub'])){
        $users=$userCRUD->readUserForAdmin($_POST['site-search']);
        foreach($users as $r){
            print_r($r);
            echo "<br/>";
        }
    }

    else{
        echo "Champ de recherche vide";
    }

?>