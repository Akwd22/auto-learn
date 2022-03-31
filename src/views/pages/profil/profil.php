<?php
function afficherProfil(Utilisateur $user)
{
  echo "Page de profil";

  var_dump($user);

  if (isset($_GET["error"])) echo "<p style='color:red'>" . $_GET["error"] . "</p>";
  if (isset($_GET["success"])) echo "<p style='color:green'>" . $_GET["success"] . "</p>";
?>
  <form action="/controllers/utilisateurControllers/UtilisateurModifierProfil.php?id=<?php echo $user->getId() ?>" method="post" enctype="multipart/form-data">
    <h1>Modifier le profil</h1>
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

  <form action="/controllers/utilisateurControllers/UtilisateurSuppression.php?id=<?php echo $user->getId() ?>" method="post">
    <h1>Supprimer le profil</h1>
    <input type="submit" name="submit" value="Supprimer" />
  </form>
<?php
}
