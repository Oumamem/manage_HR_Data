<?php
include_once '../../config/Database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once '../../models/User.php';
//On instancie la BD 
$database= new Database();
$db= $database->getConnexion();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user = new User($db);
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->email) && !empty($data->password) ) {
        // On hydrate l'objet User
        $user->email = htmlspecialchars($data->email);
        $user->password = htmlspecialchars($data->password);
        $statement = $user->login();
        if ($statement) {
            http_response_code(201);
            echo json_encode(['message' => "User connecté avec sucès"]);
        } else {
            http_response_code(503);
            echo json_encode(['message' => "La connx de l'User a échoué"]);
        }

    }else {
        echo json_encode(['message' => "Les données ne sont au complet"]);
    }
}else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}
