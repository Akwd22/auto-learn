<?php
    include 'databases/UtilisateurCRUD.php';

    session_start();

   /* $isLogged = isset($_SESSION["isConnected"]);
    $isAdmin = $_SESSION["isAdmin"] ? $_SESSION["isAdmin"] : false;

    if (!$isLogged || !$isAdmin) die("Vous devez être connecté et être admin.");
*/
    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(!empty($_POST['site-search']) && isset($_POST['sub'])){
        $users=$userCRUD->readUserForAdmin($_POST['site-search']);
    }

    else{
        echo "Champ de recherche vide";
    }

?>