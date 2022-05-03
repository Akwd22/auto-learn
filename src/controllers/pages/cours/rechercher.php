<?php
require_once("controllers/utils.php");
require_once "databases/CoursCRUD.php";
require_once "databases/SessionManagement.php";
require_once "views/pages/cours/rechercher/rechercher.php";

SessionManagement::session_start();

/* -------------------------------------------------------------------------- */
/*                                Vérifications                               */
/* -------------------------------------------------------------------------- */

$isLogged = SessionManagement::isLogged();

/* ---------------------- Vérification des permissions ---------------------- */
if (!$isLogged) redirect("/connexion", "error", "Vous devez être connecté.");


/* -------------------------------------------------------------------------- */
/*                            Rechercher les cours                            */
/* -------------------------------------------------------------------------- */

// Effectuer la recherche et afficher les cours.
$conn = new DatabaseManagement();
$coursCRUD = new CoursCRUD($conn);

//on recupère les valeurs (bouton submit)
$search = isset($_POST["site-search"]) ? $_POST["site-search"] : "";
$selectedRadio = isset($_POST['radioCours']) ? $_POST["radioCours"] : "";
$selectedCat = isset($_POST['selectCat']) ? $_POST["selectCat"] : "";
$cours = null;
          
//on réinitialise les valeurs (bouton reset)
if(isset($_POST['reset'])){
    $search='';
    $selectedRadio=null;
    $selectedCat=null;
}



if (isset($_POST['sub'])) {
    if($selectedCat==1)
        {$selectedCat=null;}
    $cours = $coursCRUD->readCoursFiltres($search, $selectedRadio, (int)$selectedCat);
} 
else{
    $cours = $coursCRUD->readAllCours();
}

// Affichage de la vue.
afficherCours($cours, $search, $selectedRadio, +$selectedCat);



    





                        