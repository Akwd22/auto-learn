<?php
require 'views/components/header/header.php';
require 'views/components/footer/footer.php';   
?>

<head>
    <?php infoHead('Gestion utilisateur', 'gestion des utilisateurs', '/views/pages/utilisateurs/utilisateurs.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
</head>

<body>
    <header>
        <?php createrNavbar(); ?>
    </header>

    <div id="container">
    <main class="content">
      <div id="centerDiv">    
      
      

      <!--debut fonction -->
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
      ?>
      


        <form method="POST">
          <div id="labelSearchDiv">
              <label id="labelSearch" for="site-search" name="site-search">Gestion des utilisateurs</label>
          </div>
          <input class="input l" type="search" id="site-search" name="site-search" value="<?php echo $lastSearch; ?>" placeholder="Rechercher nom, email, ...">
          <input id="invisibleButton" type="submit" id='sub' name="sub" value="Rechercher">
        </form>

        <table>
            <thead>
              <tr>
                <th class="smallColumn">Identifiant</th>
                <th class="smallColumn">pseudo</th>
                <th>Email</th>
              </tr>
            </thead>
            
            <tbody>
              
              <?php
    
                for ($i=0; $i<count($users); $i++) {
                  echo "<tr>";
                  echo "<td>".$users[$i]->getId()."</td>";
                  echo "<td>".$users[$i]->getPseudo()."</td>";
                  echo "<td><div class=\"mail divRow\">".$users[$i]->getEmail()."</div>";
                  echo "<div class=\"divRow settingButtons\"><input class=\"outline xs\" type=\"button\" value=\"Paramètres\"></div>";
                  echo "<div class=\"divRow profilButtons\"><input class=\"default xs\" type=\"button\" value=\"Profil\"></div>";




                  echo "</td></tr>";
                }
              ?>

            </tbody>
        </table>





      </div>


              
              
    </main>
    <?php  createFooter(); ?>
              </div>
  </body>
  
      
      
      <?php  
       
        }
      ?>

    



