<?php
require_once("databases/SessionManagement.php");
require_once("databases/QcmCRUD.php");
require_once("views/pages/qcm/rechercher/rechercher.php");

SessionManagement::session_start();

/* -------------------------------------------------------------------------- */
/*                                Vérifications                               */
/* -------------------------------------------------------------------------- */

$isLogged = SessionManagement::isLogged();

/* ---------------------- Vérification des permissions ---------------------- */
if (!$isLogged) die("Vous devez être connecté.");

/* -------------------------------------------------------------------------- */
/*                            Rechercher les QCM                              */
/* -------------------------------------------------------------------------- */

$conn = new DatabaseManagement();
$crud = new QcmCRUD($conn);


//on recupère les valeurs (bouton submit)
$search = isset($_POST["titre"]) ? $_POST["titre"] : "";
$selectedCheckbox = isset($_POST['showCompleted']) ? $_POST["showCompleted"] : "";
$selectedCat = isset($_POST['categorie']) ? $_POST["categorie"] : "";
$qcm = [];
          
//on réinitialise les valeurs (bouton reset)
if(isset($_POST['reset'])){
    $search='';
    $selectedCheckbox=false;
    $selectedCat=null;
}





if (isset($_POST['apply'])) {
    if($selectedCat==1)
        {$selectedCat=null;}

        $qcmFiltre = $crud->readQcmFiltres($search, (int)$selectedCat);
      
    if($selectedCheckbox)
        {
            $userCRUD = new UtilisateurCRUD($conn);
            //récupére les tentatives de QCM de l'utilisateur connecté
            $qcmTentative=$userCRUD->readUserById(SessionManagement::getUserId())->getAllQcmTentes();
            
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
        else{$qcm=$qcmFiltre;}
} 
else{
    $qcm = $crud->readAllQcm();
}





afficherQcm($qcm, $search, +$selectedCat, $selectedCheckbox);