<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';
require 'views/components/message/message.php';
?>

<?php
/**
 * Afficher la page de la liste des utilisateurs.
 *
 * @param Utilisateur[] $users Tableau des utilisateurs recherchés.
 * @param string $lastSearch Dernière recherche du champ de recherche.
 * @return void
 */
function afficherUtilisateurs(array $users, string $lastSearch)
{
  $lastSearch = htmlspecialchars($lastSearch);
?>

  <head>
    <?php infoHead('Rechercher des utilisateurs', 'Rechercher des utilisateurs', '/views/pages/utilisateurs/utilisateurs.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
  </head>

  <body>
    <div id="mainContainer">
      <header>
        <?php createrNavbar(); ?>
      </header>


      <main class="content">
        <div id="centerDiv">


          <form method="GET">
            <div id="labelSearchDiv">
              <label id="labelSearch" for="site-search" name="site-search">Gestion des utilisateurs</label>
            </div>
            <input class="input l" type="search" id="site-search" name="site-search" value="<?php echo $lastSearch; ?>" placeholder="Rechercher un pseudo, e-mail, etc.">
            <input id="invisibleButton" type="submit" id='sub' name="sub" value="Rechercher">
          </form>

          <table>
            <thead>
              <tr>
                <th class="smallColumn">Identifiant</th>
                <th class="smallColumn">Pseudo</th>
                <th>Email</th>
              </tr>
            </thead>

            <tbody>

              <?php
              for ($i = 0; $i < count($users); $i++) {
                $userId = htmlspecialchars($users[$i]->getId());
                $pseudo = htmlspecialchars($users[$i]->getPseudo());
                $email = htmlspecialchars($users[$i]->getEmail());

                echo "<tr>";
                echo "<td>" . $userId . "</td>";
                echo "<td>" . $pseudo . "</td>";
                echo "<td><div class=\"mail divRow\">" . $email . "</div>";
                echo "<div class=\"divRow profilButtons\"><input class=\"default xs\" type=\"button\" value=\"Profil\" onclick=\"window.location.href = '/profil?id=" . $userId . "'\"></div>";
                echo "<div class=\"divRow settingButtons\"><input class=\"outline xs\" type=\"button\" value=\"Paramètres\" onclick=\"window.location.href = '/profil/modifier?id=" . $userId . "'\"></div>";
                echo "</td></tr>";
              }
              ?>

            </tbody>
          </table>


        </div>
      </main>
    </div>
    <?php createFooter(); ?>

  </body>


<?php } ?>