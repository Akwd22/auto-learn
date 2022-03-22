<?php
  include 'databases/UtilisateurCRUD.php';

/*  $userCRUD = new UtilisateurCRUD();
  $user = new Utilisateur();

  $user->setPseudo("UpdateUser");
  $user->setEmail("UpdateUser@gmail.com");
  $user->setPassHash("xxx");
  $user->setImageUrl("test.png");
  date_default_timezone_set('UTC');
  $date = date('Y-m-d H:i:s');
  $user->setdateCreation($date);
  $user->setTheme(1);
  $user->setIsAdmin(0); //on ne peut pas mettre false ni true, ca bloque au niveau de la bdd
  $user->setIsConnected(0); //on ne peut pas mettre false ni true, ca bloque au niveau de la bdd
  var_dump($user);

  //UPDATE
  $userCRUD->updateUser($user, 1);  
  $users = $userCRUD->readUserByPseudo("UpdateUser");

  echo $users->toString();

  //CREATE
  $user->setPseudo("CreationUser");
  $user->setPassHash("xxx");
  $user->setEmail("CreationUser@gmail.com");  
  $userCRUD->createUser($user);
  $users = $userCRUD->readUserByPseudo("CreationUser");
  echo $users->toString();

  //CREATE WITH ID
  $user->setPseudo("CreationUserID");
  $user->setPassHash("xxx");
  $user->setEmail("CreationUserID@gmail.com");  
  $user->setId(5);
  $userCRUD->createUser($user);
  $users = $userCRUD->readUserByPseudo("CreationUserID");
  echo $users->toString();
  
  //DELETE
  $userCRUD->deleteUser(5);
*/
?>