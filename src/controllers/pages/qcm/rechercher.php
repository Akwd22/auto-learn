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
$qcm = null;
          
//on réinitialise les valeurs (bouton reset)
if(isset($_POST['reset'])){
    $search='';
    $selectedCheckbox=false;
    $selectedCat=null;
}





if (isset($_POST['apply'])) {
    if($selectedCat==1)
        {$selectedCat=null;}
    if(!$selectedCheckbox)
        {
        $qcm = $crud->readQcmFiltres($search, (int)$selectedCat);
        }
    
    if($selectedCheckbox)
        {
            $userCRUD = new UtilisateurCRUD($conn);
            $userId=SessionManagement::getUserId();
            $user = $userCRUD->readUserById($userId);
            $qcmTentative=$user->getAllQcmTentes();
            $qcmTemp;$count=0;
            for($i=0;$i<count($qcmTentative);$i++)
            {
                if($qcmTentative[$i]->getIsTermine())
                {
                    $qcm[$count]=$qcmTentative[$i]->getQcm();
                    $count++;
                }
            }
        }
} 
else{
    $qcm = $crud->readAllQcm();
}





afficherQcm($qcm, $search, +$selectedCat, $selectedCheckbox);
