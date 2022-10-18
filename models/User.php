<?php
include_once '../../config/Database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;
class User
{
    public function __construct($db)
    {
        //connexion BD de façon dynamique
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
        
    }
    //Les methodes et propriétés necessaires à la gestion de la table jobs
    private $table = "Users";
    private $connexion = null;

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;

    public function create()
    {
        $sql = "INSERT INTO " . $this->table. "
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                password = :password";
        // Préparation de la réqête
        $stmt = $this->connexion->prepare($sql);
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $re = $stmt->execute([
            ":first_name" => $this->first_name,
            ":last_name" => $this->last_name,
            ":email" => $this->email,
            ":password" => $password_hash
        ]);

        $re = $stmt->execute();

        if ($re) {
            return true;
        } else {
            return false;
        }
    }
    public function login()
    {
        $sql = "SELECT id, first_name, last_name, password FROM " . $this->table . " WHERE email = ? LIMIT 0,1";
        // Préparation de la réqête
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            var_dump($this->password);
            $id = $row['id'];
            $firstname = $row['first_name'];
            $lastname = $row['last_name'];
            $password2 = $row['password'];
        
            if(password_verify($this->password, $password2))
            {
                $secret_key = "YOUR_SECRET_KEY";
                $issuer_claim = "localhost"; // this can be the servername
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                $expire_claim = $issuedat_claim + 60; // expire time in seconds
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $id,
                        "first_name" => $firstname,
                        "last_name" => $lastname,
                        "email" => $this->email
                ));
                var_dump($token);
        
                $jwt = JWT::encode($token, $secret_key,'HS256');
                return true;
            }else{
                return false;
            }
        }

    
        
    }
    
}
?>
