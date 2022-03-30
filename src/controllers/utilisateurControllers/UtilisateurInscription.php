<?php
    include 'databases/UtilisateurCRUD.php';

    session_start();

    $conn = new DatabaseManagement();
    $userCRUD = new UtilisateurCRUD($conn);

    if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email']))
    { 
        $user=$userCRUD->readUserByPseudo($_POST['pseudo']);
        $email=$userCRUD->readUserByEmail($_POST['email']);

        if($user!=null)
        {       
            header('Location: ../../views/signin.php?erreur=1'); //Utilisateur existant
        }
        elseif($email!=null)
        {
            header('Location: ../../views/signin.php?erreur=2'); //Email existant
        }
        else
        {
            $createUser = new Utilisateur();
            $createUser->setPseudo($_POST['pseudo']);
            $createUser->setEmail($_POST['email']);
            $createUser->setPassHash(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $createUser->setImageUrl("");
            date_default_timezone_set('UTC');
            $date = date('Y-m-d H:i:s');
            $createUser->setDateCreation($date);
            $createUser->setTheme(1);
            $createUser->setisAdmin(0);
            $createUser->setIsConnected(1); 
            $userCRUD->createUser($createUser);

            $createUser = $userCRUD->readUserByPseudo(($createUser->getPseudo())); // Obtenir le nouveau ID de l'utilisateur.

            // On prend en compte que l'inscription connecte directement l'utilisateur.
            $_SESSION["isAdmin"] = $createUser->getIsAdmin();
            $_SESSION["isConnected"] = $createUser->getIsConnected();
            $_SESSION["utilisateurId"] = $createUser->getId();

            header('Location: ../../../index.php');
        }
    }
    else
    {
        header('Location: ../../views/signin.php');
    }
    $conn->close();
