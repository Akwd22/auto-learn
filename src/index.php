<?php
  include 'controllers/UtilisateurController.php';

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
  $user->setIsConnected(1); //on ne peut pas mettre false ni true, ca bloque au niveau de la bdd
  var_dump($user);

  //UPDATE
  UtilisateurController::updateUser($user, 1);  
  $users = UtilisateurController::readUser(1);

  echo $users->toString();

  //CREATE
  $user->setPseudo("CreationUser");
  $user->setEmail("CreationUser@gmail.com");  
  UtilisateurController::createUser($user);
  $users = UtilisateurController::readUser(3);
  echo $users->toString();

  //CREATE WITH ID
  $user->setPseudo("CreationUserID");
  $user->setEmail("CreationUserID@gmail.com");  
  $user->setId(5);
  UtilisateurController::createUser($user);
  $users = UtilisateurController::readUser(5);
  echo $users->toString();
  
  //DELETE
  UtilisateurController::deleteUser(5);

?>