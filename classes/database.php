<?php
require_once("classes/userdatabase.php");
require_once('vendor/autoload.php');


class Database
{
    public $pdo;
    private $userdatabase;
    function getuserdatabase()
    {
        return $this->userdatabase;
    }

    function __construct()
    {
        $host = $_ENV["host"];
        $db   = $_ENV["db"];
        $user = $_ENV["user"];
        $pass = $_ENV["pass"];
        $PORT = $_ENV["PORT"];


        $dsn = "mysql:host=$host:$PORT;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->initDatabase();

        $this->userdatabase = new UserDatabase($this->pdo);
        $this->userdatabase->setupUsers();
        $this->userdatabase->seedUsers();
    }


    function initDatabase()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS UserDetails (
                id INT PRIMARY KEY,
                name VARCHAR(50),
                street VARCHAR(50),
                postalCode VARCHAR(20),
                city VARCHAR(50)
            )');
    }

    function addUserDetails($id, $name, $street, $postalCode, $city)
    {
        $query = $this->pdo->prepare("INSERT INTO UserDetails (id, name, street,  postalCode, city) VALUES (:id, :name, :street, :postalCode, :city)");
        $query->execute([
            "id" => $id,
            "name" => $name,
            "street" => $street,
            "postalCode" => $postalCode,
            "city" => $city
        ]);
    }

    public function getUserDetailsById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM UsersDetails WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
