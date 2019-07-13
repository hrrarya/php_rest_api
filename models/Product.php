<?php

class Product
{
    private $pdo = null;
    private $stmt = null;

    public $id;
    public $name;
    public $image;
    public $description;
    public $phone;
    public $address;
    public $email;


    function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . HOST . ';dbname=' . NAME, USER, PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    function __destruct()
    {
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
    }

    public function read()
    {
        $query = "SELECT * FROM contact";
        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->execute();

        return $this->stmt;
    }

    function read_single($id)
    {
        $query = "SELECT
            c.name as category_name,p.id,p.name,p.description,p.price, p.category_id ,p.created
            FROM products p
            LEFT JOIN 
                categories c
                    ON p.category_id = c.id
            WHERE p.id=?
            LIMIT 0,1";

        $this->stmt = $this->pdo->prepare($query);
        $this->stmt->bindParam(1, $id);
        $this->stmt->execute();

        return $this->stmt;
    }
    function get_input($var)
    {
        $var = htmlspecialchars($var);
        $var = strip_tags($var);
        $var = trim($var);
        return $var;
    }
    function create()
    {

        $query = "INSERT INTO products SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

        $this->stmt = $this->pdo->prepare($query);

        $this->name = $this->get_input($this->name);
        $this->description = $this->get_input($this->description);
        $this->price = $this->get_input($this->price);
        $this->category_id = $this->get_input($this->category_id);
        $this->created = $this->get_input($this->created);

        $this->stmt->bindParam(':name', $this->name);
        $this->stmt->bindParam(':description', $this->description);
        $this->stmt->bindParam(':price', $this->price);
        $this->stmt->bindParam(':category_id', $this->category_id);
        $this->stmt->bindParam(':created', $this->created);

        if ($this->stmt->execute()) {
            return true;
        }

        return false;
    }

    function update()
    {
        $query = "UPDATE 
                    products 
                SET name=:name,description=:description,price=:price,category_id=:category_id 
                WHERE id=:id";
        $this->stmt = $this->pdo->prepare($query);

        $this->id = $this->get_input($this->id);
        $this->name = $this->get_input($this->name);
        $this->description = $this->get_input($this->description);
        $this->price = $this->get_input($this->price);
        $this->category_id = $this->get_input($this->category_id);

        $this->stmt->bindParam(':name', $this->name);
        $this->stmt->bindParam(':description', $this->description);
        $this->stmt->bindParam(':price', $this->price);
        $this->stmt->bindParam(':category_id', $this->category_id);
        $this->stmt->bindParam(':id', $this->id);

        if ($this->stmt->execute()) {
            return true;
        }

        return false;
    }
}
