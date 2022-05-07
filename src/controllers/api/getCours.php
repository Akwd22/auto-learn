<?php
require_once("databases/DatabaseManagement.php");
require_once("databases/CoursCRUD.php");

$conn = new DatabaseManagement();
$crud = new CoursCRUD($conn);

$response = [];

foreach ($crud->readAllCours() as $cours) {
  $response[] = [
    "id"    => $cours->getId(),
    "titre" => $cours->getTitre(),
  ];
}

Header("Content-Type: application/json");

echo json_encode($response, JSON_PRETTY_PRINT);
