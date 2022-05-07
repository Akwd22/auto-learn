<?php
require_once("controllers/utils.php");
require_once("databases/SessionManagement.php");
require_once("databases/QcmCRUD.php");
require_once("views/pages/qcm/rechercher/rechercher.php");

SessionManagement::session_start();

/* -------------------------------------------------------------------------- */
/*                                Vérifications                               */
/* -------------------------------------------------------------------------- */

$isLogged = SessionManagement::isLogged();

/* ---------------------- Vérification des permissions ---------------------- */
if (!$isLogged) redirect("/connexion", "error", "Vous devez être connecté.");

/* -------------------------------------------------------------------------- */
/*                            Rechercher les QCM                              */
/* -------------------------------------------------------------------------- */

$conn = new DatabaseManagement();
$crud = new QcmCRUD($conn);


//on recupère les valeurs (bouton submit)
$search = isset($_GET["titre"]) ? $_GET["titre"] : "";
$selectedCheckbox = isset($_GET['showCompleted']) ? $_GET["showCompleted"] : "";
$selectedCat = isset($_GET['categorie']) ? $_GET["categorie"] : "";
$qcm = [];
          
//on réinitialise les valeurs (bouton reset)
if(isset($_GET['reset'])){
    $search='';
    $selectedCheckbox=false;
    $selectedCat=null;
}

//récupére les tentatives de QCM de l'utilisateur connecté
$userCRUD = new UtilisateurCRUD($conn);
$qcmTentative=$userCRUD->readUserById(SessionManagement::getUserId())->getAllQcmTentes();



if (isset($_GET['apply'])) {
    if($selectedCat==1)
        {$selectedCat=null;}

        $qcmFiltre = $crud->readQcmFiltres($search, (int)$selectedCat);
      
    if($selectedCheckbox)
        {
            $count=0;
            for($i=0;$i<count($qcmTentative);$i++)
            {
                for ($j=0;$j<count($qcmFiltre);$j++)
                {       //crée une liste des QCM en commun entre les tentatives terminés de l'utilisateurs, et les QCM obtenu grâce aux filtres
                        if($qcmTentative[$i]->getIsTermine() &&  $qcmTentative[$i]->getQcm()->getId()==$qcmFiltre[$j]->getId())
                        {
                            $qcm[$count]=$qcmFiltre[$j];
                            $count++;
                        }
                }
            }
        }
    else
        {   
            $count=0;
            for($i=0;$i<count($qcmTentative);$i++)
            {
                for ($j=0;$j<count($qcmFiltre);$j++)
                {       //enlève de la liste les qcm terminé par l'utilisateur courant
                        if($qcmTentative[$i]->getIsTermine() &&  $qcmTentative[$i]->getQcm()->getId()==$qcmFiltre[$j]->getId())
                        {
                            array_splice($qcmFiltre,$j,1);                            
                        }
                }
            }
            $qcm=$qcmFiltre;
        }
} 
else{
    $allQcm = $crud->readAllQcm();
    for($i=0;$i<count($qcmTentative);$i++)
    {
        for ($j=0;$j<count($allQcm);$j++)
        {       //enlève de la liste les qcm terminé par l'utilisateur courant
                if($qcmTentative[$i]->getIsTermine() &&  $qcmTentative[$i]->getQcm()->getId()==$allQcm[$j]->getId())
                {
                    array_splice($allQcm,$j,1);                            
                }
        }
    }
    $qcm=$allQcm;
}





afficherQcm($qcm, $search, +$selectedCat, $selectedCheckbox);