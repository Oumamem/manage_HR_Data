<?php
//les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: DELETE");

require_once '../../config/Database.php';
require_once '../../models/Employee.php';
//On instancie la BD 
$database= new Database();
$db= $database->getConnexion();
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    // On instancie l'objet etudiant
    $employee = new Employee($db);
    if (isset($_GET['employee_id']) && $_GET['employee_id']!="") {
        
        // On récupère les infos envoyées
        $employee_id = $_GET['employee_id'];

        if ($employee->delete($employee_id)) {
            http_response_code(200);
            echo json_encode(array("message" => "La suppression a été éffectué avec sucèss"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "La suppression n'a été éffectué"));
        }
    
    }else {
        echo json_encode(['message' => "Vous devez precisé l'identifiant de l'employee"]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}