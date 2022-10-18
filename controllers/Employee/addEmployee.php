<?php
//les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once '../../config/Database.php';
require_once '../../models/Employee.php';
//On instancie la BD 
$database= new Database();
$db= $database->getConnexion();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    

    //Instancier l'objet Employee
    $employee= new Employee($db);

    // On récupère les infos envoyées
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->first_name) && !empty($data->last_name) && !empty($data->email) && !empty($data->hire_date) && !empty($data->salary) && !empty($data->job_id)) {
        // On hydrate l'objet employee
        $employee->first_name = htmlspecialchars($data->first_name);
        $employee->last_name = htmlspecialchars($data->last_name);
        $employee->email = htmlspecialchars($data->email);
        $employee->job_id = htmlspecialchars($data->job_id);
        $employee->hire_date = htmlspecialchars($data->hire_date);
        $employee->salary = htmlspecialchars($data->salary);
        $employee->phone_number = htmlspecialchars($data->phone_number);
        $employee->manager_id = htmlspecialchars($data->manager_id);
        $employee->department_id = htmlspecialchars($data->department_id);

        $result = $employee->create();
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => "employee ajouté avec sucès"]);
        } else {
            http_response_code(503);
            echo json_encode(['message' => "L'ajout de l'employee a échoué"]);
        }
    } else {
        echo json_encode(['message' => "Les données ne sont au complet"]);
    }
}else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}