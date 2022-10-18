<?php
class Job
{
    //Les methodes et propriétés necessaires à la gestion de la table jobs
    private $table = "jobs";
    private $connexion = null;
    
    //propriétés de l'objet employee
    public $job_id;
    public $job_title;
    public $min_salary;
    public $max_salary;

    public function __construct($db)
    {
        //connexion BD de façon dynamique
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
    }
    public function readAll($offset, $row_count)
    {
        // On ecrit la requete
        $sql = "SELECT j.job_title, j.min_salary, j.max_salary from $this->table j LIMIT $offset , $row_count;";
        // On éxecute la requête
        $req = $this->connexion->query($sql);
        // On retourne le resultat
        return $req;
    }
    public function readOne($id)
    {
        // On ecrit la requete
        $sql = "SELECT j.job_title, j.min_salary, j.max_salary from $this->table j WHERE job_id = $id;";
        // On éxecute la requête
        $req = $this->connexion->query($sql);
        // On retourne le resultat
        return $req;
    }
}
?>