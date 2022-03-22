<?php
    include '../../databases/UtilisateurCRUD.php';

    $userCRUD = new UtilisateurCRUD();

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
            $createUser->setPassHash($_POST['password']);
            $createUser->setImageUrl("");
            date_default_timezone_set('UTC');
            $date = date('Y-m-d H:i:s');
            $createUser->setDateCreation($date);
            $createUser->setTheme(2);
            $createUser->setisAdmin(0);
            $createUser->setIsConnected(1); //On prend en compte que l'inscription connecte directement l'utilisateur
            var_dump($createUser);
            $userCRUD->createUser($createUser);
            echo 'Inscription reussie';
        }
    }
    else
    {
        header('Location: ../../views/signin.php');
    }

?>