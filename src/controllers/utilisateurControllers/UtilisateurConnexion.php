<?php
    require_once "databases/SessionManagement.php";
    require_once "databases/UtilisateurCRUD.php";
    require_once "controllers/utils.php";

    SessionManagement::session_start();

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

                SessionManagement::setUser($user);

                redirect("/index.php");
            }
            else
            {
                redirect("/views/pages/connexion/login.php", "error", "Nom d'utilisateur ou mot de passe incorrect.");
            }
        }
        else
        {
            redirect("/views/pages/connexion/login.php", "error", "Nom d'utilisateur ou mot de passe incorrect.");
        }
    }
    else
    {
        redirect("/views/pages/connexion/login.php", "error", "Nom d'utilisateur ou mot de passe incorrect.");
    }

    $conn->close();
