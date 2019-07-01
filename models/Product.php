<?php

class Product
{
    private $pdo = null;
    private $stmt = null;

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
        $query = "SELECT
            c.name as category_name, p.id,p.name,p.description,p.price, p.category_id ,p.created
            FROM products p
            LEFT JOIN 
                categories c
                    ON p.category_id = c.id
            ORDER BY
                p.created ASC";
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
}
