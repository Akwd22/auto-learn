<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/checkbox/checkbox.php';
require 'views/components/message/message.php';
require 'views/components/radio/radio.php';

/**
 * Afficher la page de modification d'un profil.
 *
 * @param Utilisateur $user Utilisateur du profil à modifier.
 * @return void
 */
function afficherModifierProfil(Utilisateur $user)
{
?>

  <head>
    <?php infoHead('Modifier le profil', 'Modifier le profil', '/views/pages/profil/modifier/modifier.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
  </head>

  <body>
    <div id="mainContainer">
      <header>
        <?php createrNavbar(); ?>
      </header>
      <main class="page parametre-page">

        <div class="parametre-container">

          <form class="parametre-container-form" action="/profil/modifier?id=<?php echo htmlspecialchars($user->getId()) ?>" method="post" enctype="multipart/form-data">
            <h2 class="parametre-container-title">Paramètres</h2>
            <div class="parametre-message-container">
              <?php createMessage(); ?>
            </div>
            <div class="parametre-container-form-content">

              <!-- EMAIL -->
              <div class="form-email-container form-log-item">
                <label for="email">Nouveau e-mail</label>
                <input class="input l" type="email" name="email" id="email" value="<?php echo htmlspecialchars($user->getEmail()) ?>" placeholder="Saisir un nouveau e-mail">
              </div>

              <!-- MOT DE PASSE -->
              <div class="form-password-container form-log-item">
                <label for="pass">Nouveau mot de passe</label>
                <input class="input l" type="password" name="pass" id="pass" placeholder="*********">
              </div>

              <!-- IMAGE -->
              <div class="form-image-container">
                <label for="image" id='new-image' class="label-input-file">Nouvelle image</label>
                <input type="file" name="image" id="image" accept="image/png, image/jpeg">
              </div>
            </div>

            <!-- IS ADMIN -->
            <div class="form-admin-container">
              <?php
              if (SessionManagement::isAdmin()) {
                $checked = 'unchecked';
                if ($user->getIsAdmin()) {
                  $checked = 'checked';
                }
                createCheckbox('form-admin-container-checkbox', 'admin', 'Est-il admin ?', 'm','', 'enabled', $checked);
              }
              ?>
            </div>

            <!-- SUBMIT -->
            <input class="default m" type="submit" id="submit" value="Modifier le profil">

          </form>
        </div>


        <div class="delete-container">
          <form class="delete-container-form" action="/profil/supprimer?id=<?php echo htmlspecialchars($user->getId()) ?>" method="post">
            <h2 class="delete-container-title">Supprimer le compte</h2>
            <input class="default s" type="submit" id="delete-btn" value="Supprimer">
          </form>
        </div>


      </main>
    </div>
    <?php createFooter(); ?>

  </body>
<?php
}
