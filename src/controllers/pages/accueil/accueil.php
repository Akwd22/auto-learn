<?php
require_once('databases/SessionManagement.php');
require_once('config.php');
SessionManagement::session_start();

include("views/pages/accueil/accueil.php");
