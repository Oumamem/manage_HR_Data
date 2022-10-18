<?php
//cette classe va nous permettre de se connecter à la BD
class Database
{
    //propriétés de connexion à la BD
    private $host= 'localhost';
    private $dbname = "Carte_Blanche";
    private $username = "root";
    private $password = "root";
    //connexion à la bd
    public function getConnexion()
    {
        $conn = null;

        try {
            $conn = new PDO(
                "mysql:host=$this->host;
                dbname=$this->dbname;
                charset=utf8",
                $this->username,
                $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        } catch (\PDOException $e) {
            echo "Erreur de connexion:".$e->getMessage();
        }
        return $conn;
    }
    
}
?>