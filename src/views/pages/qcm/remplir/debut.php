<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>
<?php require 'views/components/progressBar/progressBar.php'; ?>

<html>

            <?php 
            /**
             * Afficher la page de début d'un QCM.
             * @param QCM $qcm QCM concerné.
             * @return void
             */
            function afficherQcmDebut(QCM $qcm)
            {
            ?>

<head>
    <?php infoHead('QCM', 'début du QCM', '/views/pages/qcm/remplir/debut.css'); ?>
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
                <div id="divProgressBar">
                          <?php createProgressBar('progressBar','s'); ?>
                </div>

                <div id="containerInfo">
                    
                    <div>
                      <h1 id="titleQcm"><?php echo $qcm->getTitre(); ?></h1>
                      <p id="nbQuestion"><?php echo $qcm->nbQuestions(); ?> question(s)</p>
                    </div>
                    <p id="descriptionQcm"><?php echo $qcm->getDescription(); ?></p>

                    <div id="divButtons">
                      <div id="divStart">
                        <form method="POST">
                            <input class="default s" id="start" type="submit" name="start" value="Commencer">
                        </form>
                      </div>

                      <div id="divEdit">
                              <?php
                                  $visible='invisible';
                                  if (SessionManagement::isAdmin()){$visible='visible';}
                              ?>
                              <input class="default s <?php echo $visible?>" id="edit" type="button" name="edit" value="Modifier le QCM" onclick="window.location.href = '/qcm/edition?id=<?php echo $qcm->getId(); ?>'">
                      </div>
                    </div> 
                          
                </div>
            </div>

        </main>
    </div>
    <?php createFooter(); ?>

</body>


<?php } ?>