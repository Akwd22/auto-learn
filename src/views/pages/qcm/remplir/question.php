<?php require 'views/components/header/header.php'; ?>
<?php require 'views/components/footer/footer.php'; ?>
<?php require 'views/components/checkbox/checkbox.php'; ?>
<?php require 'views/components/message/message.php'; ?>
<?php require 'views/components/radio/radio.php'; ?>
<?php require 'views/components/progressBar/progressBar.php'; ?>

<html>

        <?php 

            /**
             * Afficher la page de fin d'un QCM.
             * @param QCM $qcm QCM concerné.
             * @param QuestionChoix|QuestionSaisie $question Question actuelle.
             * @param TentativeQCM $tentative Tentative du QCM concerné (contient les infos. sur la progression).
             * @return void
             */
            function afficherQcmQuestion(QCM $qcm, QuestionQCM $question, TentativeQCM $tentative)
            {
              $choix = function () use (&$question) {
                foreach ($question->getAllChoix() as $choix) {
                  $idChoix = $choix->getId();
            
                  if ($question->getIsMultiple()) {
                    createCheckbox('choix-'.$idChoix,'choix-'.$idChoix, $choix->getIntitule(),'m','','','');
                  } else {
                    createRadio('choix-'.$idChoix,'choix',$choix->getIntitule(),$idChoix,'m','','');
                  }
                }
              };

              $saisie = function () use (&$question) {
                $placeholder = htmlspecialchars($question->getPlaceHolder(), ENT_QUOTES);
                echo "<input class='input m' type=text name=response placeholder='$placeholder'>";
              };

        ?>

<head>
    <?php infoHead('Question du QCM', 'Question du QCM', '/views/pages/qcm/remplir/question.css'); ?>
    <link rel="stylesheet" type="text/css" href="/views/components/header/header.css">
    <link rel="stylesheet" type="text/css" href="/views/components/footer/footer.css">
</head>

<body>
    <div id="mainContainer">
        <header>
            <?php createrNavbar(); ?>
        </header>

        <main class="content">
        <form method="POST">

            <div id="leftDiv">
              <div id="restartDiv">
                <input class="default s" id="restart" type="submit" name="restart" value="Recommencer le QCM">
              </div>
            </div>



            <div id="centerDiv">


                <div id="divProgressBar">
                          <?php createProgressBar('progressBar','s'); ?>
                </div>              

                <div id="containerQuestion">
                  
                    <div>
                        <h1 id="titleQcm"><?php echo $qcm->getTitre(); ?></h1>
                        <p id="nbPoint"><?php echo $question->getPoints(); ?> point(s)</p>
                    </div>
                    <p id="question"><?php echo $question->getQuestion(); ?></p>


                    <div id="answerDiv">
                        <?php
                            if ($question::TYPE === EnumTypeQuestion::CHOIX)
                              $choix();
                            else
                              $saisie();
                        ?>
                    </div>

                    <div id="buttonDiv">
                        <div id="leftButtonDiv">
                            <div id="submitDiv">
                              <input class="default s" id="next" type="submit" name="next" value="Question suivante">
                            </div>
                            <p id="score">Score: <?php echo $tentative->getPointsActuels()."/".$qcm->getTotalPoints(); ?></p>
                        </div>
                        <div id="rightButtonDiv">
                          <div id="skipDiv">
                            <input id="skip" type="submit" name="skip" value="Ignorer la question">
                          </div>
                        </div>
                    </div>

                </div>


            </div>

        </form>
        </main>
    </div>
    <?php createFooter(); ?>

    <script src="../views/components/progressBar/progressBar.js"></script>
    <script><?php $p=(int)($tentative->getNumQuestionCourante()-1)*100/$qcm->nbQuestions();echo "fillProgressBar('".$p."');"; ?></script>
</body>


</html>
<?php } ?>