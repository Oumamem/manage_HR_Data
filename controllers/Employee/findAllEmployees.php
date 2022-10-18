<?php
//les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once '../../config/Database.php';
require_once '../../models/Employee.php';
//On instancie la BD 
$database= new Database();
$db= $database->getConnexion();
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    
    //Instancier l'objet Employee
    $employee= new Employee($db);
    //Récupération des données
    $statement = $employee->readAll();
    if ($statement->rowCount() > 0) {
        $data = [];
        $data[] = $statement->fetchAll();
        // on renvoie ses données sous format json
        http_response_code(200);
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "Aucune données à renvoyer"]);
    }
}else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}