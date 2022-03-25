<?php
    include '../../databases/UtilisateurCRUD.php';

    session_start();

    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $user=$userCRUD->readUserByPseudo($_POST['pseudo']);

        if($user!=null)
        {        
            if(password_verify($_POST['password'],$user->getPassHash()))
            {
                $user->setIsConnected(1);
                $userCRUD->updateUser($user,$user->getId());

                $_SESSION["isAdmin"] = $user->getIsAdmin();
                $_SESSION["isConnected"] = $user->getIsConnected();
                $_SESSION["utilisateurId"] = $user->getId();

                header('Location: ../../../index.php'); //renvoie au menu principal
            }
            else
            {
                header('Location: ../../views/login.php?erreur=1'); //mot de passe incorrect
            }
        }
        else
        {
            header('Location: ../../views/login.php?erreur=2'); //utilisateur inconnu
        }
    }
    else
    {
        header('Location: ../../views/login.php');
    }
    $conn->close();
