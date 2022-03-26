<?php
    include '../../databases/UtilisateurCRUD.php';

    session_start();

    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(isset($_SESSION["isConnected"]))
    {
        $user = $userCRUD->readUserById($_SESSION['utilisateurId']);
        $user->setIsConnected(0);
        $userCRUD->updateUser($user, $_SESSION['utilisateurId']);
        $_SESSION = array();
        session_destroy();
        header('Location: ../../../index.php');
    }

    $conn->close();
?>