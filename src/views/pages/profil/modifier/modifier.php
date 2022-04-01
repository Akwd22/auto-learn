<?php

/**
 * Afficher la page de modification d'un profil.
 *
 * @param Utilisateur $user Utilisateur du profil à modifier.
 * @return void
 */
function afficherModifierProfil(Utilisateur $user)
{
  echo "<h1>Page de modification du profil</h1>";

  var_dump($user);

  if (isset($_GET["error"])) echo "<p style='color:red'>" . $_GET["error"] . "</p>";
  if (isset($_GET["success"])) echo "<p style='color:green'>" . $_GET["success"] . "</p>";

?>
  <form action="/profil/modifier?id=<?php echo $user->getId() ?>" method="post" enctype="multipart/form-data">
    <h2>Modifier le profil</h2>
    <label for="email">Nouveau e-mail</label>
    <input type="email" name="email" id="email" value="<?php echo $user->getEmail() ?>">
    <br>
    <label for="pass">Nouveau mot de passe</label>
    <input type="password" name="pass" id="pass">
    <br>
    <label for="image">Nouvelle image</label>
    <input type="file" name="image" id="image">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <br>
    <input type="radio" name="theme" id="theme-light" value="light" <?php if ($user->getTheme() === EnumTheme::CLAIR) echo "checked" ?>>
    <label for="theme-light">Thème clair</label>
    <input type="radio" name="theme" id="theme-dark" value="dark" <?php if ($user->getTheme() === EnumTheme::SOMBRE) echo "checked" ?>>
    <label for="theme-dark">Thème sombre</label>
    <br>
    <?php
    if (SessionManagement::isAdmin()) {
    ?>
      <input type="checkbox" name="admin" id="admin" <?php if ($user->getIsAdmin())  echo "checked" ?>>
      <label for="admin">Admin ?</label>
      <br>
    <?php
    }
    ?>
    <input type="submit" name="submit" value="Modifier le profil">
  </form>

  <form action="/profil/supprimer?id=<?php echo $user->getId() ?>" method="post">
    <h2>Supprimer le profil</h2>
    <input type="submit" name="submit" value="Supprimer" />
  </form>
<?php
}
