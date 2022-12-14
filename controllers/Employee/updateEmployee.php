<?php
//les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: PUT");

require_once '../../config/Database.php';
require_once '../../models/Employee.php';
//On instancie la BD 
$database= new Database();
$db= $database->getConnexion();
if ($_SERVER['REQUEST_METHOD'] === "PUT") {

    // On instancie l'objet employee
    $employee = new Employee($db);
    if (isset($_GET['employee_id']) && $_GET['employee_id']!="") {
    // On récupère les infos envoyées
        $data = json_decode(file_get_contents("php://input"));
        $employee_id = $_GET['employee_id'];
        var_dump($employee->readOne($employee_id)->rowCount());
        if(!$employee->readOne($employee_id)->rowCount()>0){
            http_response_code(503);
            echo json_encode(['message' => "Pas d'id correspond à votre recherche"]);
        }else if (!empty($data->first_name) && !empty($data->last_name) && !empty($data->email) && !empty($data->hire_date) && !empty($data->salary) && !empty($data->job_id)) {        
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
    
            $result = $employee->update($employee_id);
            if ($result) {
                http_response_code(201);
                echo json_encode(['message' => "employee a été modifié avec sucès"]);
            } else {
                http_response_code(503);
                echo json_encode(['message' => "La modification de l'employee a échoué"]);
            }
            }

        
    } else {
        echo json_encode(['message' => "Vous n'avez pas préciser l'id de l'employee"]);
    }
}else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}