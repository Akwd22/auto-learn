<?php
    require_once "databases/SessionManagement.php";
    require_once "databases/UtilisateurCRUD.php";
    require_once "controllers/utils.php";

    SessionManagement::session_start();

    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email']))
    { 
        $user=$userCRUD->readUserByPseudo($_POST['pseudo']);
        $email=$userCRUD->readUserByEmail($_POST['email']);

        if($user!=null)
        {
            redirect("/views/pages/inscription/signin.php", "error", "Nom d'utilisateur déjà existant.");
        }
        elseif($email!=null)
        {
            redirect("/views/pages/inscription/signin.php", "error", "E-mail déjà existante.");
        }
        else
        {
            $createUser = new Utilisateur();
            $createUser->setPseudo($_POST['pseudo']);
            $createUser->setEmail($_POST['email']);
            $createUser->setPassHash(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $createUser->setImageUrl("");
            $createUser->setTheme(1);
            $createUser->setisAdmin(0);
            $createUser->setIsConnected(1); 
            $userCRUD->createUser($createUser);

            $createUser = $userCRUD->readUserByPseudo(($createUser->getPseudo())); // Obtenir le nouveau ID de l'utilisateur.

            // On prend en compte que l'inscription connecte directement l'utilisateur.
            SessionManagement::setUser($createUser);

            redirect("/index.php");
        }
    }
    else
    {
        redirect("/views/pages/inscription/signin.php");
    }
    $conn->close();
