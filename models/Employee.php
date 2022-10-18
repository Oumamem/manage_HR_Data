<?php
class Employee
{
    //Les methodes et propriétés necessaires à la gestion de la table employee
    private $table = "employees";
    private $connexion = null;
    
    //propriétés de l'objet employee
    public $employee_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $hire_date;
    public $job_id;
    public $salary;
    public $manager_id;
    public $department_id;

    public function __construct($db)
    {
        //connexion BD de façon dynamique
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
    
    }
    public function readAll()
    {
        // On ecrit la requete
        $sql = "SELECT e.first_name, e.last_name, e.email, e.hire_date, j.job_title, d.department_name from $this->table e LEFT JOIN jobs j ON e.job_id = j.job_id LEFT JOIN departments d ON d.department_id = e.department_id ";
        // On éxecute la requête
        $req = $this->connexion->query($sql);
        // On retourne le resultat
        return $req;
    }
    public function create()
    {
        $sql = "INSERT INTO $this->table(first_name,last_name,email, hire_date,job_id,salary, manager_id, department_id, phone_number) VALUES(:first_name,:last_name,:email, :hire_date,:job_id,:salary, :manager_id, :department_id, :phone_number)";

        // Préparation de la réqête
        $req = $this->connexion->prepare($sql);


        // éxecution de la reqête
        $re = $req->execute([
            ":first_name" => $this->first_name,
            ":last_name" => $this->last_name,
            ":email" => $this->email,
            ":hire_date" => $this->hire_date,
            ":job_id" => $this->job_id,
            ":salary" => $this->salary,
            ":manager_id" => $this->manager_id,
            ":department_id" => $this->department_id,
            ":phone_number" => $this->phone_number
        ]);

        if ($re) {
            return true;
        } else {
            return false;
        }
    }
    public function update()
    {
        $sql = "UPDATE "
                .$this->table ."
            SET 
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                hire_date = :hire_date,
                job_id = :job_id,
                salary = :salary,
                manager_id = :manager_id,
                department_id = :department_id,
                phone_number = :phone_number 

            WHERE 

                employee_id=:employee_id";

        // Préparation de la réqête
        $req = $this->connexion->prepare($sql);

        // éxecution de la reqête
        $re = $req->execute([
            ":employee_id" => $this->employee_id,
            ":first_name" => $this->first_name,
            ":last_name" => $this->last_name,
            ":email" => $this->email,
            ":hire_date" => $this->hire_date,
            ":job_id" => $this->job_id,
            ":salary" => $this->salary,
            ":manager_id" => $this->manager_id,
            ":department_id" => $this->department_id,
            ":phone_number" => $this->phone_number
        ]);
        if ($re) {
            return true;
        } else {
            return false;
        }
    }public function delete()
    {
        $sql = "DELETE FROM $this->table WHERE employee_id = :employee_id";
        $req = $this->connexion->prepare($sql);

        $re = $req->execute(array(":employee_id" => $this->employee_id));

        if ($re) {
            return true;
        } else {
            return false;
        }
    }
    public function readOne($id)
    {
        // On ecrit la requete
        $sql = "SELECT e.first_name, e.last_name, e.email, e.hire_date, j.job_title, d.department_name from $this->table e LEFT JOIN jobs j ON e.job_id = j.job_id LEFT JOIN departments d ON d.department_id = e.department_id WHERE employee_id=$id";
        // On éxecute la requête
        $req = $this->connexion->query($sql);
        // On retourne le resultat
        return $req;
    }
    


}
?>