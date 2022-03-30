<?php
    require_once "databases/SessionManagement.php";
    require_once 'databases/UtilisateurCRUD.php';

    SessionManagement::session_start();

    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(SessionManagement::isLogged())
    {
        $user = $userCRUD->readUserById(SessionManagement::getUserId());
        $user->setIsConnected(0);
        $userCRUD->updateUser($user, SessionManagement::getUserId());

        SessionManagement::session_destroy();

        header('Location: ../../../index.php');
    }

    $conn->close();
