<?php
    include '../../databases/UtilisateurCRUD.php';

    $userCRUD = new UtilisateurCRUD();

    if(isset($_POST['pseudo']) && isset($_POST['password']))
    {
        $user=$userCRUD->readUserByPseudo($_POST['pseudo']);

        if($user!=null)
        {        
            if($user->getPassHash() == $_POST['password'])
            {
                $user->setIsConnected(1);
                $userCRUD->updateUser($user,$user->getId());
                header('Location: ../../../index.php'); //renvoie au menu principal
            }
            else
            {
                header('Location: ../../views/login.php?erreur=1'); //mot de passe inconnu
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

?>